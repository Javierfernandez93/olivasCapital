<?php define("TO_ROOT", "../..");

require_once TO_ROOT . "/system/core.php";

$UserLogin = new GranCapital\UserLogin;

if($UserLogin->_loaded === false) {
	HCStudio\Util::redirectTo(TO_ROOT."/apps/login/");
}

$UserLogin->checkRedirection();

$Layout = JFStudio\Layout::getInstance();

$route = JFStudio\Router::Backoffice;
$Layout->init(JFStudio\Router::getName($route),'index',"backoffice",'',TO_ROOT.'/');

$Layout->setScriptPath(TO_ROOT . '/src/');
$Layout->setScript([
	'backoffice.vue.js'
]);

// require_once TO_ROOT .'/vendor2/autoload.php';

// $cps_api = new CoinpaymentsAPI(CoinPayments\Api::private_key, CoinPayments\Api::public_key, 'json');

// $data['txn_id'] ='CPGG46RUQZQ7WMHTKZ3K3EQ9LF';
// try {            
// 	$result = $cps_api->GetTxInfoSingle($data['txn_id']);
	
// 	d($result);
// 	if ($result['error'] == 'ok') 
// 	{ 
		
// 	}
// } catch (Exception $e) {
// 	echo 'Error: ' . $e->getMessage();
// 	exit();
// }


$Layout->setVar([
	'route' =>  $route,
	'UserLogin' => $UserLogin
]);
$Layout();