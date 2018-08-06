<?php

class ViewSalesVM extends DatabaseObject {
    public static $table_name = "view_sales";
    public static $db_fields = ['item_name', 'quantity', 'date'];
    public $item_name;
    public $quantity;
    public $date;


    public static function get_sales_by_date($from_date, $to_date) {
        $sql = "SELECT * FROM ".self::$table_name." WHERE  date >= '{$from_date}' AND date <='{$to_date}'";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? $result_array : false;
    }
}


?>