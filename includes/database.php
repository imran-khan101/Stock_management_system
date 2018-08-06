<?php

require_once LIB_PATH.DS."config.php";

class MySQLDatabase {
    public $last_query;
    private $connection;
    private $magic_quotes_active;
    private $new_enough_php;

    function __construct() {
        $this->open_connection();
        $this->magic_quotes_active = get_magic_quotes_gpc();
        $this->new_enough_php = function_exists("mysqli_real_escape_string");

    }

    public function open_connection() {
        $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if (!$this->connection) {
            die("Database connection failed" . mysqli_error());
        } else {

        }
    }

    public function close_connection() {
        if (isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }

    public function query($sql) {
        $this->last_query = $sql;
        $result = mysqli_query($this->connection, $sql);
        $this->confirm_query($result);
        return $result;
    }

    private function confirm_query($result) {
        if (!$result) {
            $output = "Operation failed " . mysqli_error($this->connection) . "<br>";
            $output .= "Last SQL Query: " . $this->last_query;
            die($output);
        }
    }

    public function fetch_array($result_set) {
        return mysqli_fetch_array($result_set);
    }

    public function num_rows($result_set) {
        return mysqli_num_rows($result_set);
    }

    public function insert_id() {
        return mysqli_insert_id($this->connection);
    }

    public function affected_rows() {
        return mysqli_affected_rows($this->connection);
    }

    public function escape_value($value) {
        if ($this->new_enough_php) {
            if ($this->magic_quotes_active) {
                $value = stripslashes($value);
            }
            $value = mysqli_real_escape_string($this->connection, $value);
        } else {
            if (!$this->magic_quotes_active) {
                $value = addcslashes($value);
            }
        }
        return $value;
    }


}

$database = new MySQLDatabase();

