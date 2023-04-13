<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserSupport = new GranCapital\UserSupport;

if($UserSupport->_loaded === true)
{
    if($data['percentaje_gain'])
    {
        if(GranCapital\TradingPerformance::addPerformance(number_format($data['percentaje_gain'],2),$data['day']))
        {
            $data["s"] = 1;
            $data["r"] = "DATA_OK";
        } else {
            $data["s"] = 0;
            $data["r"] = "NOT_USER_LOGIN_ID";
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