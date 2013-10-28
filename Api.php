<?php
/**
 * Created by Eroshenko Vitaliy
 * v.eroshenko@gmail.com
 */

namespace RunetID\Api;

require_once(__DIR__.'/Api.php');
require_once(__DIR__.'/models/Model.php');
require_once(__DIR__.'/models/User.php');
require_once(__DIR__.'/models/Company.php');
require_once(__DIR__.'/models/Event.php');
require_once(__DIR__.'/models/Program.php');

class Api {

  private $key;
  private $secret;
  private $cache;

  public static $debug = false;
  public static $debugIp = array();

  const HOST = 'http://api.runet-id.com/';
  const VERSION = '0.7';

  /**
   * @param string $key
   * @param string $secret
   * @param ICache $cache
   */
  public function __construct($key, $secret, $cache = null) {

    $this->key = $key;
    $this->secret = $secret;
    $this->cache = $cache;

  }

  /**
   * @return string
   */
  public function getKey()
  {
    return $this->key;
  }

  /**
  *
  * @return boolean
  */
  private static function isDebug()
  {
    return (self::$debug && in_array($_SERVER['REMOTE_ADDR'], self::$debugIp));
  }

  /**
    * @param string $url
    * @param array $vars
    * @param int $cacheTime
    * @param bool $resetCache
    * @param bool $useAuth
    * @return array
    */
  public function get ($url, $vars = array(), $cacheTime = 0, $resetCache = false, $useAuth = true)
  {
    return self::request('GET', $url, $vars, $cacheTime, $resetCache, $useAuth);
  }

  /**
    * @param string $url
    * @param array $vars
    * @param int $cacheTime
    * @param bool $resetCache
    * @return array
    */
  public function post ($url, $vars = array(), $cacheTime = 0, $resetCache = false)
  {
    return self::request('POST', $url, $vars, $cacheTime, $resetCache);
  }

  /*
  private function GetCacheId ($url, $vars)
  {
    return $url . serialize($vars);
  }
  */

  /**
    * @param  string $method
    * @param  string $url
    * @param  array $vars
    * @param int $cache
    * @param bool $resetCache
    * @param bool $useAuth
    * @return obj
    */
  protected function request ($method, $url, $vars = array(), $cacheTime = 0, $resetCache = false, $useAuth = true)
  {
    $startTime = microtime(true);

    if (!$url)
    {
//      throw new CRunetException();
    }

    if ($resetCache)
    {
      $this->cache->flush();
    }

    $cacheId = $url . serialize($vars);
    $cacheData = (!empty($this->cache)) ? $this->cache->get($cacheId) : false;
    if (empty($this->cache) || $cacheTime == 0 || $cacheData === false)
    {
      if ($useAuth)
      {
        $timestamp = time();

        if (!$this->key || !$this->secret)
        {
          //throw new CRunetException( GetMessage ('RUNET.EXCEPTION.NOTKEY'));
        }

        $hash = substr( md5 ($this->key . $timestamp . $this->secret), 0, 16);
        $url .= '/?ApiKey='. $this->key .'&Timestamp='. $timestamp .'&Hash='. $hash;
      }
      else
      {
        $url .= '/?';
      }

      $vars = http_build_query($vars);

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_TIMEOUT, 30);
      curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      switch ($method)
      {
        case 'POST':
          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $vars);
        break;

        case 'GET':
          $url .= '&'.$vars;
        break;
      }

      curl_setopt($curl, CURLOPT_URL, self::HOST . $url);
      $result = curl_exec($curl);

      if (self::isDebug())
      {
        print 'Debug log:<pre>';
        print 'URL: ' .$url .'<br /><br />';
        print_r(json_decode($result));
        print '</pre>';
      }

      $result = json_decode($result);

      if (curl_errno($curl) == 0 && !empty($this->cache) && $cacheTime != 0 && !isset($result->Error))
      {
        $this->cache->set($cacheId, $result);
      }
      curl_close($curl);
    }
    else
    {
      $result = $cacheData;
		}

    $this->log($url, $result, (microtime(true) - $startTime));

    return $result;
  }

  /**
 	* ЛОГИРОВАНИЕ
 	*
 	* @param string $url
 	* @param mixed $result
 	*/
 	private function log ($url, $result, $executionTime)
 	{
 		$writeToLog = false;
 		if ( isset ($result->Error) && $result->Error)
 		{
 			$writeToLog = true;
 		}

 		if ($writeToLog)
 		{
      $logDir = __DIR__.'/log/';
 			$logFilePath = $logDir . date('d-m-Y') .'.txt';
      if (!is_dir($logDir)) mkdir($logDir, 0777, true);
 			file_put_contents(
 				$logFilePath,
 				'----------------------------------------'. PHP_EOL .'DateTime: '. date('d-m-Y H:i:s') . PHP_EOL .'URL: '. $url . PHP_EOL . PHP_EOL . 'ExecutionTime: ' . $executionTime . PHP_EOL . PHP_EOL .'Result: '. PHP_EOL .''. var_export($result, true) . PHP_EOL .'----------------------------------------'. PHP_EOL . PHP_EOL . PHP_EOL,
 				FILE_APPEND
 			);
 		}
 	}

  public static function getVersion()
  {
    return 'Runet-ID API v'.self::VERSION;
  }

}