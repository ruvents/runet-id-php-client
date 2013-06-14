<?php
/**
 * Created by JetBrains PhpStorm.
 * User: админ
 * Date: 13.06.13
 * Time: 17:14
 * To change this template use File | Settings | File Templates.
 */

namespace RunetID\Api;


class User extends Model
{
  private $RunetId, $LastName, $FirstName, $FatherName, $Email;

  /**
   * АВТОРИЗАЦИЯ ПОЛЬЗОВАТЕЛЯ
   *
   * @param  string $runetIdOrEmailOrToken
   * @param  string $password
   * @return boolean
   */
	public function Login($runetIdOrEmailOrToken, $isToken = false)
  {
		if ($this->IsAuthorized())
		{
			return true;
		}
		$user = (!$isToken) ? CRunetGateUser::Get($runetIdOrEmailOrToken) : CRunetGateUser::GetByToken($runetIdOrEmailOrToken);
    if (!$user)
    {
    	return false;
    }
    $arBitrixUser = CUser::GetList($_, $_, array('LOGIN_EQUAL' => self::GetLoginField($user->RunetId)))->Fetch();

    if (empty($arBitrixUser))
    {
    	$password = md5(microtime());

      $fields = array(
      	'LOGIN' => self::GetLoginField($user->RunetId),
        'NAME'  => $user->FirstName,
        'LAST_NAME' => $user->LastName,
        'EMAIL' => trim($user->Email),
        'PASSWORD' => $password,
        'CONFIRM_PASSWORD' => $password,
				'UF_RUNET' => $user->RunetId
      );

      if (isset($user->Work))
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
    $authResult = $this->user->Authorize($arBitrixUser['ID'], true);
/*
			print 'User:<pre style="font-size: 14px;">';
			var_dump($user);
			print '</pre>';
			print 'BXUser:<pre style="font-size: 14px;">';
			var_dump($arBitrixUser);
			print '</pre>';
			print 'BXAuth:<pre style="font-size: 14px;">';
			var_dump($authResult);
			print '</pre>';
			exit();
*/
    if ($authResult)
    {
    	$this->runetUser = $user;
      return true;
    }
    return false;
  }
}