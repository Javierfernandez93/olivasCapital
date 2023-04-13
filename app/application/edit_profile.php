<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserLogin = new GranCapital\UserLogin;

if($UserLogin->_loaded === true)
{
    $UserLogin->email = $data['email'];

    if($UserLogin->save())
    {
        if(updateUserData($data,$UserLogin->company_id))
        {
            if(updateUserContact($data,$UserLogin->company_id))
            {
                if(updateUserAccount($data,$UserLogin->company_id))
                {
                    if(updateUserAddress($data,$UserLogin->company_id))
                    {
                        $data["s"] = 1;
                        $data["r"] = "UPDATED_OK";
                    } else {
                        $data["s"] = 0;
                        $data["r"] = "NOT_UPDATED_USER_ADDRESS";
                    }  
                } else {
                    $data["s"] = 0;
                    $data["r"] = "NOT_UPDATED_USER_ACCOUNT";
                }            
            }  else {
                $data["s"] = 0;
                $data["r"] = "NOT_UPDATED_USER_CONTACT";
            }
        } else {
            $data["s"] = 0;
            $data["r"] = "NOT_UPDATED_USER_DATA";
        }
    } else {
        $data["s"] = 0;
        $data["r"] = "NOT_UPDATED_USER_LOGIN";
    }
} else {
	$data["s"] = 0;
	$data["r"] = "NOT_FIELD_SESSION_DATA";
}

function updateUserData($data = null,$company_id = null)
{
    $UserData = new GranCapital\UserData;   
        
    if($UserData->cargarDonde("user_login_id = ?",$company_id))
    {
        $UserData->names = $data['names'];
        
        return $UserData->save();
    }

    return false;
}

function updateUserContact($data = null,$company_id = null)
{
    $UserContact = new GranCapital\UserContact;   
        
    if($UserContact->cargarDonde("user_login_id = ?",$company_id))
    {
        $UserContact->phone = $data['phone'];
        return $UserContact->save();    
    }

    return false;
}


function updateUserAccount($data = null,$company_id = null)
{
    $UserAccount = new GranCapital\UserAccount;   
        
    if($UserAccount->cargarDonde("user_login_id = ?",$company_id))
    {
        $UserAccount->referral_notification = filter_var($data['referral_notification'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $UserAccount->referral_email = filter_var($data['referral_email'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $UserAccount->info_email = filter_var($data['info_email'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        
        return $UserAccount->save();
    }

    return false;
}

function updateUserAddress($data = null,$company_id = null)
{
    $UserAddress = new GranCapital\UserAddress;   
        
    if($UserAddress->cargarDonde("user_login_id = ?",$company_id))
    {
        $UserAddress->country_id = $data['country_id'];
        
        return $UserAddress->save();
    }

    return false;
}

echo json_encode($data);