<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getVarFromPGS();

$UserSupport = new GranCapital\UserSupport;

if(($data['user'] == HCStudio\Util::$username && $data['password'] == HCStudio\Util::$password) || $UserSupport->_loaded === true)
{
    // GranCapital\NotificationPerUser::push(1,"Prueba de cronjob ".date("Y-m-d h:i:s"),GranCapital\CatalogNotification::ACCOUNT,'');
    $data['unix_time'] = $data['day'] ? strtotime($data['day']) : time();
    $data['day'] = $data['day'] ? $data['day'] : date("Y-m-d H:i:s",$data['unix_time']);
    $data['production'] = $data['production'] ? $data['production'] : true; // setting up production mode as default

    // checking if actual day is btwn week
    if(date('N',$data['unix_time']) < 6)
    {
        if(date('H',$data['unix_time']) == '09')
        {
            $day = strtotime($data['day']);

            $data['start_execution_time'] = microtime(true); 
            $data['filter'] = $data['user_login_id'] ? " AND user_plan.user_login_id = '{$data['user_login_id']}'" : '';

            $UserPlan = new GranCapital\UserPlan;
            
            if($active_plans = $UserPlan->getActivePlans($data['filter']))
            {
                $UserReferral = new GranCapital\UserReferral;
                $ProfitPerUser = new GranCapital\ProfitPerUser;

                $data['report'][0]['title'] = 'INVERSEMENT GAINS';
                
                /* inversement gains */
                foreach ($active_plans as $active_plan)
                {
                    // if doesnt have profit then we dadd it 
                    if($ProfitPerUser->hasProfitToday($active_plan['user_plan_id'],GranCapital\Transaction::INVESTMENT,$data['day']) == false)
                    {
                        if($active_plan['user_login_id'] == 6)
                        {
                            $active_plan['profit'] = 6;
                        }
                        
                        $total_profit = $active_plan['profit']+$active_plan['additional_profit'];
                        
                        if($gain = $ProfitPerUser->calculateProfit($total_profit,$active_plan['ammount'],$data['day']))
                        {
                            $data['report'][0]['profits'][] = [
                                'user_login_id' => $active_plan['user_login_id'],
                                'total_profit' => $total_profit,
                                'plan' => [
                                    'active_plan' => $active_plan['name'],
                                    'ammount' => $active_plan['ammount'],
                                ],
                                'gain' => $gain
                            ];
        
                            if($data['production'] == true)
                            {
                                if($ProfitPerUser->insertGain($active_plan['user_plan_id'],$active_plan['user_plan_id'],GranCapital\Transaction::INVESTMENT,$gain,$day))
                                {
                                    GranCapital\NotificationPerUser::push($active_plan['user_login_id'],"Hemos enviado $ {$gain} USD a tu cuenta por tus rendimientos",GranCapital\CatalogNotification::GAINS,"");
                                }
                            }
                        }

                    }
                }

                $data['report'][1]['title'] = 'Referral GAINS';

                $UserLogin = new GranCapital\UserLogin(false,false);

                /* referral gains */
                foreach ($active_plans as $active_plan)
                {
                    // getting sponsor [refferal is sponsor here]
                    if($referral = $UserReferral->getReferral(($active_plan['user_login_id'])))
                    {
                        // getting referral plan
                        if($user_plan_id = $UserPlan->getUserPlanId($referral['user_login_id']))
                        {   
                            // getting signup_date referral
                            if($signup_date = $UserLogin->getSignupDate($referral['user_login_id']))
                            {
                                if($data['unix_time'] >= $signup_date)
                                {
                                    if($ProfitPerUser->hasProfitTodayForReferral($user_plan_id,$active_plan['user_plan_id'],GranCapital\Transaction::REFERRAL_INVESTMENT,$data['day']) == false)
                                    {
                                        $total_profit = $active_plan['sponsor_profit'];
                                        
                                        if($gain = $ProfitPerUser->calculateProfit($total_profit,$active_plan['ammount'],$data['day']))
                                        {
                                            $data['report'][1]['profits'][] = [
                                                'referral_id' => $active_plan['user_login_id'],
                                                'user_login_id' => $referral['user_login_id'],
                                                'total_profit' => $total_profit,
                                                'plan' => [
                                                    'active_plan' => $active_plan['name'],
                                                    'ammount' => $active_plan['ammount'],
                                                ],
                                                'gain' => $gain
                                            ];
                                            
                                            if($data['production'] == true)
                                            {
                                                $description = "Ganancias por referido ID {$active_plan['user_login_id']}";

                                                if($ProfitPerUser->insertGain($user_plan_id,$active_plan['user_plan_id'],GranCapital\Transaction::REFERRAL_INVESTMENT,$gain,$day,$description))
                                                {
                                                    GranCapital\NotificationPerUser::push($referral['user_login_id'],"Hemos enviado $ {$gain} USD a tu cuenta por tus rendimientos de tus invitados",GranCapital\CatalogNotification::GAINS,"");
                                                }
                                            }
                                        }
                                    }
                                }
                                
                            }
                        }
                    }
                }
            }

            $data['end_execution_time'] = microtime(true); 
            $data['total_execution_time'] = $data['end_execution_time'] - $data['start_execution_time']; 

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

echo json_encode($data);