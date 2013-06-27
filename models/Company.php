<?php

namespace RunetID\Api;


class Company extends Model {

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
    * ДАННЫЕ О КОМПАНИИ ПО ID
    * @param int $companyId
    * @return array
    */
  public function getById($companyID)
  {
    $companyID = (int) $companyID;
    if ($companyID === 0)
    {
      return null;
    }
    return $this->api->get('company/get', array('CompanyId' => $companyID));
  }

  public function getTop()
  {
    return $this->api->get('/event/companies/', array(), 3600);
  }



}