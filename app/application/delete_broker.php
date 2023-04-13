<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserSupport = new GranCapital\UserSupport;

if($UserSupport->_loaded === true)
{
    if($data['broker_id'])
    {
        $Broker = new GranCapital\Broker;

        if($Broker->cargarDonde('broker_id = ?',$data['broker_id']))
        {
            $Broker->status = GranCapital\Broker::DELETE;
            
            if($Broker->save())
            {
                $data["s"] = 1;
                $data["r"] = "SAVE_OK";    
            } else {
                $data["s"] = 1;
                $data["r"] = "NOT_SAVE";    
            }
        } else {
            $data["s"] = 1;
            $data["r"] = "NOT_BROKER";    
        }
    } else {
        $data["s"] = 0;
        $data["r"] = "NOT_BROKER_ID";    
    }
} else {
	$data["s"] = 0;
	$data["r"] = "NOT_FIELD_SESSION_DATA";
}

echo json_encode($data);