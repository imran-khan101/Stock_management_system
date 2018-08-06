<?php


class Company extends DatabaseObject {
    public static $table_name = "companies";
    public static $db_fields = ['id', 'name'];
    public $id;
    public $name;


}

?>