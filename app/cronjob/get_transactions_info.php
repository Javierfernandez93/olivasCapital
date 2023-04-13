<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getVarFromPGS();

$UserSupport = new GranCapital\UserSupport;

if(($data['user'] == HCStudio\Util::$username && $data['password'] == HCStudio\Util::$password) || $UserSupport->_loaded === true)
{
    require_once TO_ROOT .'/vendor2/autoload.php';

    $cps_api = new CoinpaymentsAPI(CoinPayments\Api::private_key, CoinPayments\Api::public_key, 'json');
    
    $TransactionRequirementPerUser = new GranCapital\TransactionRequirementPerUser;
    $TransactionPerWallet = new GranCapital\TransactionPerWallet;

    if($transactions = $TransactionRequirementPerUser->getTransactionsPending())
    {   
        foreach($transactions as $transaction)
        {
            $checkout_data = json_decode($transaction['checkout_data'],true);

            if($transaction['txn_id'])
            {
                try {            
                    $result = $cps_api->GetTxInfoSingle($transaction['txn_id']);
                    
                    if ($result['error'] == 'ok') 
                    { 
                        if($result['result']['status_text'] == CoinPayments\Api::COMPLETED)
                        {   
                            if($result['result']['status'] == CoinPayments\Api::OK)
                            {   
                                $UserWallet = new GranCapital\UserWallet;
                                
                                if($UserWallet->getSafeWallet($transaction['user_login_id']))
                                {
                                    if($UserWallet->doTransaction($transaction['ammount'],GranCapital\Transaction::DEPOSIT,null,null,false))
                                    {
                                        $UserPlan = new GranCapital\UserPlan;

                                        if($UserPlan->setPlan($UserWallet->user_login_id))
                                        {
                                            if(updateTransaction($transaction['transaction_requirement_per_user_id']))
                                            {
                                                $data["s"] = 1;
                                                $data["r"] = "DATA_OK";
                                            } 
                                        } else {
                                            $data["s"] = 0;
                                            $data["r"] = "NOT_UPDATE_PLAN";
                                        }
                                    } else {
                                        $data['r'] = "NOT_WALLET";
                                        $data['s'] = 0;
                                    }
                                } else {
                                    $data['r'] = "DATA_ERROR";
                                    $data['s'] = 0;
                                }
                            }
                        } else if($result['result']['status'] == -1) {
                            if(expireTransaction($transaction['transaction_requirement_per_user_id']))
                            {
                                $data["s"] = 1;
                                $data["r"] = "DATA_OK";
                            }
                        }
                    } else {
                        print 'Error: '.$result['error']."\n";
                    }
                } catch (Exception $e) {
                    echo 'Error: ' . $e->getMessage();
                    exit();
                }
            }
        }
    } else {
        $data['s'] = 0;
        $data['r'] = "NOT_TRANSACTIONS";
    }
} else {
    $data['s'] = 0;
    $data['r'] = "INVALID_CREDENTIALS";
}

function updateTransaction(int $transaction_requirement_per_user_id = null)
{
    if(isset($transaction_requirement_per_user_id) === true)
    {
        $TransactionRequirementPerUser = new GranCapital\TransactionRequirementPerUser;
        
        if($TransactionRequirementPerUser->isPending($transaction_requirement_per_user_id))
        {   
            if($TransactionRequirementPerUser->cargarDonde("transaction_requirement_per_user_id = ?",$transaction_requirement_per_user_id))
            {
                $TransactionRequirementPerUser->status = GranCapital\TransactionRequirementPerUser::VALIDATED;
                $TransactionRequirementPerUser->validate_date = time();
                $TransactionRequirementPerUser->validation_method = GranCapital\TransactionRequirementPerUser::CRONJOB;

                return $TransactionRequirementPerUser->save();
            }
        }
    }
}

function expireTransaction(int $transaction_requirement_per_user_id = null)
{
    if(isset($transaction_requirement_per_user_id) === true)
    {
        $TransactionRequirementPerUser = new GranCapital\TransactionRequirementPerUser;
        
        if($TransactionRequirementPerUser->isPending($transaction_requirement_per_user_id))
        {   
            if($TransactionRequirementPerUser->cargarDonde("transaction_requirement_per_user_id = ?",$transaction_requirement_per_user_id))
            {
                $TransactionRequirementPerUser->status = GranCapital\TransactionRequirementPerUser::EXPIRED;

                return $TransactionRequirementPerUser->save();
            }
        }
    }
}

echo json_encode($data);