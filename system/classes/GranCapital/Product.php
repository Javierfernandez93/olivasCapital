<?php

namespace GranCapital;

use HCStudio\Orm;
use HCStudio\Util;

class Product extends Orm {
	protected $tblName = 'product';
	public static $VISIBLE = 1;
	public static $PRODUCT_PER_COLUMN = 4;
	public static $INVISIBLE = 0;
	public static $DELETED = -1;
	public static $MAX_TITLE_LETTERS = 15;
	public function __construct() {
		parent::__construct();
	}

	public function getColorByVisible($visible = null)
	{
		if($visible == self::$VISIBLE) { 
        	return "bg-success";
      	} else if($visible == self::$INVISIBLE) { 
        	return "bg-secondary";
        }  
	}

	public function sanitizeTitle($title = null) : string 
	{
		return strlen($title) > self::$MAX_TITLE_LETTERS ? substr($title, 0, self::$MAX_TITLE_LETTERS). "..." : $title;
	}
	public function getKeyWords($keywords = null)
	{
		return isset($keywords) === true ? explode(",", $keywords) : false;
	}

	public function countProducts($in = null,$filter = "AND product.visible = '1'")
	{
		$sql = "SELECT 
					{$this->tblName}.{$this->tblName}_id
				FROM 
					{$this->tblName}
				LEFT JOIN
					catalog_brand
				ON 
					catalog_brand.catalog_brand_id = {$this->tblName}.catalog_brand_id
				LEFT JOIN
					catalog_product
				ON 
					catalog_product.catalog_product_id = {$this->tblName}.catalog_product_id
				WHERE 
					{$this->tblName}.status = '1'
					{$filter}
				AND 
					catalog_product.catalog_product_id IN ({$in})
				GROUP BY
					{$this->tblName}.{$this->tblName}_id
				";
		
		return $this->connection()->column($sql);
	}

	public function getProductsIn($in = null,$in_catalog_products = null,$filter = "AND product.visible = '1'")
	{
		$sql = "SELECT 
					{$this->tblName}.{$this->tblName}_id,
					{$this->tblName}.sku,
					{$this->tblName}.title,
					{$this->tblName}.description,
					{$this->tblName}.keywords,
					{$this->tblName}.create_date,
					{$this->tblName}.update_date,
					{$this->tblName}.visible,
					{$this->tblName}.status,
					catalog_product.catalog_product_id,
					catalog_product.catalog_product,
					catalog_brand.brand
				FROM 
					{$this->tblName}
				LEFT JOIN
					catalog_brand
				ON 
					catalog_brand.catalog_brand_id = {$this->tblName}.catalog_brand_id
				LEFT JOIN
					catalog_product
				ON 
					catalog_product.catalog_product_id = {$this->tblName}.catalog_product_id
				WHERE 
					{$this->tblName}.status = '1'
				AND 
					{$this->tblName}.product_id IN({$in})
					{$filter}
				AND 
					catalog_product.catalog_product_id IN ({$in_catalog_products})
				";
				
		return $this->connection()->rows($sql);
	}
	
	public function getRandomProductsIn($in = null)
	{
		if($products = $this->countProducts($in))
		{
			shuffle($products);

			$products = array_slice($products, 0, self::$PRODUCT_PER_COLUMN);

			array_keys($products);

			return $this->getProductsIn(implode(",", $products),$in);
		}
	}

	public function getSingleProducts($filter = "AND product.visible = '1'")
	{
		$sql = "SELECT 
					{$this->tblName}.{$this->tblName}_id,
					{$this->tblName}.title,
					{$this->tblName}.promo_price,
					{$this->tblName}.price
				FROM 
					{$this->tblName}
				WHERE 
					{$this->tblName}.status = '1'
				ORDER BY 
					{$this->tblName}.create_date 
				DESC
				LIMIT 
					0,".self::$PRODUCT_PER_COLUMN
				;
		
		return $this->connection()->rows($sql);
	}

	public function getAllProducts($filter = "AND product.visible = '1'")
	{
		$sql = "SELECT 
					{$this->tblName}.{$this->tblName}_id,
					{$this->tblName}.title,
					{$this->tblName}.promo_price,
					{$this->tblName}.price
				FROM 
					{$this->tblName}
				WHERE 
					{$this->tblName}.status = '1'";
		
		return $this->connection()->rows($sql);
	}

	public function existSku($sku = null)
	{
		if (isset($sku) === true) 
		{
			$sql = "SELECT 
						{$this->tblName}.sku
					FROM 
						{$this->tblName}
					WHERE 
						{$this->tblName}.sku = '{$sku}'
					AND
						{$this->tblName}.status = '1'
						";
			
			return $this->connection()->field($sql) ? true : false;
		}
		
		return false;
	}

	public function existCode($code = null)
	{
		if (isset($code) === true) 
		{
			$sql = "SELECT 
						{$this->tblName}.code
					FROM 
						{$this->tblName}
					WHERE 
						{$this->tblName}.code = '{$code}'
					AND
						{$this->tblName}.status = '1'
						";
			
			return $this->connection()->field($sql) ? true : false;
		}
		
		return false;
	}

	public function getAll($store_per_user_id = null)
	{
		$sql = "SELECT 
					{$this->tblName}.{$this->tblName}_id,
					{$this->tblName}.sku,
					{$this->tblName}.title,
					{$this->tblName}.price,
					{$this->tblName}.promo_price,
					{$this->tblName}.description,
					{$this->tblName}.keywords,
					{$this->tblName}.create_date,
					{$this->tblName}.update_date,
					{$this->tblName}.visible,
					{$this->tblName}.status,
					catalog_product.catalog_product,
					catalog_brand.brand
				FROM 
					{$this->tblName}
				LEFT JOIN
					catalog_brand
				ON 
					catalog_brand.catalog_brand_id = {$this->tblName}.catalog_brand_id
				LEFT JOIN
					catalog_product
				ON 
					catalog_product.catalog_product_id = {$this->tblName}.catalog_product_id
				WHERE 
					{$this->tblName}.status = '1'
				AND 
					{$this->tblName}.store_per_user_id = '{$store_per_user_id}'
				";
		
		return $this->connection()->rows($sql);
	}

	public function getCount()
	{
		$sql = "SELECT 
					COUNT({$this->tblName}.{$this->tblName}_id) as c
				FROM 
					{$this->tblName}
				WHERE 
					{$this->tblName}.status = '1'
				";
		
		return $this->connection()->field($sql);
	}
}