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
  private $domain;
  private $defaultRoleId;

  public function __construct($key, $secret, $defaultRoleId = 24, $domain = 'http://api.runet-id.com/') {

    $this->key = $key;
    $this->secret = $secret;
    $this->domain = $domain;
    $this->defaultRoleId = $secret;

  }

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
  //TODO Подумать над реализацией встроенного кеширования
  public function Get ($url, $vars = array(), $cache = 0, $resetCache = false, $useAuth = true)
  {
    return self::Request('GET', $url, $vars, $cache, $resetCache, $useAuth);
  }

  /**
    * @param string $url
    * @param array $vars
    * @param int $cache
    * @param bool $resetCache
    * @return array
    */
  //TODO Подумать над реализацией встроенного кеширования
  public function Post ($url, $vars = array(), $cache = 0, $resetCache = false)
  {
    return self::Request('POST', $url, $vars, $cache, $resetCache);
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
  protected function Request ($method, $url, $vars = array(), $cache = 0, $resetCache = false, $useAuth = true)
  {
    $startTime = microtime(true);

    // TODO: Привести url к единому формату
    if (!$url)
    {
      throw new CRunetException( GetMessage ('RUNET.EXCEPTION.NOTURL'));
    }

    /*
    $bxCache = new CPHPCache();
    if ($resetCache)
    {
      $bxCache->Clean($this->GetCacheId($url, $vars), '/runet/');
    }

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

      curl_setopt($curl, CURLOPT_URL, $this->domain . $url);
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

    $this->Log($url, $result, (microtime(true) - $startTime));

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
 	private function Log ($url, $result, $executionTime)
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