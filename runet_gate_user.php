<?php
class CRunetGateUser extends CRunetGate
{
  /**
   * АВТОРИЗАЦИЯ
   *
   * @param type $runetIdOrEmail
   * @param type $password
   * @return CRunetUserData
   */
  static function Login ($runetIdOrEmail, $password)
  {
    $params = array(
      'Password' => md5($password),
      'PasswordCp1251' => md5( iconv('utf-8', 'Windows-1251', $password))
    );

    if ( intval($runetIdOrEmail) > 0 )
    {
      $params['RunetId'] = $runetIdOrEmail;
    }
    else
    {
      $params['Email'] = $runetIdOrEmail;
    }

    $data = parent::Get('user/login', $params);

    if (isset ($data->Error) && $data->Error)
    {
      return false;
    }
    return $data;
  }

  /**
   * ПОИСК ПОЛЬЗОВАТЕЛЯ ПО ФИО/EMAIL/RUNETID
   *
   * @param  string $query
   * @param  int    $maxResults
   * @return CRunetUserData[]
   */
  public static function Search ($query, $maxResults = 200)
  {
		$result = array();
		$pageToken = null;

		do {
			$gateResult = parent::Get('user/search', array(
				'Query'      => $query,
				'MaxResults' => $maxResults,
				'PageToken'  =>	$pageToken
		  ), 3600);

			$pageToken = $gateResult->NextPageToken;
			$result = array_merge($result, $gateResult->Users);
		}
		while($pageToken !== null);

		return $result;
  }

  /**
   * ПОЛУЧЕНИЕ ДАННЫХ ПОЛЬЗОВАТЕЛЯ ПО RunetID
   *
   * @param  int $runetId
   * @param  int $cache
   * @return CRunetUserData
   */
  public static function GetUser($runetId, $cache = 300, $resetCache = false)
  {
		$runetId = (int) $runetId;
		if ($runetId === 0)
		{
			return null;
		}
		$result = parent::Get('user/get', array('RunetId' => $runetId), $cache, $resetCache);
		return (isset($result->Error) && $result->Error === true) ? null : $result;
  }

  /**
   * ПОЛУЧЕНИЕ ДАННЫХ ПОЛЬЗОВАТЕЛЯ ПО TOKEN
   *
   * @param  string $token
   * @param  int $cache
   * @return CRunetUserData
   */
  public static function GetByToken($token, $cache = 300, $resetCache = false)
  {
		if ($token == '')
		{
			return null;
		}
		$result = parent::Get('user/auth', array('token' => $token), $cache, $resetCache);
		return (isset($result->Error) && $result->Error === true) ? null : $result;
  }

  /**
   * СПИСОК ПОЛЬЗОВАТЕЛЕЙ ПО ИХ RUNETID
   *
   * @param  int[] $runetIds
   * @return CRunetIdUserData[]
   */
  public static function GetList($runetIds)
  {
	  if ( !is_array($runetIds))
	  {
	    return null;
	  }

    $query = implode(',', $runetIds);
    return self::Search($query);
  }

  /**
   * СОЗДАНИЕ ПОЛЬЗОВАТЕЛЯ
   *
   * @param  string $email
   * @param  string $firstname
   * @param  string $lastname
   * @param  array  $fields
   * @return CRunetUserData
   */
  public static function Create ($email, $firstname, $lastname, $fields = array())
  {
    $data = array_merge(array(
      	'Email'	=> $email,
        'FirstName' => $firstname,
        'LastName'	=> $lastname
      ), $fields);
    return parent::Post('user/create', $data);
  }
}