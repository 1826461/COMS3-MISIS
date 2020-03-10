<?php
$host = "localhost";
$db_name = "COMS3Project";
$username = "root";
$passwrd = "root";

try {
    $connection = new  PDO("mysql:host={$host};dbname={$db_name}",$username,$passwrd);
}catch (PDOException $exception){
    echo "Connection error: ".$exception->getMessage();
}
