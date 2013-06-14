<?php
class CRunetGate {
  public static $Debug = false;
  public static $DebugIp = array();
  public static $DebugHard = false;

  public static $LogMask = array();

  const GateDomain = 'http://api.runet-id.com/';

  private $APIKey = '';
  private $APISecretKey = '';
  private $DefaultRoleId = null;
  private $DefaultProductId = null;

  protected function __clone()     {}
  protected function __wakeup()    {}

  /**
    * @return obj CRunetGate
    */
  public function __construct($apiKey = '', $apiSecretKey = '', $defaultRoleId = 24, $defaultProductId = null)
  {
    $this->APIKey = 'ny2bp534c3';
    $this->APISecretKey = '62z9526EcX4r35t79m368T44R';
    $this->DefaultRoleId = $defaultRoleId;
    $this->DefaultProductId = $defaultProductId;
  }

  public static function Instance()
  {

  }

  /**
  * @return boolean
  */
  private static function IsDebug ()
  {
    return (self::$Debug && in_array($_SERVER['REMOTE_ADDR'], self::$DebugIp));
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
        $apikey    = $this->APIKey;
        $secretkey = $this->APISecretKey;

        if (!$apikey || !$secretkey)
        {
          //throw new CRunetException( GetMessage ('RUNET.EXCEPTION.NOTKEY'));
        }

        $hash = substr( md5 ($apikey . $timestamp . $secretkey), 0, 16);
        $url .= '/?ApiKey='. $apikey .'&Timestamp='. $timestamp .'&Hash='. $hash;
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

      curl_setopt($curl, CURLOPT_URL, CRunetSettings::GateDomain . $url);
      $result = curl_exec($curl);

      if (self::IsDebug() && self::$DebugHard)
      {
        var_dump($result);
      }

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

    if (self::IsDebug())
    {
      print 'URL: '.$url.'<br/>';
      print '<pre>';
      print_r($result);
      print '</pre>';
    }
    return $result;
  }

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
		else if (!empty(self::$LogMask))
		{
			foreach (self::$LogMask as $mask)
			{
				if (strstr($url, $mask))
				{
					$writeToLog = true;
					break;
				}
			}
		}

		if ($writeToLog)
		{
			$logFilePath = __DIR__.'/log/'. date('d-m-Y') .'.txt';
			file_put_contents(
				$logFilePath,
				'----------------------------------------'. PHP_EOL .'DateTime: '. date('d-m-Y H:i:s') . PHP_EOL .'URL: '. $url . PHP_EOL . PHP_EOL . 'ExecutionTime: ' . $executionTime . PHP_EOL . PHP_EOL .'Result: '. PHP_EOL .''. var_export($result, true) . PHP_EOL .'----------------------------------------'. PHP_EOL . PHP_EOL . PHP_EOL,
				FILE_APPEND
			);
		}
	}
}
?>
