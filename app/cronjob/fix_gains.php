<?php define("TO_ROOT", "../../");

require_once TO_ROOT . "/system/core.php";

$data = HCStudio\Util::getVarFromPGS();

$UserSupport = new GranCapital\UserSupport;

if (($data['user'] == HCStudio\Util::$username && $data['password'] == HCStudio\Util::$password) || $UserSupport->_loaded === true) {
    // GranCapital\NotificationPerUser::push(1,"Prueba de cronjob ".date("Y-m-d h:i:s"),GranCapital\CatalogNotification::ACCOUNT,'');

    $data['unix_time'] = $data['day'] ? strtotime($data['day']) : time();
    $data['production'] = $data['production'] ? $data['production'] : true; // setting up production mode as default

    // checking if actual day is btwn week
    if (date('N', $data['unix_time']) < 6) 
    {
        if (date('H', $data['unix_time']) == '09') 
        {
            $UserPlan = new GranCapital\UserPlan;
            
            $ProfitPerUser = new GranCapital\ProfitPerUser;
            $active_plans = $ProfitPerUser->getAllProfitsPerDay($data['day']);
            // $active_plans = [$active_plans[0]];

            foreach($active_plans as $key => $active_plan)
            {
                $user_plan_id = $active_plan['catalog_profit_id'] == 1 ? $active_plan['user_plan_id'] : $active_plan['from_user_plan_id'];
                
                $user_login_id = $UserPlan->getUserId($user_plan_id);

                if($plan = $UserPlan->getPlan($user_login_id))
                {
                    $total_profit = $active_plan['catalog_profit_id'] == 1 ? $plan['profit']+$plan['additional_profit'] : $plan['sponsor_profit'];

                    if($gain = $ProfitPerUser->calculateProfit($total_profit,$plan['ammount'],$data['day']))
                    {
                        $total_gain += $gain;
                        $type = $active_plan['catalog_profit_id'] == 1 ? 'Inversion' : 'Referido';
                    
                        echo "--- Usuario {$user_login_id} -- {$type}<br>";
                        echo "PROFIT {$total_profit} % y monto $ {$plan['ammount']} - Ganará {$gain} y ganó {$active_plan['gain']}";

                        if($gain != $active_plan['gain'])
                        {
                            echo " [NO COINCIDE]";

                            if(updateProfit($active_plan['profit_per_user_id'],$gain))
                            {
                                if(updateTransaction($active_plan['profit_per_user_id'],$gain))
                                {
                                    echo " [ACTUALIZADO]";
                                } else {
                                    echo " [ERROR2]";
                                }
                            } else {
                                echo " [ERROR1]";
                            }
                        }

                        echo "<br>";
                    }
                }
            }

            echo "Total {$total_gain}";

            $data['s'] = 1;
        } else {
            $data['s'] = 0;
            $data['r'] = "SCRIPT_ONLY_WORKS_AT_NINE_MORNING";
        }
    } else {
        $data['s'] = 0;
        $data['r'] = "SCRIPT_NOT_WORKING_ON_WEEKEND";
    }
} else {
    $data['s'] = 0;
    $data['r'] = "INVALID_CREDENTIALS";
}

function updateProfit($profit_per_user_id = null,$profit = null)
{
    // return true;
    $ProfitPerUser = new GranCapital\ProfitPerUser;
    
    if($ProfitPerUser->cargarDonde("profit_per_user_id = ?",$profit_per_user_id))
    {
        $ProfitPerUser->profit = $profit;
        return $ProfitPerUser->save();
    }

    return false;
}

function updateTransaction($profit_per_user_id = null,$ammount = null)
{
    // return true;
    $TransactionPerWallet = new GranCapital\TransactionPerWallet;

    if($TransactionPerWallet->cargarDonde("profit_per_user_id = ?",$profit_per_user_id))
    {
        $TransactionPerWallet->ammount = $ammount;
        return $TransactionPerWallet->save();
    }

    return false;
}

echo json_encode($data);
