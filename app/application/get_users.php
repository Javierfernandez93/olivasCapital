<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserSupport = new GranCapital\UserSupport;

if($UserSupport->_loaded === true)
{
    $filter = "AND user_login.catalog_campaing_id IN(".$UserSupport->campaing.")";

    if($users = $UserSupport->getUsers($filter))
    {
        $data['day'] = date("Y-m-d");

        $ProfitPerUser = new GranCapital\ProfitPerUser;
        $CapitalPerBroker = new GranCapital\CapitalPerBroker;
        $GainPerBroker = new GranCapital\GainPerBroker;

        $capital_total = $CapitalPerBroker->getTotalCapital();
        $total_gains = $GainPerBroker->getGainsPerDay($data['day']);

        $data["users"] = format($users,filter_var($data['flat'], FILTER_VALIDATE_BOOLEAN));

        $data["percentaje"] = ($total_gains/$capital_total) * 100;
        $data["s"] = 1;
        $data["r"] = "DATA_OK";
    } else {
        $data['r'] = "DATA_ERROR";
        $data['s'] = 0;
    }
} else {
	$data["s"] = 0;
	$data["r"] = "NOT_FIELD_SESSION_DATA";
}

function format($users,bool $flat = false)
{
    $ProfitPerUser = new GranCapital\ProfitPerUser;
    $UserPlan = new GranCapital\UserPlan;
    
    foreach($users as $key => $user)
    {
        $users[$key]['profit_today'] = $ProfitPerUser->getProfitToday($UserPlan->getUserPlanId($user['user_login_id']),GranCapital\Transaction::INVESTMENT);
        $users[$key]['profit_sponsor_today'] = $ProfitPerUser->getProfitToday($UserPlan->getUserPlanId($user['user_login_id']),GranCapital\Transaction::REFERRAL_INVESTMENT);
        $users[$key]['total_profit'] = $user['profit'] + $user['sponsor_profit'] + $user['additional_profit']; 

        if($flat)
        {
            $users[$key]['total_payed'] = ($users[$key]['total_profit'] * $users[$key]['ammount']) / 100;
        }
    }

    return $users;
}

echo json_encode($data);