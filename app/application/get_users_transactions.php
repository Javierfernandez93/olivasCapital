<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserSupport = new GranCapital\UserSupport;

if($UserSupport->_loaded === true)
{
    $WithdrawPerUser = new GranCapital\WithdrawPerUser;
    
    if($transactions = $WithdrawPerUser->getAll($data['status']))
    {
        $data["transactions"] = formatData($UserSupport,$transactions);
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

function formatData($UserSupport = null, array $transactions = null) : array
{
    $WithdrawMethodPerUser = new GranCapital\WithdrawMethodPerUser;

    foreach ($transactions as $key => $transaction)
    {
        $method = $WithdrawMethodPerUser->getMethod($transaction['user_login_id'],$transaction['catalog_withdraw_method_id']);
        $transactions[$key]['method'] = $method['method'];
        $transactions[$key]['account'] = $method['account'];
        $transactions[$key]['wallet'] = $method['wallet'];

        $user = $UserSupport->getUser($transaction['user_login_id']);

        $transactions[$key]['email'] = $user['email'];
        $transactions[$key]['image'] = $user['image'];
        $transactions[$key]['names'] = $user['names'];
    }

    return $transactions;
}

echo json_encode($data);