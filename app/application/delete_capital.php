<?php

use Facebook\GraphNodes\GraphEdge;

 define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserSupport = new GranCapital\UserSupport;

if($UserSupport->_loaded === true)
{
    if($data['capital_per_broker_id'])
    {
        $CapitalPerBroker = new GranCapital\CapitalPerBroker;

        if($CapitalPerBroker->cargarDonde('capital_per_broker_id = ?',$data['capital_per_broker_id']))
        {
            $CapitalPerBroker->status = GranCapital\CapitalPerBroker::DELETED;
            
            if($CapitalPerBroker->save())
            {
                $data["s"] = 1;
                $data["r"] = "DATA_OK";
            } else {
                $data["s"] = 0;
                $data["r"] = "NOT_SAVE";
            }
        } else {
            $data["s"] = 0;
            $data["r"] = "NOT_CAPITAL_PER_BROKER";
        }
    } else {
        $data["s"] = 0;
        $data["r"] = "NOT_CAPITAL_PER_BROKER_ID";
    }
} else {
	$data["s"] = 0;
	$data["r"] = "NOT_FIELD_SESSION_DATA";
}

echo json_encode($data);