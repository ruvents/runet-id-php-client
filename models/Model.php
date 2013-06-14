<?php
/**
 * Created by JetBrains PhpStorm.
 * User: админ
 * Date: 14.06.13
 * Time: 14:24
 * To change this template use File | Settings | File Templates.
 */

namespace RunetID\Api;


abstract class Model {

  protected $api;

  public function __construct($api)
  {
    $this->api = $api;
  }

  /*
  public static function model($api, $className = __CLASS__)
  {
    return new $className($api);
  }
  */

}