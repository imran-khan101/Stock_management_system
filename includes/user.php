<?php

require_once LIB_PATH . DS . "database.php";

class User extends DatabaseObject {
    protected static $table_name = "users";
    protected static $db_fields = ['id', 'username', 'password', 'first_name', 'last_name', 'email'];

    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $email;

    //public $remember_token;


    public static function authenticate($email_username = "") {
        global $database;
        $email_username = $database->escape_value($email_username);

        $sql = "SELECT * FROM users WHERE email='{$email_username}' OR username='{$email_username}' LIMIT 1";

        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;

    }

    public static function user_already_exists($username, $email) {
        global $database;
        $username = $database->escape_value($username);
        $email = $database->escape_value($email);

        $sql = "SELECT * FROM users WHERE username='{$username}' OR email='{$email}' LIMIT 1";

        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? true : false;
    }

    public static function current_user() {
        if (isset($_SESSION['user_id'])) {
            return self::find_by_id($_SESSION['user_id']);
        }
    }

    public function full_name() {
        if (isset($this->first_name) && isset($this->last_name)) {
            return $this->first_name . " " . $this->last_name;
        }
    }

}
