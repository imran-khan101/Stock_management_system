<?php

class Stock extends DatabaseObject {
    public static $table_name = "stocks";
    public static $db_fields = ['id', 'item_id', 'quantity', 'date'];

    public $id;
    public $item_id;
    public $quantity;
    public $date;

    public static function find_item_in_stock($item_id = 0) {
        global $database;
        $result_array = self::find_by_sql("SELECT * FROM " . Self::$table_name . " WHERE item_id =" . $database->escape_value($item_id) . " LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;

    }

    public static function update_stock($items, $type) {
        global $database;
        foreach ($items as $item) {
            $result = $database->query("UPDATE stocks SET quantity = quantity - " . $database->escape_value($item->quantity) . " WHERE item_id =" . $database->escape_value($item->item_id) . " LIMIT 1");
            if (!empty($result)) {
                $result = $database->query("INSERT INTO stock_out (item_id, quantity,type, date) VALUES ('" . $database->escape_value($item->item_id) . "','" . $database->escape_value($item->quantity) . "','" . $database->escape_value($type) . "','" . strftime('%Y/%m/%d %H:%M:%S', time()) . "') ");
            }
        }
        return !empty($result) ? true : false;
    }

}


?>