<?php

namespace RunetID\Api;


class Program extends Model {

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
 	* ИНФОРМАЦИЯ ПО СЕКЦИИ
 	*
 	* @param int $sectionId
 	* @return object
 	*/
 	public function getSection($sectionId)
 	{
 	  return $this->api->get('event/section/info', array('SectionId' => $sectionId), 600);
 	}

 	/**
 	* СПИСОК СЕКЦИЙ
 	*
 	* @return object
 	*/
 	public function getSectionList()
 	{
 	  return $this->api->get('event/section/list', array(), 600);
 	}

 	/**
 	* СПИСОК УЧАСТНИКОВ В СЕКЦИИ
 	*
 	* @param int $sectionId
 	* @return array
 	*/
 	public function getSectionReports($sectionId)
 	{
 	  return $this->api->get('event/section/reports', array('SectionId' => $sectionId), 600);
 	}

 	/**
 	* СПИСОК СЕКЦИЙ ПО RunetId
 	*
 	* @param int $runetId
 	* @return array
 	*/
 	public function getUserSections($runetId)
 	{
 	  return $this->api->get('event/section/user', array('RunetId' => $runetId), 600);
 	}
}