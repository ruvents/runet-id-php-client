<?php

namespace RunetID\Api;


class Event extends Model {

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
   * СПИСОК РОЛЕЙ ДОСТУПНЫХ МЕРОПРИЯТИЮ
   * @return array
   */
  public function getRoles()
 	{
 	  $roles = $this->api->get('event/role/list', null, 3600);
 	  $result = array();
 	  foreach ($roles as $role)
 	  {
 	  	$result[$role->RoleId] = $role->Name;
 	  }
 	  return $result;
 	}

  /**
   * ИЗМЕНЕНИЕ СТАТУСА УЧАСТИЯ
   * @param int $runetId
   * @param int $roleId
   * @return array
   */
  public function changeRole($runetId, $roleId)
 	{
 	  $result = $this->api->post('event/changerole', array(
 	    'RunetId' => $runetId,
 	    'RoleId' => $roleId
 	  ));
 	  return $result;
 	}

  /**
   * ПОЛУЧЕНИЕ СТАТИСТИКИ РЕГИСТРАЦИЙ
   * @return array
   */
  public function getStat()
  {
    return $this->api->get('/event/statistics', array(), 600);
  }

  /**
 	* СПИСОК УЧАСТНИКОВ МЕРОПРИЯТИЯ
 	*
 	* @param string $query
 	* @param int/array $roleId
 	* @param int $maxResult
 	* @return array of objects
 	*/
 	public function getUsers($query = '', $roleId = array(), $maxResult = 200, $sortBy = 'LastName', $cache = 3600)
 	{
 	  $result = array();
 	  $pageToken = null;

 	  do {
 	    $gateResult = $this->api->get('event/users', array(
 	      'Query'      => $query,
 	      'RoleId'     => $roleId,
 	      'MaxResults' => $maxResult,
 	      'PageToken'  => $pageToken,
 	      'SortBy'     => $sortBy
 	    ), $cache);

 	    $pageToken = $gateResult->NextPageToken;

 	    $result = array_merge($result, $gateResult->Users);
 	  }
 	  while ($pageToken !== null);
 	  return $result;
 	}

}