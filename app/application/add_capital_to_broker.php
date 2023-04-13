<?php

use Google\Protobuf\Field\Kind;

 define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserSupport = new GranCapital\UserSupport;

if($UserSupport->_loaded === true)
{
    if($data['capital'])
    {
        if($data['broker_id'])
        {
            $data['kind'] = GranCapital\CapitalPerBroker::CAPITAL;
            
            if(GranCapital\CapitalPerBroker::addCapital($data['broker_id'],$data['capital'],$data['day'],$data['kind']))
            {
                $data["s"] = 1;
                $data["r"] = "DATA_OK";
            } else {
                $data["s"] = 0;
                $data["r"] = "NOT_USER_LOGIN_ID";
            }
        } else {
            $data["s"] = 0;
            $data["r"] = "NOT_BROKER_ID";
        }
    } else {
        $data["s"] = 0;
        $data["r"] = "NOT_CAPITAL";
    }
} else {
	$data["s"] = 0;
	$data["r"] = "NOT_FIELD_SESSION_DATA";
}

echo json_encode($data);