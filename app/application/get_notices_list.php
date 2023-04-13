<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserLogin = new GranCapital\UserLogin;

if($UserLogin->_loaded === true)
{
    $Notice = new GranCapital\Notice;
    
    if($notices = format($Notice->getAllPublished()))
    {
        $data["notices"] = $notices;
        $data["s"] = 1;
        $data["r"] = "DATA_OK";
    } else {
        $data["s"] = 0;
        $data["r"] = "NOT_NOTICES";
    }
} else {
	$data["s"] = 0;
	$data["r"] = "NOT_FIELD_SESSION_DATA";
}

function isAviable(array $notice = null) : bool
{
    if($notice['start_date'] == 0 && $notice['end_date'] == 0)
    {
        return true;
    }
    
    $time = time();

    return $time >= $notice['start_date'] && $time <= $notice['end_date'];
}

function format($notices = null)
{
    if(is_array($notices) && sizeof($notices) > 0)
    {
        foreach($notices as $notice)
        {
            if(isAviable($notice))
            {
                $_notices[] = $notice;
            }
        }

        return $_notices;
    }

    return false;
}

echo json_encode($data);