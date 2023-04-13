<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserLogin = new GranCapital\UserLogin;

if($UserLogin->_loaded === true)
{
    $UserWallet = new GranCapital\UserWallet;
    
    if($UserWallet->getSafeWallet($UserLogin->company_id))
    {
        $data["withdraws"] = $UserWallet->getWithdraws(" ORDER BY transaction_per_wallet.create_date DESC LIMIT 7 ");
        $data["s"] = 1;
        $data["r"] = "DATA_OK";
    } else {
        $data["s"] = 0;
        $data["r"] = "NOT_WITHDRAWS";
    }
} else {
	$data["s"] = 0;
	$data["r"] = "NOT_FIELD_SESSION_DATA";
}

echo json_encode($data);