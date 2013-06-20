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

  public function __construct(Api $api)
  {
    $this->api = $api;
  }

  private static $models = array();

  public static function model(Api $api)
  {
    $className = static::getClassName();

    if (!isset(self::$models[$api->getKey()][$className]))
    {
      self::$models[$api->getKey()][$className] = new $className($api);
    }
    return self::$models[$api->getKey()][$className];
  }

  protected static function getClassName()
  {
    return __CLASS__;
  }

}