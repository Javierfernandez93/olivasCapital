<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getVarFromPGS();

$UserSupport = new GranCapital\UserSupport;

if(($data['user'] == HCStudio\Util::$username && $data['password'] == HCStudio\Util::$password) || $UserSupport->_loaded === true)
{
    $data['unix_time'] = $data['day'] ? strtotime($data['day']) : time();
    $data['production'] = $data['production'] ? $data['production'] : true; // setting up production mode as default

    if(date('j',$data['unix_time']) == 6)
    {
        if(date('H',$data['unix_time']) == '09')
        {
            $TransactionPerWallet = new GranCapital\TransactionPerWallet;
            $CatalogPlan = new GranCapital\CatalogPlan;
            
            $filter = " AND user_wallet.user_login_id = '9'";
            $filter = "";

            // st-1
            if($transactions = $TransactionPerWallet->getAllGains($filter))
            {   
                foreach($transactions as $key => $transaction)
                {
                    if($transactions_for_translate = $TransactionPerWallet->getAllGainsList($transaction['user_wallet_id']))
                    {
                        $transactions[$key]['total_withdraws'] = $TransactionPerWallet->getTotalWithdrawsLastMonth($transaction['user_wallet_id']);
                        $transactions[$key]['total_to_deposit'] = $transaction['total_ammount'] + $transactions[$key]['total_withdraws'];
                        
                        $UserWallet = new GranCapital\UserWallet;
                        
                        if($UserWallet->getSafeWallet($transaction['user_login_id']))
                        {
                            if($UserWallet->depositGains($transactions[$key]['total_to_deposit']))
                            {
                                if($TransactionPerWallet->setTransactionsAsTranslated($transactions_for_translate))
                                {
                                    $UserPlan = new GranCapital\UserPlan;

                                    if($UserPlan->setPlan($transaction['user_login_id']))
                                    {
                                        $data["s"] = 1;
                                        $data["r"] = "DATA_OK";
                                    } else {
                                        $data["s"] = 0;
                                        $data["r"] = "NOT_UPDATE_PLAN";
                                    }
                                    
                                    // if($ammount = $TransactionPerWallet->getSumDepositsByUserWithWitdraws($transaction['user_wallet_id']))
                                    // {
                                    //     if($catalog_plan_id = $CatalogPlan->getCatalogPlanIdBetween($ammount))
                                    //     {
                                    //         if(updatePlan($transaction['user_login_id'],$catalog_plan_id,$ammount))
                                    //         {
                                    //             $transactions[$key]['status'] = 1;
                                    //         }
                                    //     }
                                    // }
                                }
                            }
                        }
                    }
                }
            }

            $data['transactions'] = $transactions;
         } else {
            $data['s'] = 0;
            $data['r'] = "SCRIPT_ONLY_WORKS_AT_NINE_MORNING";
        }
    } else {
        $data['s'] = 0;
        $data['r'] = "SCRIPT_ONLY_WORKS_ON_6TH";
    }
} else {
    $data['s'] = 0;
    $data['r'] = "INVALID_CREDENTIALS";
}

echo json_encode($data);