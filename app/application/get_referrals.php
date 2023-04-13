<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserLogin = new GranCapital\UserLogin;

if($UserLogin->_loaded === true)
{
    $UserReferral = new GranCapital\UserReferral;
    
    if($referrals = $UserReferral->getReferrals($UserLogin->company_id))
    {
        $data['referrals'] = formatData($referrals);
        $data["s"] = 1;
        $data["r"] = "DATA_OK";
    } else {
        $data["s"] = 0;
        $data["r"] = "NOT_DATA";
    }
} else {
	$data["s"] = 0;
	$data["r"] = "INVALID_CREDENTIALS";
}

function formatData(array $referrals = null) : array {

    $UserPlan = new GranCapital\UserPlan;

    $referrals = array_map(function($referral) use ($UserPlan) {
        $referral['plan'] = $UserPlan->getPlan($referral['user_login_id']);
        return $referral;
    },$referrals);

    return $referrals;
}

echo json_encode($data);