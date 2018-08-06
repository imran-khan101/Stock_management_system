<?php
require_once LIB_PATH . DS . "database.php";

//Early Static binding

class DatabaseObject {

    protected static $table_name;
    protected static $db_fields = [];

    public static function find_all() {
        //here static will select the child object
        return self::find_by_sql("SELECT * FROM " . static::$table_name);
    }

    public static function find_by_sql($sql = "") {
        global $database;
        $result_set = $database->query($sql);
        $object_array = [];
        while ($row = $database->fetch_array($result_set)) {
            $object_array[] = self::instantiate($row);
        }
        return $object_array;
    }

    private static function instantiate($record) {

        //could check that $record exists and is an array
        //Simple,log-form approach
        $object = new static();//will initialize a child object
        /*$object = new self;
        $object->id = $record['id'];
        $object->username = $record['username'];
        $object->password = $record['password'];
        $object->first_name = $record['first_name'];
        $object->last_name = $record['last_name'];*/

        //more dynamic
        foreach ($record as $attribute => $value) {
            if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }

        return $object;
    }

    private function has_attribute($attribute) {
        $object_vars = get_object_vars($this);
        return array_key_exists($attribute, $object_vars);
    }

    public static function count_all() {
        global $database;
        $sql = "SELECT COUNT(*) FROM " . static::$table_name;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

    public static function find_by_id($id = 0) {
        global $database;
        $result_array = self::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE id =" . $database->escape_value($id) . " LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public function save() {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function update() {
        global $database;
        $attributes = $this->sanitized_attributes();
        foreach ($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE " . static::$table_name . " SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE id = {$database->escape_value($this->id)}";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }

    protected function sanitized_attributes() {
        global $database;
        $clean_attributes = [];
        foreach ($this->attributes() as $key => $value) {
            $clean_attributes[$key] = $database->escape_value($value);
        }

        return $clean_attributes;
    }

    protected function attributes() {
        $attributes = [];
        foreach (static::$db_fields as $field) {
            if (property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    public function create() {
        global $database;
        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO " . static::$table_name . " (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        if ($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }

    public function delete() {
        global $database;
        $sql = "DELETE FROM " . static::$table_name . " WHERE id={$database->escape_value($this->id)} LIMIT 1";
        $database->query($sql);
        if ($database->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}