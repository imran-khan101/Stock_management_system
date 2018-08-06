<?php

class ItemSummary extends DatabaseObject {
    public static $table_name = "item_summary";
    public static $db_fields = ['item_id', 'item_name', 'category_id','company_id', 'company_name',  'category_name','category_id', 'reorder_level', 'quantity'];
    public $item_id;
    public $item_name;
    public $company_id;
    public $company_name;
    public $category_name;
    public $category_id;
    public $reorder_level;
    public $quantity;

    public static function get_item_summary($company_id = 0, $category_id = 0) {
        if ($category_id && $company_id) {
            $sql = "SELECT * FROM item_summary WHERE category_id ={$category_id} AND company_id={$company_id} ORDER BY item_name";
        } elseif ($category_id) {
            $sql = "SELECT * FROM item_summary WHERE category_id ={$category_id}";
        } elseif ($company_id) {
            $sql = "SELECT * FROM item_summary WHERE company_id ={$company_id}";
        }
        $items = self::find_by_sql($sql);
        return $items;
    }
}

?>