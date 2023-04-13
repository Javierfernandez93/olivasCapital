<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserSupport = new GranCapital\UserSupport;

if($UserSupport->_loaded === true)
{
    $data['day'] = date("Y-m-d");

    $GainPerBroker = new GranCapital\GainPerBroker;
    $ProfitPerUser = new GranCapital\ProfitPerUser;
    $CapitalPerBroker = new GranCapital\CapitalPerBroker;
    
    getBrokersChartData($data,$CapitalPerBroker);
    
    $TransactionPerWallet = new GranCapital\TransactionPerWallet;
    $WithdrawPerUser = new GranCapital\WithdrawPerUser;

    $pendingWithdraws = $WithdrawPerUser->getCountPending();

    $data["stats"] = [
        'totalCapital' => $CapitalPerBroker->getTotalCapital(),
        'totalDeposit' => (new GranCapital\UserPlan)->getAllSum(),
        'totalWithdraws' => $TransactionPerWallet->getAllWithdraws(),
        'totalProfits' => $TransactionPerWallet->getAllProfits(),
        'pendingWithdraws' =>  $pendingWithdraws != false ? $pendingWithdraws : 0,
        'gainsPerDay' => [
            'ammount' => $GainPerBroker->getGainsPerDay($data['day'])
        ],
        'profitsPerDay' => [
            'ammount' => $ProfitPerUser->getProfitsPerDay($data['day'])
        ],
        'gains' => [
            'ammount' => $GainPerBroker->getAllGains()
        ],
        'profits' => [
            'ammount' => $ProfitPerUser->getAllProfits()
        ],
        'totalUsers' => $UserSupport->getCountUsers()
    ];

    $data["s"] = 1;
    $data["r"] = "DATA_OK";
} else {
	$data["s"] = 0;
	$data["r"] = "NOT_FIELD_SESSION_DATA";
}

function getBrokersChartData(array &$data = null,GranCapital\CapitalPerBroker $CapitalPerBroker = null)
{
    $Broker = new GranCapital\Broker;
    $GainPerBroker = new GranCapital\GainPerBroker;
    
    if($data['brokers'] = $Broker->getActive())
    {
        $days = 5;
        $first_day = strtotime("-{$days} days");

        for($i = 0; $i < $days; $i++)
        {
            $start_date = strtotime(($i+1)." days",$first_day);
            $end_date = strtotime(($i+2)." days",$first_day)-1;

            $data['labels'][] = HCStudio\Util::getDateSimples($start_date);

            foreach ($data['brokers'] as $key => $broker)
            {
                $data['brokers'][$key]['data'][] = $CapitalPerBroker->getLastCapitals($broker['broker_id'],$start_date,$end_date);
            }
        }

        foreach ($data['brokers'] as $key => $broker)
        {
            $capitals = $CapitalPerBroker->getAllPerBroker($broker['broker_id']);
            $gains = $GainPerBroker->getAllGainsPerBroker($broker['broker_id']);

            $gains = $gains ? $gains : [];
            $capitals = $capitals ? $capitals : [];

            $total_capital = array_sum($capitals);
            $total_gain = array_sum($gains);

            $data['brokers'][$key]['averange']['capital'] = sizeof($capitals) ? $total_capital / sizeof($capitals) : 0;
            $data['brokers'][$key]['averange']['gain'] = sizeof($gains) > 0 ? $total_gain / sizeof($gains) : 0;
            $data['pie']['data'][$key] = $total_capital;
        }

        $data['pie']['brokersNames'] = array_column($data['brokers'], 'name');
        $data['pie']['brokersColors'] = array_column($data['brokers'], 'color');
    }
}

echo json_encode($data);