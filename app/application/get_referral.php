<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserLogin = new GranCapital\UserLogin;
$UserSupport = new GranCapital\UserSupport;

if($UserLogin->_loaded === false || $UserSupport->_loaded === true)
{
    if($data['user_login_id'])
    {
        $data['utm']  = $data['utm'] ? $data['utm'] : 0;
        $data['utm']  = (new GranCapital\CatalogCampaign)->getCatalogCampaing($data['utm']);
        $UserData = new GranCapital\UserData;
        
        if($referral = $UserLogin->getProfile($data['user_login_id'],$data['utm']))
        {
            $data['referral'] = $referral;
            $data["s"] = 1;
            $data["r"] = "DATA_OK";
        } else {
            $data["s"] = 0;
            $data["r"] = "NOT_DATA";
        }
    } else {
        $data["s"] = 0;
        $data["r"] = "NOT_USER_LOGIN_ID";
    }
} else {
	$data["s"] = 0;
	$data["r"] = "INVALID_CREDENTIALS";
}

echo json_encode($data);