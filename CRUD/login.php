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
    /////functions
    function getSalt(){
//        global  $random_salt_length;
        return bin2hex(openssl_random_pseudo_bytes(20));
    }

    function concatPasswordSalt($password,$salt){
        global  $random_salt_length;
        if($random_salt_length%2==0){
            $mid = $random_salt_length/2;
        }else{
            $mid = ($random_salt_length-1)/2;
        }
        return substr($salt,0,$mid-1).$password.substr($salt,$mid,$random_salt_length-1);
    }
    ///
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
            $hashPassword = concatPasswordSalt($password,getSalt());
           //echo "<h1>'$hashPassword'</h1>";
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
                    if ($userPassword==$password){
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