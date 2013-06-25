<?php
/**
 * Created by JetBrains PhpStorm.
 * User: админ
 * Date: 21.06.13
 * Time: 18:55
 * To change this template use File | Settings | File Templates.
 */

namespace RunetID\Api;

/**
 * ICache is the interface that must be implemented by cache components.
 */
interface ICache
{

  /**
  * Retrieves a value from cache with a specified key.
  * @param string $id a key identifying the cached value
  * @return mixed the value stored in cache, false if the value is not in the cache or expired.
  */
  public function get($id);

  /**
  * Stores a value identified by a key into cache.
  * If the cache already contains such a key, the existing value and
  * expiration time will be replaced with the new ones.
  *
  * @param string $id the key identifying the value to be cached
  * @param mixed $value the value to be cached
  * @param integer $expire the number of seconds in which the cached value will expire. 0 means never expire.
  * @return boolean true if the value is successfully stored into cache, false otherwise
  */
  public function set($id,$value,$expire=0);

  /**
  * Stores a value identified by a key into cache if the cache does not contain this key.
  * Nothing will be done if the cache already contains the key.
  * @param string $id the key identifying the value to be cached
  * @param mixed $value the value to be cached
  * @param integer $expire the number of seconds in which the cached value will expire. 0 means never expire.
  * @return boolean true if the value is successfully stored into cache, false otherwise
  */
  public function add($id,$value,$expire=0);

  /**
  * Deletes a value with the specified key from cache
  * @param string $id the key of the value to be deleted
  * @return boolean whether the deletion is successful
  */
  public function delete($id);

  /**
  * Deletes all values from cache.
  * Be careful of performing this operation if the cache is shared by multiple applications.
  * @return boolean whether the flush operation was successful.
  */
  public function flush();
}