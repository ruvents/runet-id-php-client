<?php
class CRocidUser
{
    private $user;
    private $rocidUser;
    
    /**
     *
     * @param CUser $user 
     */
    protected function __construct($user)        
    {
        $this->user = $user;
	if ($this->user->IsAuthorized())
	{
	    $bxUser = CUser::GetList($_,$_,array('ID' => $this->user->GetID()), array('SELECT' => array('UF_ROCID')))->Fetch();
	    if ($bxUser['UF_ROCID'] !== 0)
	    {
			$this->rocidUser = CRocidGateUser::Get($bxUser['UF_ROCID']);
	    }
            
            
		if ( CRocidRoleGroupLink::IsActive())
		{
			if ($this->GetRoleId() > 0)
			{
				$roleId = $this->GetRoleId();
			}
			else 
			{
				$roleId = CRocidEvent::GetDefaultRoleId();
			}
			CRocidRoleGroupLink::Instance()->SetUserRole($this->user->GetID(), $roleId);
		}
	}
    }
            
    protected function __clone()     {}
    protected function __wakeup()    {}
    
    /**
     *
     * @var RocidUser 
     */
    private static $instance = null;
    public static function Instance()
    {  
       global $USER;
       if ( self::$instance === null ) 
       {
           self::$instance = new CRocidUser($USER);
       }
       return self::$instance;
    }
    
    /**
     *
     * @param  int $rocid
     * @return string 
     */
    private static function GetLoginField ($rocid) 
    {
        return 'rocid_'.$rocid;
    }
    
    
    public function __call($name, $args) 
    {
        if (method_exists($this->user, $name) )
        {
            return $this->user->$name($args);
        }
    }
    
    /**
     *
     * @param  string $rocidOrEmail
     * @param  string $password
     * @return boolean 
     */
    public function Login ($rocidOrEmail, $password = null) 
    {
        if ($this->IsAuthorized())
        {
            return true;
        }
        
	if ($password !== null) 
	{
	    $user = CRocidGateUser::Login($rocidOrEmail, $password);
	}
	else 
	{
	    $user = CRocidGateUser::Get($rocidOrEmail);
	}
	
        if (!$user) 
        {
            return false;
        }
        
        $arBitrixUser = CUser::GetList($_, $_, array('LOGIN_EQUAL' => self::GetLoginField($user->RocId)))->Fetch();
                  if (empty($arBitrixUser))
                  {
                      $password = md5(microtime());

                      $fields = array(
                          'LOGIN' => self::GetLoginField($user->RocId),
                          'NAME'  => $user->FirstName,
                          'LAST_NAME' => $user->LastName,
                          'EMAIL' => $user->Email,
                          'PASSWORD' => $password,
                          'CONFIRM_PASSWORD' => $password,
          				'UF_ROCID' => $user->RocId
                      );

            if ( isset($user->Work)) 
            {
                $fields['WORK_COMPANY']  = $user->Work->Company->Name;
                $fields['WORK_POSITION'] = $user->Work->Position;
            }
            
            $arBitrixUser['ID'] = $this->user->Add($fields);
            
            if ($arBitrixUser['ID'] === false)
            {
                return false;
            }
			else
			{
				CEvent::Send('NEW_USER', array('s1'), $fields);
			}
        }
        $authResult = $this->user->Authorize($arBitrixUser['ID']);
        if ($authResult)
        {
            $this->rocidUser = $user;
            return true;
        }
        return false;
    }
    
    /**
     *
     * @return boolean 
     */
    public function Reload()
    {
	if ($this->rocidUser === null)
	{
	    return false;
	}
	else
	{
	    $this->rocidUser = CRocidGateUser::Get($this->GetRocId(), 300, true);
            
            if ( CRocidRoleGroupLink::IsActive() 
                    && $this->GetRoleId() > 0)
            {
                CRocidRoleGroupLink::Instance()->SetUserRole(
                        $this->user->GetID(), $this->GetRoleId()
                );
            }
	    return true;
	}
    }
    
    /**
     *
     * @return int 
     */
    public function GetRocId ()
    {
      return $this->rocidUser->RocId;
    }
    
    /**
     *
     * @return string 
     */
    public function GetFatherName ()
    {
			return $this->rocidUser->FatherName;
    }
    
    /**
     *
     * @return int
     */
    public function GetRoleId () 
    {
      if ( !isset ($this->rocidUser->Status))
      {
        return 0;
      }
      return $this->rocidUser->Status->RoleId;
    }
   
    /**
     *
     * @return string 
     */
    public function GetRoleName ()
    {
      if ( !isset ($this->rocidUser->Status))
      {
        return '';
      }
      return $this->rocidUser->Status->RoleName;
    }


    /**
     *
     * @return CRocidPhotoData 
     */
    public function GetPhoto ()
    {
      return $this->rocidUser->Photo;
    }
    
    /**
     *
     * @return string 
     */
    public function GetPosition()
    {
      return $this->rocidUser->Work->Position;
    }
    
    /**
     *
     * @return CRocidCompanyData 
     */
    public function GetCompany()
    {
        return $this->rocidUser->Work->Company;
    }
    
    /**
     *
     * @return bool
     */
    public function IsParticipant ()
    {
      return isset($this->rocidUser->Status);
    }
    
    /**
     *
     * @param string $socialId
     * @param string $socialUserId
     * @return boolean 
     */
    public function SocialConnect($socialId, $socialUserId)
    {
      if (!$this->IsAuthorized())
      {
        return false;
      }
      
      $result = CRocidGate::Instance()->Post('user/social/connect', array(
        'SocialId' => $socialId,
        'SocialUserId' => $socialUserId,
        'RocId' => $this->GetRocId()
      ));
      
      if (isset($result->Error) && $result->Error === true)
      {
        return false;
      }
      else
      {
        return true;
      }
    }
}
