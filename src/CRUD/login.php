<!DOCTYPE html>
<html>
<head>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

    <title>Login Page</title>
</head>
<body>

<style>
    *{margin: 0;padding: 0}
    body{
        background-image: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);;
        background-size: cover;
        background-position: center;
        height: 100vh ;
        padding-top: 150px;
    }
    #user{
        font-size: xx-large;
    }

    .form-container{
        width: 420px;
        height: auto;
        padding: 30px 100px;
        background-color: white ;
        border-radius: 10px;
        box-shadow: 0 0 10px #000;
        margin: auto;
    }

    p{
        padding-top: 10px;
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
        width: 150px;
        height: 30px;
        color: black;
    }
    p{
        color: red;
    }

    .form-control{
        width: 200px;
    }
</style>

<form class="Login" method="post">
    <?php
    include 'database.php';
    $username ="";
    $password="";
    $hashPassword="";
    $usernameErr="";
    $passwordErr="";
    if(isset($_POST["Login"])) {
        $username = $_POST["UserName"];
        $password = $_POST["Password"];

        if (!(empty($_POST["UserName"])&&empty($_POST["Password"]))){
            $data = "SELECT * FROM users WHERE userID = ? LIMIT 0,1";
            $stmt = $dbh->prepare($data);
            $stmt->bindParam(1,$username);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //extract($row);
            $numRows = $stmt->rowCount();
            if ($numRows==0){
                $usernameErr="User not found";
            }elseif (empty($username)&&!(empty($password))){
                $usernameErr="Please enter a username.";
            }elseif (empty($password)&&!(empty($username))){
                $passwordErr="Please enter a password";
            }else{
                $userPassword = $row['password'];
                if (password_verify($password,$userPassword)){
                    session_start();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;
                    if($row['role']==admin){
                        $_SESSION['admin']=1;
                    }else{
                        $_SESSION['admin']=0;
                    }
                    header("location: Detail.php");
                }else{
                    $passwordErr="Incorrect Password";
                }
            }
        }


    }
    ?>

    <div class="form-container">
        <ul class="list">
            <li id="user">User Login</li>
            <li><input class="form-control"type="text" name="UserName" placeholder="User Name" id="UserName" ><span class="error"> <?php echo"<p>$usernameErr</p>"; echo "<script>document.getElementById(\"UserName\").focus();</script>";?></span></li>
            <li><input class="form-control"type="password" name="Password" placeholder="Password" ><span class="error"><?php echo"<p> $passwordErr</p>";?></span></li>
            <li><input class="btn btn-success" type="submit" name="Login" value="Login"></li>
        </ul>
    </div>
</form>
</body>


</html>