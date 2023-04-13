<?php

namespace GranCapital;

use HCStudio\Orm;
use HCStudio\Util;

class Course extends Orm {
	protected $tblName = 'course';
	public function __construct() {
		parent::__construct();
	}

	public function getList()
    {
        $sql = "SELECT 
                    {$this->tblName}.{$this->tblName}_id,
                    {$this->tblName}.title,
                    {$this->tblName}.description,
                    {$this->tblName}.price,
                    {$this->tblName}.create_date,
                    {$this->tblName}.image,
                    catalog_course.name,
                    catalog_course_type.type,
                    CONCAT_WS(' ',user_data.names,user_data.last_name,user_data.second_last_name) as names
                FROM 
                    {$this->tblName}
                LEFT JOIN 
                    catalog_course
                ON
                    catalog_course.catalog_course_id = {$this->tblName}.catalog_course_id
                LEFT JOIN 
                    catalog_course_type
                ON
                    catalog_course_type.catalog_course_type_id = {$this->tblName}.catalog_course_type_id
                LEFT JOIN 
                    user_data
                ON
                    user_data.user_login_id = {$this->tblName}.user_login_id
                WHERE 
                    {$this->tblName}.status = '1'
                ";
        
        return $this->connection()->rows($sql);
	}

    public function get($course_id = null) 
    {
        if(isset($course_id) === true)
        {
            $sql = "SELECT 
                        {$this->tblName}.{$this->tblName}_id,
                        {$this->tblName}.title,
                        {$this->tblName}.description,
                        {$this->tblName}.price,
                        {$this->tblName}.create_date,
                        {$this->tblName}.image,
                        user_setting.image as user_image,
                        catalog_course.name,
                        catalog_course_type.type,
                        CONCAT_WS(' ',user_data.names,user_data.last_name,user_data.second_last_name) as names
                    FROM 
                        {$this->tblName}
                    LEFT JOIN 
                        catalog_course
                    ON
                        catalog_course.catalog_course_id = {$this->tblName}.catalog_course_id
                    LEFT JOIN 
                        catalog_course_type
                    ON
                        catalog_course_type.catalog_course_type_id = {$this->tblName}.catalog_course_type_id
                    LEFT JOIN 
                        user_data
                    ON
                        user_data.user_login_id = {$this->tblName}.user_login_id
                    LEFT JOIN 
                        user_setting
                    ON
                        user_setting.user_login_id = {$this->tblName}.user_login_id
                    WHERE 
                        {$this->tblName}.status = '1'
                    AND
                        {$this->tblName}.{$this->tblName}_id = '{$course_id}'
                    ";
            
            return $this->connection()->row($sql);
        }

        return false;
	}
}