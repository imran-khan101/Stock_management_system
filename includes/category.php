<?php


class Category extends DatabaseObject {
    public static $table_name = "categories";
    public static $db_fields = ['id', 'name'];
    public $id;
    public $name;
}

?>