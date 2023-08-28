<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserLogin = new GranCapital\UserLogin;

if($UserLogin->_loaded === true)
{
    if($data['catalog_withdraw_method_id'])
    {
        // if($data['ammount'])
        // {
        //     $UserWallet = new GranCapital\UserWallet;
            
        //     if($UserWallet->getSafeWallet($UserLogin->company_id))
        //     {
        //         if($UserWallet->getBalance() > 0)
        //         {
        //             if($data["balance"] <= $UserWallet->getBalance())
        //             {
        //                 if($UserWallet->doTransaction($data['ammount'],GranCapital\Transaction::WITHDRAW,null,$data['catalog_withdraw_method_id']))
        //                 {
        //                     $UserPlan = new GranCapital\UserPlan;
                            
        //                     if($UserPlan->setPlan($UserWallet->user_login_id))
        //                     {
        //                         $data["s"] = 1;
        //                         $data["r"] = "DATA_OK";
        //                     } else {
        //                         $data["s"] = 0;
        //                         $data["r"] = "ERROR_ON_CHANGE_PLAN";
        //                     }
        //                 } else {
        //                     $data["s"] = 0;
        //                     $data["r"] = "ERROR_ON_TRANSACTION";
        //                 }
        //             } else {
        //                 $data["s"] = 0;
        //                 $data["r"] = "NOT_ENOUGH_AMOUNT";    
        //             }
        //         } else {
        //             $data["s"] = 0;
        //             $data["r"] = "NOT_ENOUGH_AMOUNT";    
        //         }
        //     } else {
        //         $data["s"] = 0;
        //         $data["r"] = "NOT_WALLET";
        //     }
        // } else {
        //     $data["s"] = 0;
        //     $data["r"] = "NOT_AMMOUNT";
        // }
    } else {
        $data["s"] = 0;
        $data["r"] = "NOT_CATALOG_WITHDRAW_METHOD_ID";
    }
} else {
	$data["s"] = 0;
	$data["r"] = "NOT_FIELD_SESSION_DATA";
}

echo json_encode($data);