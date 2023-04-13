<?php define("TO_ROOT", "../../");

require_once TO_ROOT. "/system/core.php";

$data = HCStudio\Util::getHeadersForWebService();

$UserLogin = new GranCapital\UserLogin;

if($UserLogin->_loaded === true)
{
    if($data['ammount'])
    {
        if($data['catalog_currency_id'])
        {
            $TransactionRequirementPerUser = new GranCapital\TransactionRequirementPerUser;
            $TransactionRequirementPerUser->user_login_id = $UserLogin->company_id;
            $TransactionRequirementPerUser->ammount = $data['ammount'];
            $TransactionRequirementPerUser->catalog_currency_id = $data['catalog_currency_id'];
            $TransactionRequirementPerUser->create_date = time();
            
            if($TransactionRequirementPerUser->save())
            {
                $data['transaction_requirement_per_user_id'] = $TransactionRequirementPerUser->getId();
                $data['code'] = (new GranCapital\CatalogCurrency)->getCode($data['catalog_currency_id']);

                if($checkoutData = createTransaction($UserLogin->email,$data))
                {
                    $TransactionRequirementPerUser->txn_id = $checkoutData['txn_id'];
                    $TransactionRequirementPerUser->checkout_data = json_encode($checkoutData);
                    
                    if($TransactionRequirementPerUser->save())
                    {
                        $data["checkoutData"] = $checkoutData;
                        $data["s"] = 1;
                        $data["r"] = "DATA_OK";
                    } else {
                        $data["s"] = 0;
                        $data["r"] = "NOT_UPDATE";
                    }
                } else {
                    $data["s"] = 0;
                    $data["r"] = "NOT_SAVE";
                }
            } else {
                $data["s"] = 0;
                $data["r"] = "NOT_CATALOG_CURRENCY_ID";    
            }
        } else {
            $data["s"] = 0;
            $data["r"] = "NOT_CATALOG_CURRENCY_ID";
        }
    } else {
        $data["s"] = 0;
        $data["r"] = "NOT_AMMOUNT";
    }
} else {
	$data["s"] = 0;
	$data["r"] = "NOT_FIELD_SESSION_DATA";
}

function createTransaction(string $email = null,array $data = null)
{
    require_once TO_ROOT .'/vendor2/autoload.php';

    $public_key = 'cebe7cb0a97ae5dde4ea7ae4f263cce8440d1c4a5278d7112e1348e04313bd18';
    $private_key = '3f5bA70eF5E0B25eb1cd039571C0D58F90c3d11a97A65DF0C3a788cc0f8E2029';

    try {
        $cps_api = new CoinpaymentsAPI($private_key, $public_key, 'json');

        $req = [
            'amount' => $data['ammount'],
            'currency1' => 'USD',
            'currency2' => $data['code'],
            'buyer_email' => $email,
            'item_name' => 'Fondos en Gran Capital',
            'item_number' => (string)$data['transaction_requirement_per_user_id'],
            'address' => '', // leave blank send to follow your settings on the Coin Settings page
            'ipn_url' => 'https://grancapital.fund/ipn_handler.php',
        ];
                        
        $result = $cps_api->CreateCustomTransaction($req);
        
        if ($result['error'] == 'ok') {

            return $result['result'];
        } else {
            print 'Error: '.$result['error']."\n";
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        exit();
    }
}

echo json_encode($data);