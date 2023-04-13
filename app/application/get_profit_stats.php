<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserLogin = new GranCapital\UserLogin;

if($UserLogin->_loaded === true)
{
    $UserWallet = new GranCapital\UserWallet;
    
    if($UserWallet->getSafeWallet($UserLogin->company_id))
    {
        $status = "AND transaction_per_wallet.status IN ('".GranCapital\WithdrawPerUser::DEPOSITED."','".GranCapital\WithdrawPerUser::WAITING_FOR_DEPOSIT."','".GranCapital\TransactionPerWallet::TRANSLATED."')";

        $data["gainStats"] = [
            'investment' =>  [
                'total' => $UserWallet->getBalance(" AND transaction_per_wallet.transaction_id = '".GranCapital\Transaction::INVESTMENT."'",$status),
                'percentaje' =>  0
            ],
            'referral' =>  [
                'total' =>  $UserWallet->getBalance(" AND transaction_per_wallet.transaction_id = '".GranCapital\Transaction::REFERRAL_INVESTMENT."'",$status),
                'percentaje' => 0
            ],
            'totalReferral' =>  $UserLogin->getReferralCount(),
            'balance' =>  $UserWallet->getBalance(),
        ];

        $data["s"] = 1;
        $data["r"] = "DATA_OK";
    } else {
        $data["s"] = 0;
        $data["r"] = "NOT_WALLET";
    }
} else {
	$data["s"] = 0;
	$data["r"] = "NOT_FIELD_SESSION_DATA";
}

echo json_encode($data);