<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserSupport = new GranCapital\UserSupport;

if($UserSupport->_loaded === true)
{
    $Broker = new GranCapital\Broker;
    $Broker->name = $data['name'];
    $Broker->fee = $data['fee'];
    $Broker->create_date = time();
    
    if($Broker->save())
    {
        if($data['capital'])
        {
            if(GranCapital\CapitalPerBroker::addCapital($Broker->getId(),$data['capital']))
            {
                $data['capital_saved'] = true;
            }
        }

        if($data['gain'])
        {
            if(GranCapital\GainPerBroker::addGain($Broker->getId(),$data['gain']))
            {
                $data['gain_saved'] = true;
            }
        }

        $data["s"] = 1;
        $data["r"] = "SAVE_OK";    
    } else {
        $data["s"] = 0;
        $data["r"] = "NOT_SAVE";    
    }
} else {
	$data["s"] = 0;
	$data["r"] = "NOT_FIELD_SESSION_DATA";
}

echo json_encode($data);