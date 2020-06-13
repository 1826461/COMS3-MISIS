<?php
include "SharedViews/LoginHeader.php";

use Helpers\UserDatabaseHelper;

include("..\Helpers\UserDatabaseHelper.php");
include("..\Helpers\DatabaseHelper.php");
include("..\Objects\User.php");

//TODO REMOVE console_log function and uses
function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (!(empty($_POST["username"]) && empty($_POST["password"]))) {
        $userDatabaseHelper = new UserDatabaseHelper();
        $result = $userDatabaseHelper->getUser($username);
        if ($result === 0) {
            echo '<p class="message message.alert login-page" style="text-align: center">' . "incorrect username or password" . '</p>';
        } else if (password_verify($password, $result->getPassword())) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            if ($result->getRole() === "admin") {
                $_SESSION['admin'] = 1;
            } else {
                $_SESSION['admin'] = 0;
            }
            //TODO implement go to list view
            header("location: Enrollments\EnrollmentMasterView.php");
            echo '<p class="message message.alert login-page" style="text-align: center">' . "THIS WILL LOG IN " . '</p>';
        } else {
            echo '<p class="message message.alert login-page" style="text-align: center">' . "incorrect username or password" . '</p>';
        }

    }
}
?>
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div class="brand">
                    </div>
                    <br><br>
                    <div class="text-center">
                        <h1 class="card-title" style="color:#000000"><?php echo "COMS3-MISIS" ?></h1>
                    </div>
                    <div class="card fat">
                        <div class="card-body">
                            <form class="form-signin" action="" method="post" autocomplete="off">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required
                                           autofocus>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>

                                <div class="form-group">
                                    <button type="submit" name="login" class="btn btn-primary btn-block" role="button">
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include "SharedViews/LoginFooter.php"; ?>