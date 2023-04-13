<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$UserPlan = new GranCapital\UserPlan;

$filter = ' AND user_plan.user_login_id IN(14)';
// $filter = ' AND user_plan.user_login_id IN(21,23)';

if($active_plans = $UserPlan->getActivePlans($filter))
{
    $UserLogin = new GranCapital\UserLogin(false,false);

    foreach($active_plans as $active_plan)
    {
        if($signup_date = $UserLogin->getSignupDate($active_plan['user_login_id']))
        {
            $start_date = strtotime(date("Y-m-d",$signup_date));
            $diff_days = round((time() - $start_date) / (60 * 60 * 24));

            if($diff_days > 0)
            {
                for($i = 0; $i < $diff_days; $i++)
                {
                    $day = date("Y-m-d 09:00:00",strtotime("+{$i} days",$start_date));

                    $Curl = new JFStudio\Curl;

                    // $Curl->get('https://grancapital.fund/app/cronjob/disperse_gains.php',[
                    $Curl->get('http://localhost:8888/grancapital/app/cronjob/disperse_gains.php',[
                        'day' => $day,
                        'user_login_id' => $active_plan['user_login_id']
                    ]);
                    
                    $responses[] = [
                        'day' => $day,
                        'response' => $Curl->getResponse(true)
                    ];
                }

            }
        }
    }
    
    d($responses);
}
