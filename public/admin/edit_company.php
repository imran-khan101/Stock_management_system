<?php
require_once "../../includes/initialize.php";

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
if (!isset($_GET['id']) && !isset($_POST['submit'])) {
    redirect_to('setup_company.php');
}
$id = "";
$name = "";
if (isset($_GET['id'])) {
    $message = "Please enter the new company name";
    $company = Company::find_by_id(trim($_GET['id']));
    $name = $company->name;
}
if (isset($_POST['submit'])) {
    if (!empty($_POST['name'])) {
        $company = new Company();
        $company->id = $_POST['id'];
        $company->name = $_POST['name'];
        if ($company->save()) {
            $session->message("Company Updated");
            redirect_to('setup_company.php');
        } else {
            $message = "Couldn't Saved the Company";
        }
    }
}
?>
<?php include_layout_template("admin_header.php") ?>
<h4><a href="setup_company.php">&laquo;Back</a></h4>
<h2>Edit Company</h2>
<?php echo output_message($message); ?>
<form action="edit_company.php" method="post">
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    Name: <input type="text" name="name" value="<?php echo $name ?>"> <br>

    <input type="submit" value="Save" name="submit">
</form>

<?php include_layout_template("admin_footer.php") ?>
