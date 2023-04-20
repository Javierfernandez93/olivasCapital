<?php

namespace GranCapital;

use HCStudio\Orm;

use GranCapital\Transaction;

class WithdrawPerUser extends Orm
{
    const WAITING_FOR_DEPOSIT = 1;
    const DEPOSITED = 2;
    const DELETED = -1;
    
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

    public static function getTotalAmmountFromTransactions(array $transactions = null) 
    {
        return abs(array_sum(array_column($transactions,'ammount')));
    }

    public static function applyPartialWithdraw(array $data = null) 
    {
        $WithdrawPerUser = new WithdrawPerUser;

        if($transactions = $WithdrawPerUser->getAllByWallet($data['user_wallet_id']))
        {
            $total = self::getTotalAmmountFromTransactions($transactions);
            $rest = $total - $data['sent'];
        
            if(self::applyWithdrawAs($transactions,$data['user_support_id'],WithdrawPerUser::DELETED))
            {
                if(self::doSafeWithdrawAndSetAsDeposited([
                    'transactions' => $transactions,
                    'user_support_id' => $data['user_support_id'],
                    'user_wallet_id' => $data['user_wallet_id'],
                    'user_login_id' => $transactions[0]['user_login_id'],
                    'amount' => $data['sent'],
                    'catalog_withdraw_method_id' => $transactions[0]['catalog_withdraw_method_id']
                ]))
                {
                    return self::doWithdrawTransaction($transactions[0]['user_login_id'],$rest,$transactions[0]['catalog_withdraw_method_id']);
                }
            }
        }
    }

    public static function doWithdrawTransaction(int $user_login_id = null,float $amount = null,int $catalog_withdraw_method_id = null) : bool
    {
        $UserWallet = new UserWallet;

        if($UserWallet->getSafeWallet($user_login_id))
        {
            return $UserWallet->doTransaction($amount,Transaction::WITHDRAW,null,$catalog_withdraw_method_id);
        }
    }

    public static function doSafeWithdrawAndSetAsDeposited(array $data = null) : bool
    {
        if(self::doWithdrawTransaction($data['user_login_id'],$data['amount'],$data['catalog_withdraw_method_id']))
        {
            $WithdrawPerUser = new WithdrawPerUser;

            if($transactions = $WithdrawPerUser->getAllByWallet($data['user_wallet_id']))
            {
                return self::applyWithdrawAs($transactions,$data['user_support_id'],WithdrawPerUser::DEPOSITED);
            }
        }
    }

    public static function applyWithdrawAs(array $transactions = null,int $user_support_id = null,int $status = null) : bool
    {
        $saved = 0;
    
        $WithdrawPerUser = new WithdrawPerUser;
    
        foreach ($transactions as $transaction) 
        {
            if($WithdrawPerUser->cargarDonde("withdraw_per_user_id = ?",$transaction['withdraw_per_user_id']))
            {
                $WithdrawPerUser->status = $status;
                $WithdrawPerUser->user_support_id = $user_support_id;
                $WithdrawPerUser->apply_date = time();

                if($WithdrawPerUser->save())
                {
                    $TransactionPerWallet = new TransactionPerWallet;
                    
                    if($TransactionPerWallet->cargarDonde("transaction_per_wallet_id = ?",$transaction['transaction_per_wallet_id']))
                    {
                        $TransactionPerWallet->status = $status;

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
}
