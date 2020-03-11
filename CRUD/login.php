<?php
//start session
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>

<body>
<form class="Login" method="post">
    <?php
     include 'database.php';
    $username ="";
    $password="";
    $hashPassword="";
    $usernameErr="";
    $passwordErr="";
    if(isset($_POST["Login"])) {
        //check empty username
        if(empty($_POST["UserName"])){
            $usernameErr = "Username is required.";
        }else{
            $username = $_POST["UserName"];
        }
        //check blank password
        if(empty($_POST["Password"])){
            $passwordErr = "Password is required.";
        }else{
            $password = $_POST["Password"];
        }
        if (!(empty($_POST["UserName"])&&empty($_POST["Password"]))){
            try {
                $data = "SELECT * FROM userroles WHERE userID = ? LIMIT 0,1";
                $stmt = $dbh->prepare($data);
                $stmt->bindParam(1,$username);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                // extract($row);
                $numRows = $stmt->rowCount();
                if ($numRows==0){
                    $usernameErr="User not found";
                }else{
                    $userPassword = $row['password'];
                    if (password_verify($password,$userPassword)){
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $username;
                        header("location: Detail.php");
                    }else{
                    $passwordErr="Incorrect Password";
                    }
                }
            }catch (PDOException $exception){
                die('Error: ' .$exception->getMessage());
            }
        }


    }
    ?>
    <div class="form-container">
        <ul class="list">
            <li>User Login</li>
            <li><input type="text" name="UserName" placeholder="User Name" ><span class="error">* <?php echo"<p>$usernameErr</p>";?></span></li>
            <li><input type="password" name="Password" placeholder="Password" ><span class="error">* <?php echo"<p> $passwordErr</p>";?></span></li>
            <li><input type="submit" name="Login" value="Login"></li>
        </ul>
    </div>
</form>
</body>


<style>
    *{margin: 0;padding: 0}
    body{
        background-image: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),url(back.jpeg);
        background-size: cover;
        background-position: center;
        height: 100vh ;
        padding-top: 150px;
    }

    .form-container{
        width: 250px;
        height: auto;
        padding: 30px 100px;
        background-color: beige ;
        border-radius: 10px;
        box-shadow: 0 0 10px #000;
        margin: auto;
    }

    p{
        padding-top: 2px;
    }

    ul.list{
        list-style: none;
        text-align: center;
    }
    ul.list li{
        width: 250px;
        padding: 10px;

    }
    ul.list li input[type="submit"]{
        background-color: #4690fb;
        width: 100px;
        color: #fff;
    }
</style>
</html>