<?php
require_once "../../includes/initialize.php"; ?>

<?php
$log_file = SITE_ROOT . DS . "logs" . DS . "log_file.txt";
if (isset($_GET['clear'])) {
    if ($_GET['clear'] == 'true') {
        file_put_contents($log_file, '');
        log_action('Logs cleared', "by user ID {$session->user_id} ");
        redirect_to('logfile.php');
    }
}
?>
<?php include_layout_template("admin_header.php") ?>
    <a href="index.php">&laquo; Back</a>
    <br>
    <br>
    <h2>Log File</h2>
    <a href="logfile.php?clear=true">Clear log file</a>

<?php
if (file_exists($log_file) && (is_readable($log_file)) && $handle = fopen($log_file, 'r')) {
    echo "<ul class=\"log-entries\">";
    while (!feof($handle)) {
        $entry = fgets($handle);
        if (trim($entry) != "") {
            echo "<li>{$entry}</li>";
        }
    }
    echo "</ul>";
    fclose($handle);
} else {
    echo "Could not read from {$log_file}.";
}
?>

<?php include_layout_template("admin_footer.php") ?>