<?php

namespace RunetID\Api;


class User extends Model
{
  /*
  private $RunetId;
  private $LastName;
  private $FirstName;
  private $FatherName;
  private $Email;
  */

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
   * @param  bool $resetCache
   * @return User
   */
  public function getByRunetId($runetId, $cache = 300, $resetCache = false)
  {
		$runetId = (int) $runetId;
		if ($runetId === 0)
		{
			return null;
		}
		$result = $this->api->get('user/get', array('RunetId' => $runetId), $cache, $resetCache);
		return $result;
  }

  /**
   * ПОЛУЧЕНИЕ ДАННЫХ ПОЛЬЗОВАТЕЛЯ ПО TOKEN
   *
   * @param  string $token
   * @param  int $cache
   * @param  bool $resetCache
   * @return User
   */
  public function getByToken($token, $cache = 300, $resetCache = false)
  {
		if ($token == '')
		{
			return null;
		}
		$result = $this->api->get('user/auth', array('token' => $token), $cache, $resetCache);
		return $result;
  }

}