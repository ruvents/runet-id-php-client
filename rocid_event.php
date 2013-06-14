<?php
class CRocidEvent 
{
	/**
	 *
	 * @return array 
	 */
	public static function GetRoles ()
	{
	  $roles = CRocidGate::Instance()->Get('event/role/list', null);
	  $result = array();
	  foreach ($roles as $role) 
	  {
	    $result[ $role->RoleId ] = $role->Name;
	  }
	  return $result;
	}
    
	/**
	 *
	 * @return int 
	 */
	public static function GetDefaultRoleId ()
	{
		return (int) CRocidSettings::DefaultRoleId;
	}
    
	/**
	* Изменение роли на мероприятии
	* 
	* @param int $RocId
	* @param int $RoleId
	* @return bool
	*/
	public static function ChangeRole ($RocId, $RoleId)
	{
		$result = CRocidGate::Instance()->Post('event/changerole', array(
		  'RocId'  => $RocId,
		  'RoleId' => $RoleId
		));
		return $result->Success;
	}
    
	/**
	 * @param  int $RocId
	 * @param  int $RoleId
	 * @return bool  
	 */
	public static function Register ($rocId, $roleId = null)
	{
		if ($roleId === null)
		{
			$roleId = self::GetDefaultRoleId();
		}

		$result = CRocidGate::Instance()->Post('event/register', array(
			'RocId'  => $rocId,
			'RoleId' => $roleId
		));

		if ($result->Success === true)
		{
			$defaultProductId = (int) CRocidPay::GetDefaultProductId();
			if ($defaultProductId > 0)
			{
				CRocidPay::Add($defaultProductId, $rocId);
			}
			return true;
		}
		else
		{
			return false;
		}
	}
   
	/**
	*
	* @param string $query
	* @param int    $roleId
	* @param int    $maxResult
	* @return CRocidUserData[] 
	*/
	public static function Users ($query = '', $roleId = null, $maxResult = 200, $sortBy = 'LastName')
	{
	  $result = array();
	  $pageToken = null;
	   
	  do {
	    $gateResult = CRocidGate::Instance()->Get('event/users', array(
	      'Query'      => $query,
	      'RoleId'     => $roleId,
	      'MaxResults' => $maxResult,
	      'PageToken'  => $pageToken,
	      'SortBy'     => $sortBy
	    ));

	    $pageToken = $gateResult->NextPageToken;

	    $result = array_merge(
	      $result, $gateResult->Users
	    );
	  } 
	  while ($pageToken !== null);
	  return $result;
	}
   
	/**
	*
	* @param string $query
	* @param int    $roleId
	* @param int    $maxResult
	* @return CRocidUserData[] 
	*/
	public static function OnlyUpdateUsers ($updateTime = '', $query = '', $roleId = null)
	{
		$result = array();

	  $gateResult = CRocidGate::Instance()->Get('event/users/updated', array(
	  	'Query'      => $query,
	    'RoleId'     => $roleId,
	    'FromUpdateTime' => $updateTime
	  ));
	  if ($gateResult->Error == 666)
	  {
	  	$result = $this->Users($query, $roleId);
	  }
	  else
	  {
	  	$result = $gateResult->Users;
	  }

	  return $result;
	}
   
	/**
	* Получение информации по секции программы мероприятия
	* 
	* @param int $sectionId
	* @return object
	*/
	public static function GetSection($sectionId)
	{
		$result = CRocidGate::Instance()->Post('event/section/info', array(
			'SectionId' => $sectionId
		));

		if (isset($result->Error) && $result->Error === true)
		{
			return false;
		}
		else
		{
			return $result;
		}
	}
   
	/**
	* Получение списка докладчиков/ведущих в секции
	* 
	* @param int $sectionId
	* @return array
	*/
	public static function GetSectionReports($sectionId)
	{
		$result = CRocidGate::Instance()->Post('event/section/reports', array(
			'SectionId' => $sectionId
		));

		if ( isset($result->Error) && $result->Error === true)
		{
			return false;
		}
		else
		{
			return $result;
		}
	}
   
	/**
	* Получение списка секций по rocID докладчика
	* 
	* @param int $rocId
	* @return array
	*/
	public static function GetUserSections($rocId)
	{
		$result = CRocidGate::Instance()->Post('event/section/user', array(
			'RocId' => $rocId
		));

		if (count($result) == 0)
		{
			return false;
		}
		else
		{
			return $result;
		}
	}
   
	/**
	*
	* @param  int $rocId
	* @param  string[] $events
	* @return boolean 
	*/
	public static function Check ($rocId, $events) 
	{
		$result = CRocidGate::Instance()->Get('event/check', array(
			'Events' => $events,
			'RocId'  => $rocId
		));

		if ( isset($result->Error) && $result->Error === true)
		{
			return false;
		}
		return $result->Check;
	}
}
?>
