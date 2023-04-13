<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserSupport = new GranCapital\UserSupport;

if($UserSupport->_loaded === true)
{
    if($data['day'])
    {
        $TradingPerformance = new GranCapital\TradingPerformance;
        
        if($TradingPerformance->isOperationOpen($data['day']))
        {
            if(saveNewCapitals($data['brokers'],$data['day']))
            {
                if(closeOperation($data['day']))
                {
                    $data["s"] = 1;
                    $data["r"] = "DATA_OK";
                } else {
                    $data["s"] = 0;
                    $data["r"] = "OPERATION_NOT_CLOSED";
                }
            } else {
                $data["s"] = 0;
                $data["r"] = "NOT_SAVE_NEW_CAPITALS";
            }
        } else {
            $data["s"] = 0;
            $data["r"] = "OPERATION_CLOSED";
        }
    } else {
        $data["s"] = 0;
        $data["r"] = "NOT_CAPITAL";
    }
} else {
	$data["s"] = 0;
	$data["r"] = "NOT_FIELD_SESSION_DATA";
}

function closeOperation(string $day = null) : bool
{
    // return true;
    return (new GranCapital\TradingPerformance)->closeOperation($day);
}

function saveNewCapitals(array $brokers = null,string $day = null) : bool
{
    $saved = 0;

    $day = date("Y-m-d H:i:s",strtotime("+1 day",strtotime($day)));

    foreach ($brokers as $broker) 
    {
        $CapitalPerBroker = new GranCapital\CapitalPerBroker;
        
        if($CapitalPerBroker->addCapital($broker['broker_id'],$broker['gain'],$day,GranCapital\CapitalPerBroker::BROKER_GAIN))
        {
            $saved++;
        }
    }

    return $saved == sizeof($brokers);
}

echo json_encode($data);