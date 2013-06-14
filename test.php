<?
require_once('runet_main.php');

$RunetAPI = new CRunetGate('ny2bp534c3', '62z9526EcX4r35t79m368T44R');

CRunetGate::$Debug = false;
CRunetGate::$DebugHard = false;
CRunetGate::$DebugIp[] = '82.142.129.35';

//$UserAPI = new CRunetGateUser();

$User = CRunetGateUser::Get(12953);

print '<pre>';
var_dump($RunetAPI);
print '</pre>';