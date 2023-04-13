<?php

namespace GranCapital;

use HCStudio\Orm;

use GranCapital\Transaction;

class WithdrawPerUser extends Orm
{
    const WAITING_FOR_DEPOSIT = 1;
    const DEPOSITED = 2;
    protected $tblName  = 'withdraw_per_user';

    public function __construct()
    {
        parent::__construct();
    }

    public function doWithdraw(int $transaction_per_wallet_id = null,int $catalog_withdraw_method_id = null,bool $force = false) : bool
    {
        if(isset($transaction_per_wallet_id,$catalog_withdraw_method_id) === true)
        {
            $WithdrawPerUser = new WithdrawPerUser;
            $WithdrawPerUser->transaction_per_wallet_id = $transaction_per_wallet_id;
            $WithdrawPerUser->catalog_withdraw_method_id = $catalog_withdraw_method_id;
            $WithdrawPerUser->status = $force === true ? self::DEPOSITED : self::WAITING_FOR_DEPOSIT;
            $WithdrawPerUser->create_date = time();

            return $WithdrawPerUser->save();
        }

        return false;
    }
    
    public function getAll(int $status = null) 
    {
        $sql = "SELECT 
                    withdraw_per_user.withdraw_per_user_id,
                    withdraw_per_user.status,
                    SUM(transaction_per_wallet.ammount) as ammount,
                    transaction_per_wallet.user_wallet_id,
                    transaction_per_wallet.create_date,
                    withdraw_per_user.catalog_withdraw_method_id,
                    user_wallet.user_login_id
                FROM 
                    transaction_per_wallet
                LEFT JOIN
                    withdraw_per_user
                ON 
                    withdraw_per_user.transaction_per_wallet_id = transaction_per_wallet.transaction_per_wallet_id
                LEFT JOIN
                    user_wallet
                ON 
                    user_wallet.user_wallet_id = transaction_per_wallet.user_wallet_id
                WHERE 
                    withdraw_per_user.status = '{$status}'
                AND 
                    transaction_per_wallet.transaction_id = '".Transaction::WITHDRAW."'
                GROUP BY 
                    transaction_per_wallet.user_wallet_id
                ";

        return $this->connection()->rows($sql);
    }
    
    public function getAllByWallet(int $user_wallet_id = null) 
    {
        if(isset($user_wallet_id) === true)
        {
            $sql = "SELECT 
                        transaction_per_wallet.transaction_per_wallet_id,
                        transaction_per_wallet.ammount,
                        transaction_per_wallet.user_wallet_id,
                        transaction_per_wallet.create_date,
                        withdraw_per_user.withdraw_per_user_id,
                        withdraw_per_user.catalog_withdraw_method_id,
                        user_wallet.user_login_id
                    FROM 
                        transaction_per_wallet
                    LEFT JOIN
                        withdraw_per_user
                    ON 
                        withdraw_per_user.transaction_per_wallet_id = transaction_per_wallet.transaction_per_wallet_id
                    LEFT JOIN
                        user_wallet
                    ON 
                        user_wallet.user_wallet_id = transaction_per_wallet.user_wallet_id
                    WHERE 
                        transaction_per_wallet.user_wallet_id = '{$user_wallet_id}'
                    AND 
                        transaction_per_wallet.transaction_id = '".Transaction::WITHDRAW."'
                    AND 
                        transaction_per_wallet.status = '1'
                    ";

            return $this->connection()->rows($sql);
        }
    }
    
    public function getCountPending() 
    {
        $sql = "SELECT 
                    COUNT({$this->tblName}.{$this->tblName}_id) as c
                FROM 
                    {$this->tblName}
                LEFT JOIN 
                    transaction_per_wallet
                ON 
                    transaction_per_wallet.transaction_per_wallet_id = {$this->tblName}.transaction_per_wallet_id
                WHERE 
                    {$this->tblName}.status = '".self::WAITING_FOR_DEPOSIT."'
                GROUP BY 
                    transaction_per_wallet.user_wallet_id 
                ";

        return $this->connection()->field($sql);
    }
}
