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
    <div class="form-container">
        <ul class="list">
            <li>User Login</li>
            <li><input type="text" name="UserName" placeholder="User Name" ></li>
            <li><input type="password" name="Password" placeholder="Password" ></li>
            <li><input type="submit" name="Login" value="Login"></li>
        </ul>
    </div>
    <?php
     include 'database.php';
    $username ="";
    $password="";
    $hashPassword="";
    if(isset($_POST["Login"])) {
        //check empty username
        if(empty($_POST["UserName"])){

        }else{
            $username = $_POST["UserName"];
        }
        //check blank password
        if(empty($_POST["Password"])){

        }else{
            $password = $_POST["Password"];
            //echo "<p>$hashPassword</p>";
           //query DB
            try {
                $data = "SELECT * FROM userroles WHERE userID = ? LIMIT 0,1";
                $stmt = $dbh->prepare($data);
                $stmt->bindParam(1,$username);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                // extract($row);
                $numRows = $stmt->rowCount();
                if ($numRows==0){

                }else{
                    $userPassword = $row['password'];
                    echo "<p>$hashPassword</p>";
                    echo "<p>$userPassword</p>";
                    if (password_verify($password,$userPassword)){
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $username;
                        header("location: Detail.php");
                    }else{

                    }
                }
            }catch (PDOException $exception){
                die('Error: ' .$exception->getMessage());
            }
        }


    }
    ?>
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
        padding: 20px 30px;
        background-color: white ;
        border-radius: 10px;
        box-shadow: 0 0 10px #000;
        margin: auto;
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