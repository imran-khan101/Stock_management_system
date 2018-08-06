<?php
require_once "../../includes/initialize.php";

if ($session->is_logged_in()) {
    redirect_to("index.php");
}

if (isset($_POST['submit'])) {
    $email_username = trim($_POST['email_username']);
    $password = trim($_POST['password']);
    $remember_me = trim($_POST['remember_me']);
    //check Database to see username/password exists
    $found_user = User::authenticate($email_username);

    if ($found_user) {
        if (password_verify($password, $found_user->password)) {
            $session->login($found_user);
            if ($remember_me == 1){

            }
            log_action("Login", "{$email} Logged in");
            redirect_to("index.php");
        } else {
            $message = "Username/password combination incorrect";
        }
    } else {
        //username/password combo was not found in the database
        $message = "Username/password combination incorrect";
    }

} else {
    $email = "";
    $password = "";
    $message = "";
}

?>

<?php include_layout_template("guest_header.php") ?>
<?php /*echo output_message($message); ?>
    <form action="login.php" method="post">
        <table>
            <tr>
                <td>Username:</td>
                <td><input type="text" name="username" maxlength="30"
                           value="<?php echo htmlentities($username); ?>">
                </td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" maxlength="30"
                           value="<?php echo htmlentities($password); ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Login">
                </td>
            </tr>
        </table>
    </form>
<?php include_layout_template("admin_footer.php") */ ?>
<div class="container">
    <div class="card card-login mx-auto mt-5">
        <?php echo output_message($message); ?>
        <div class="card-header">Login</div>
        <div class="card-body">
            <form action="login.php" method="post">
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="text" id="email" name="email_username" class="form-control"
                               placeholder="Email address"
                               required="required" autofocus="autofocus">
                        <label for="email">Email address / Username</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="password" id="password" name="password" class="form-control"
                               placeholder="Password" required="required">
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="1" name="remember_me">
                            Remember Password
                        </label>
                    </div>
                </div>
                <input type="submit" name="submit" value="Login">
            </form>
            <div class="text-center">
                <a class="d-block small mt-3" href="sign_up.php">Register an Account</a>
                <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
            </div>
        </div>
    </div>
</div>
