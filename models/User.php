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
  private $RunetId;
  private $LastName;
  private $FirstName;
  private $FatherName;
  private $Email;

  /**
   * @param Api $api
   * @return User
   */
  public static function model(Api $api)
  {
    return parent::model($api);
  }

  protected static function getClassName()
  {
    return __CLASS__;
  }

  /**
   * ПОЛУЧЕНИЕ ДАННЫХ ПОЛЬЗОВАТЕЛЯ ПО RunetID
   *
   * @param  int $runetId
   * @param  int $cache
   * @return CRunetUserData
   */
  public function GetByRunetId($runetId, $cache = 300, $resetCache = false)
  {
		$runetId = (int) $runetId;
		if ($runetId === 0)
		{
			return null;
		}
		$result = $this->api->Get('user/get', array('RunetId' => $runetId), $cache, $resetCache);
		return (isset($result->Error) && $result->Error === true) ? null : $result;
  }

  /**
   * ПОЛУЧЕНИЕ ДАННЫХ ПОЛЬЗОВАТЕЛЯ ПО TOKEN
   *
   * @param  int $token
   * @param  int $cache
   * @return CRunetUserData
   */
  public function GetByToken($token, $cache = 300, $resetCache = false)
  {
		if ($token == '')
		{
			return null;
		}
		$result = $this->api->Get('user/auth', array('token' => $token), $cache, $resetCache);
		return (isset($result->Error) && $result->Error === true) ? null : $result;
  }


}