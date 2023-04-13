<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserSupport = new GranCapital\UserSupport;

if($UserSupport->_loaded === true)
{
    $TransactionRequirementPerUser = new GranCapital\TransactionRequirementPerUser;

    if(in_array($data['status'],[GranCapital\TransactionRequirementPerUser::PENDING,GranCapital\TransactionRequirementPerUser::EXPIRED,GranCapital\TransactionRequirementPerUser::VALIDATED,GranCapital\TransactionRequirementPerUser::DELETED]))
    {
        $data['filter'] = " WHERE transaction_requirement_per_user.status = '".$data['status']."'";
    }
    
    if($transactions = $TransactionRequirementPerUser->getTransactions(($data['filter'])))
    {
        $data["transactions"] = $transactions;
        $data["s"] = 1;
        $data["r"] = "DATA_OK";
    } else {
        $data['r'] = "NOT_TRANSACTIONS";
        $data['s'] = 0;
    }
} else {
	$data["s"] = 0;
	$data["r"] = "NOT_FIELD_SESSION_DATA";
}

echo json_encode($data);