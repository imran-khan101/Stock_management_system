<?php
require_once "../../includes/initialize.php";

if ($session->is_logged_in()) {
    redirect_to("index.php");
}

if (isset($_POST['submit'])) {
    if ($_POST['password'] == $_POST['confirm_password']) {
        $user = new User();
        $user->first_name = trim($_POST['first_name']);
        $user->last_name = trim($_POST['last_name']);
        $user->password = trim($_POST['password']);
        $user->email = trim($_POST['email']);
        $user->username = trim($_POST['username']);

        //check Database to see username/password exists
        $found_user = User::user_already_exists($user->username, $user->email);
        if (!$found_user) {
            $user->password =password_hash($user->password, PASSWORD_DEFAULT);
            $user->save();
            $session->login($user);
            redirect_to("index.php");
        } else {
            //username/password combo was not found in the database
            $message = "Username/Email already exists";
        }
    } else {
        $message = "password didn't match";
    }

} else {
    $username = "";
    $password = "";
    $message = "";
}

?>

<?php include_layout_template("guest_header.php") ?>

<!--Error message -->
<?php if ($message != ""): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo output_message($message); ?>
    </div>
<?php endif; ?>
<!--    <form action="sign_up.php" method="post">
        <div class="form-group">
            <label for="title">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="form-group">
            <label for="title">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Enter the password again:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required">
        </div>
        <div class="form-group">
            <button name="submit" type="submit" class="btn btn-primary">Sign Up</button>
        </div>
    </form>
-->

<div class="card card-register mx-auto mt-5">
    <div class="card-header">Register an Account</div>
    <div class="card-body">
        <form action="sign_up.php" method="post">
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-label-group">
                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First name"
                                   required="required" autofocus="autofocus">
                            <label for="firstName">First name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-label-group">
                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last name"
                                   required="required">
                            <label for="lastName">Last name</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label-group">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Email address"
                           required="required">
                    <label for="inputEmail">Username</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label-group">
                    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address"
                           required="required">
                    <label for="inputEmail">Email address</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-label-group">
                            <input type="password" id="password" name="password" class="form-control"
                                   placeholder="Password"
                                   required="required">
                            <label for="inputPassword">Password</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-label-group">
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control"
                                   placeholder="Confirm password" required="required">
                            <label for="confirmPassword">Confirm password</label>
                        </div>
                    </div>
                </div>
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Register</button>
        </form>
        <div class="text-center">
            <a class="d-block small mt-3" href="login.php">Login Page</a>
            <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
        </div>
    </div>
</div>