<?php

namespace GranCapital;

use HCStudio\Orm;

class IntentChat extends Orm {
    protected $tblName  = 'intent_chat';
    public function __construct() {
        parent::__construct();
    }
    public function getAll($sheet_per_proyect_id = null) 
    {
        if(isset($sheet_per_proyect_id) === true)
        {
        	$sql = "SELECT 
        				{$this->tblName}.{$this->tblName}_id,
        				{$this->tblName}.words,
        				catalog_tag_intent_chat.tag
        			FROM 
        				{$this->tblName}
        			LEFT JOIN 
        				catalog_tag_intent_chat
        			ON
        				catalog_tag_intent_chat.catalog_tag_intent_chat_id = {$this->tblName}.catalog_tag_intent_chat_id
                    WHERE 
                        {$this->tblName}.sheet_per_proyect_id = '{$sheet_per_proyect_id}'
                    AND 
                        {$this->tblName}.status = '1'
        			";
                    
        	return $this->connection()->rows($sql);
        }

        return false;
    }

    public function getAllGroup($sheet_per_proyect_id = null) 
    {
        if(isset($sheet_per_proyect_id) === true)
        {
            $sql = "SELECT 
                        {$this->tblName}.{$this->tblName}_id,
                        {$this->tblName}.words,
                        catalog_tag_intent_chat.catalog_tag_intent_chat_id,
                        catalog_tag_intent_chat.tag
                    FROM 
                        {$this->tblName}
                    LEFT JOIN 
                        catalog_tag_intent_chat
                    ON
                        catalog_tag_intent_chat.catalog_tag_intent_chat_id = {$this->tblName}.catalog_tag_intent_chat_id
                    WHERE 
                        {$this->tblName}.sheet_per_proyect_id = '{$sheet_per_proyect_id}'
                    GROUP BY 
                        catalog_tag_intent_chat.catalog_tag_intent_chat_id
                    ";
                    
            return $this->connection()->rows($sql);
        }

        return false;
    }

    public function getCount($catalog_tag_intent_chat_id = null) 
    {
        if(isset($catalog_tag_intent_chat_id) === true)
        {
            $sql = "SELECT 
                        COUNT({$this->tblName}.{$this->tblName}_id) as c
                    FROM 
                        {$this->tblName}
                    WHERE 
                        {$this->tblName}.catalog_tag_intent_chat_id = '{$catalog_tag_intent_chat_id}'
                    AND 
                        {$this->tblName}.status = '1'
                    ";
                    
            return $this->connection()->field($sql);
        }

        return false;
    }

    public function getAllWords($catalog_tag_intent_chat_id = null) 
    {
        if(isset($catalog_tag_intent_chat_id) === true)
        {
            $sql = "SELECT 
                        {$this->tblName}.words
                    FROM 
                        {$this->tblName}
                    WHERE 
                        {$this->tblName}.catalog_tag_intent_chat_id = '{$catalog_tag_intent_chat_id}'
                    AND 
                        {$this->tblName}.status = '1'
                    ";
                    
            return $this->connection()->column($sql);
        }

        return false;
    }

    public function getAllLike($sheet_per_proyect_id = null,$words = null) 
    {
        if(isset($sheet_per_proyect_id,$words) === true)
        {
            $sql = "SELECT 
                        {$this->tblName}.{$this->tblName}_id,
                        {$this->tblName}.words,
                        catalog_tag_intent_chat.tag,
                        MATCH(`words`) AGAINST ('{$words}' IN BOOLEAN MODE) as rel1
                    FROM 
                        {$this->tblName}  
                    LEFT JOIN 
                        catalog_tag_intent_chat
                    ON
                        catalog_tag_intent_chat.catalog_tag_intent_chat_id = {$this->tblName}.catalog_tag_intent_chat_id
                    WHERE 
                    MATCH 
                        (words) 
                    AGAINST 
                        ('{$words}' IN BOOLEAN MODE)
                    ORDER BY 
                        rel1
                    DESC
                    ";
                    
            return $this->connection()->rows($sql);
        }

        return false;
    }
}