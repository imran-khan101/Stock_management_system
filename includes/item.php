<?php

class Item extends DatabaseObject {
    public static $table_name = "items";
    public static $db_fields = ['id', 'category_id', 'company_id', 'name', 'reorder_level'];
    public $id;
    public $category_id;
    public $company_id;
    public $name;
    public $reorder_level;


    public static function get_item_by_company_id($id = 0) {
        $sql = "SELECT * FROM " . self::$table_name . " WHERE company_id={$id}";
        $items = self::find_by_sql($sql);
        return $items;
    }

}

?>