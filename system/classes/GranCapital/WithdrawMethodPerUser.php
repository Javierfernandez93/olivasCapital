<?php

namespace GranCapital;

use HCStudio\Orm;

use GranCapital\CatalogWithdrawMethod;

class WithdrawMethodPerUser extends Orm {
	protected $tblName = 'withdraw_method_per_user';
	public function __construct() {
		parent::__construct();
	}

	public function getAccount(int $user_login_id = null,int $catalog_withdraw_method_id = null)
    {
        if(isset($user_login_id,$catalog_withdraw_method_id) === true) 
        {
            $sql = "SELECT 
                        {$this->tblName}.account,
                        {$this->tblName}.wallet
                    FROM 
                        {$this->tblName}
                    WHERE 
                        {$this->tblName}.user_login_id = '{$user_login_id}'
                    AND
                        {$this->tblName}.catalog_withdraw_method_id = '{$catalog_withdraw_method_id}'
                    AND
                        {$this->tblName}.status = '1'
                    ";
            
            return $this->connection()->row($sql);
        }
    }

	public function getAll(int $user_login_id = null)
	{
        if(isset($user_login_id) === true) 
        {
            $CatalogWithdrawMethod = new CatalogWithdrawMethod;
            
            if($catalogs_withdraw_methods = $CatalogWithdrawMethod->getAll())
            {
                $catalogs_withdraw_methods = array_map(function($catalog_withdraw_method) use ($user_login_id) {
                    if($account = $this->getAccount($user_login_id,$catalog_withdraw_method['catalog_withdraw_method_id'])) {
                        $catalog_withdraw_method['account'] = $account['account'];
                        $catalog_withdraw_method['wallet'] = $account['wallet'];
                    }
                    
                    $catalog_withdraw_method['editing'] = false;

                    return $catalog_withdraw_method;
                },$catalogs_withdraw_methods);

                return $catalogs_withdraw_methods;
            }
        }
	}
    
    public function getMethod(int $user_login_id = null, int $catalog_withdraw_method_id = null) 
    {
        if(isset($user_login_id,$catalog_withdraw_method_id) === true)
        {
            $sql = "SELECT 
                        {$this->tblName}.account,
                        {$this->tblName}.wallet,
                        catalog_withdraw_method.method
                    FROM 
                        {$this->tblName}
                    LEFT JOIN 
                        catalog_withdraw_method
                    ON 
                        catalog_withdraw_method.catalog_withdraw_method_id = {$this->tblName}.catalog_withdraw_method_id
                    WHERE 
                        {$this->tblName}.user_login_id = '{$user_login_id}'
                    AND 
                        {$this->tblName}.catalog_withdraw_method_id = '{$catalog_withdraw_method_id}'
                    ";

            return $this->connection()->row($sql);
        }

        return false;
    }
}