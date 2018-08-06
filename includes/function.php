<?php

function strip_zeros_from_date($marked_string = "") {
    // first remove the marked zeros
    $no_zeros = str_replace('*0', '', $marked_string);
    // then remove any remaining marks
    $cleaned_string = str_replace('*', '', $no_zeros);
    return $cleaned_string;
}

function redirect_to($location = NULL) {
    if ($location != NULL) {
        header("Location: {$location}");
        exit;
    }
}

function output_message($message = "") {
    if (!empty($message)) {
        return "<p class=\"message\">{$message}</p>";
    } else {
        return "";
    }
}

/*function __autoload($class_name) {
    $class_name = strtolower($class_name);
    $path = LIB_PATH . DS . "{$class_name}.php";
    if (file_exists($path)) {
        require_once($path);
    } else {
        die("The file {$class_name}.php could not be found.");
    }
}*/

function include_layout_template($template = "") {
    include(SITE_ROOT . DS . 'public' . DS . 'layouts' . DS . $template);
}

function log_action($action, $message = "") {
    chdir(SITE_ROOT . DS . "logs/");
    $txt = strftime('%m/%d/%Y %H:%M:%S', time()) . "|" . $action . " " . $message;
    if (!is_log_file_exists()) {
        create_new_log_file();
        file_put_contents('log_file.txt', $txt . PHP_EOL, FILE_APPEND | LOCK_EX);
    } else {
        file_put_contents('log_file.txt', $txt . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

}

function is_log_file_exists() {
    $dir = "../logs";
    if (is_dir($dir)) {
        return file_exists($dir . "/log_file.txt") ? true : false;
    }
}

function create_new_log_file() {
    chdir("../logs");
    $file = 'log_file.txt';
    if ($handle = fopen($file, 'w')) {
        $content = "Log file created in : " . strftime('%m/%d/%Y %H:%M:%S', time()) . "\n";
        fwrite($handle, $content);
        fclose($handle);
    }
}

function datetime_to_text($datetime) {
    $unixdatetime = strtotime($datetime);
    return strftime("%B %d,%Y at %I:%M %p", $unixdatetime);
}



