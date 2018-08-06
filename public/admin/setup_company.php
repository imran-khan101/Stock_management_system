<?php
require_once "../../includes/initialize.php";

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}
$message = "Please enter a Company name";
if (isset($_POST['submit'])) {
    if (!empty($_POST['name'])) {
        $company = new Company();
        $company->name = $_POST['name'];
        if ($company->save()) {
            $message = "Successfully saved the Company";
        } else {
            $message = "Couldn't Saved the Company";
        }
    }
}

$companies = Company::find_all();
$sl = 1;
?>
<?php include_layout_template("admin_header.php") ?>
<h2>Setup Company</h2>
<?php if (isset($session->message)) {
    echo output_message($session->message);
} ?>
<?php echo output_message($message); ?>
<form action="setup_company.php" method="post">
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label ">Name:</label>
        <div class="col-sm-6">
            <input type="text" name="name" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <input type="submit" value="Save" name="submit" class="btn btn-success">
        </div>
    </div>
</form>
<h3>Company List</h3>
<table class="table table-striped table-bordered table-hover">
    <tr>
        <th>Sl</th>
        <th>Name</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </tr>
    <?php foreach ($companies as $company): ?>
        <tr>
            <td><?php echo $sl;
                $sl++ ?></td>
            <td><?php echo $company->name; ?></td>
            <td><a href="edit_company.php?id=<?php echo $company->id; ?>">edit</a></td>
            <td><a href="delete_company.php?id=<?php echo $company->id; ?>">delete</a></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php include_layout_template("admin_footer.php") ?>
