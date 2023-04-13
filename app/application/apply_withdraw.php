<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserSupport = new GranCapital\UserSupport;

if($UserSupport->_loaded === true)
{
    if($data['user_login_id'])
    {
        $UserWallet = new GranCapital\UserWallet;
        
        if($UserWallet->getSafeWallet($data['user_login_id']))
        {
            $WithdrawPerUser = new GranCapital\WithdrawPerUser;
        
            if($transactions = $WithdrawPerUser->getAllByWallet($UserWallet->getId()))
            {
                if(applyWithdraw($transactions))
                {
                    if(GranCapital\NotificationPerUser::push($UserWallet->user_login_id,"Hemos enviado tu depósito pendiente",GranCapital\CatalogNotification::GAINS))
                    {
                        $data['push_sent'] = true;
                    }

                    if(sendEmail($UserSupport->getUserEmail($UserWallet->user_login_id)))
                    {
                        $data["email_sent"] = true;
                    }

                    $data["s"] = 1;
                    $data["r"] = "DATA_OK";
                } else {
                    $data["s"] = 0;
                    $data["r"] = "WITHDRAWS_NOT_APPLIED";
                }
            } else {
                $data["s"] = 0;
                $data["r"] = "NOT_WITHDRAWS";
            }
        } else {
            $data["s"] = 0;
            $data["r"] = "NOT_WALLET";
        }
    } else {
        $data["s"] = 0;
        $data["r"] = "NOT_WITHDRAWS";
    }
} else {
	$data["s"] = 0;
	$data["r"] = "NOT_FIELD_SESSION_DATA";
}

function applyWithdraw(array $transactions = null) : bool
{
    $saved = 0;

    $WithdrawPerUser = new GranCapital\WithdrawPerUser;

    foreach ($transactions as $transaction) 
    {
        if($WithdrawPerUser->cargarDonde("withdraw_per_user_id = ?",$transaction['withdraw_per_user_id']))
        {
            $WithdrawPerUser->status = GranCapital\WithdrawPerUser::DEPOSITED;
            $WithdrawPerUser->apply_date = time();
            
            if($WithdrawPerUser->save())
            {
                $TransactionPerWallet = new GranCapital\TransactionPerWallet;
                
                if($TransactionPerWallet->cargarDonde("transaction_per_wallet_id = ?",$transaction['transaction_per_wallet_id']))
                {
                    $TransactionPerWallet->status = GranCapital\WithdrawPerUser::DEPOSITED;
                    
                    if($TransactionPerWallet->save())
                    {
                        $saved++;
                    }
                }
            }
        }
    }

    return $saved == sizeof($transactions);
}

function sendEmail(string $email = null) : bool
{
    if(isset($email) === true)
    {
        require_once TO_ROOT . '/vendor/autoload.php';
        
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $Layout = JFStudio\Layout::getInstance();
            $Layout->init("",'withdrawApplied',"mail",TO_ROOT.'/apps/applications/',TO_ROOT.'/');

            $Layout->setScriptPath(TO_ROOT . '/apps/admin/src/');
    		$Layout->setScript(['']);

            $CatalogMailController = GranCapital\CatalogMailController::init(1);

            $Layout->setVar([
                "email" => $email
            ]);

            $mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_OFF; // PHPMailer\PHPMailer\SMTP::DEBUG_SERVER
            $mail->isSMTP(); 
            // $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            $mail->Host = $CatalogMailController->host;
            $mail->SMTPAuth = true; 
            $mail->Username = $CatalogMailController->mail;
            $mail->Password =  $CatalogMailController->password;
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = $CatalogMailController->port; 

            //Recipients
            $mail->setFrom($CatalogMailController->mail, $CatalogMailController->sender);
            $mail->addAddress($email, 'Usuario');     

            //Content
            $mail->isHTML(true);                                  
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Gran Capital - Fondos retirados';
            $mail->Body = $Layout->getHtml();
            $mail->AltBody = strip_tags($Layout->getHtml());

            return $mail->send();
        } catch (Exception $e) {
            
        }
    }

    return false;
}

echo json_encode($data);