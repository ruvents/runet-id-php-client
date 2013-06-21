<?php
/**
 * Created by JetBrains PhpStorm.
 * User: админ
 * Date: 13.06.13
 * Time: 17:15
 * To change this template use File | Settings | File Templates.
 */

namespace RunetID\Api;


class Api {

  private $key;
  private $secret;
  private $cache;

  const DOMAIN = 'http://api.runet-id.com/';

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
    * @param string $url
    * @param array $vars
    * @param int $cache
    * @param bool $resetCache
    * @param bool $useAuth
    * @return array
    */
  public function get ($url, $vars = array(), $cache = 0, $resetCache = false, $useAuth = true)
  {
    return self::request('GET', $url, $vars, $cache, $resetCache, $useAuth);
  }

  /**
    * @param string $url
    * @param array $vars
    * @param int $cache
    * @param bool $resetCache
    * @return array
    */
  public function post ($url, $vars = array(), $cache = 0, $resetCache = false)
  {
    return self::request('POST', $url, $vars, $cache, $resetCache);
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
  protected function request ($method, $url, $vars = array(), $cache = 0, $resetCache = false, $useAuth = true)
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

    /*
    if ($cache === 0 || !$bxCache->InitCache($cache, $this->GetCacheId($url, $vars), "/runet/"))
    {
    */
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

      curl_setopt($curl, CURLOPT_URL, self::DOMAIN . $url);
      $result = curl_exec($curl);

      /*
      if (self::IsDebug() && self::$DebugHard)
      {
        var_dump($result);
      }
      */

      $result = json_decode($result);
      curl_close($curl);

      /*
      if ($cache !== 0 && !isset($result->Error))
      {
        $bxCache->StartDataCache();
        $bxCache->EndDataCache(array(
          'result' => $result
        ));
      }
      */

    /*
    }
    else
    {
      $bxCacheVars = $bxCache->GetVars();
      $result = $bxCacheVars['result'];
		}
    */

    $this->log($url, $result, (microtime(true) - $startTime));

    /*
    if (self::IsDebug())
    {
      print 'URL: '.$url.'<br/>';
      print '<pre>';
      print_r($result);
      print '</pre>';
    }
    */
    return $result;
  }

  /*
  private static function IsDebug ()
  {
    return (self::$Debug && in_array($_SERVER['REMOTE_ADDR'], self::$DebugIp));
  }
  */

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
      mkdir($logDir);
 			file_put_contents(
 				$logFilePath,
 				'----------------------------------------'. PHP_EOL .'DateTime: '. date('d-m-Y H:i:s') . PHP_EOL .'URL: '. $url . PHP_EOL . PHP_EOL . 'ExecutionTime: ' . $executionTime . PHP_EOL . PHP_EOL .'Result: '. PHP_EOL .''. var_export($result, true) . PHP_EOL .'----------------------------------------'. PHP_EOL . PHP_EOL . PHP_EOL,
 				FILE_APPEND
 			);
 		}
 	}

}