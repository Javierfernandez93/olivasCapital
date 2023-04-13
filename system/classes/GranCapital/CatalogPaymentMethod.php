<?php

namespace GranCapital;

use HCStudio\Orm;

class CatalogPaymentMethod extends Orm {
	protected $tblName = 'catalog_payment_method';

	public static $DEPOSIT = 1;
	public static $CASH = 2;
	public function __construct() {
		parent::__construct();
	}

	public function getAll()
	{
		$sql = "SELECT 
					{$this->tblName}.{$this->tblName}_id,
					{$this->tblName}.payment_method
				FROM 
					{$this->tblName}
				WHERE 
					{$this->tblName}.status = '1'
				";
		
		return $this->connection()->rows($sql);
	}

	public function get($catalog_payment_method_id = null)
	{
		if(isset($catalog_payment_method_id) == true)
		{
			$sql = "SELECT 
						{$this->tblName}.{$this->tblName}_id,
						{$this->tblName}.permission,
						{$this->tblName}.description
					FROM 
						{$this->tblName}
					WHERE 
						{$this->tblName}.status = '1'
					";
			
			return $this->connection()->rows($sql);
		}

		return false;
	}
}