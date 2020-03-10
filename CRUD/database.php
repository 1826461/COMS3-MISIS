<?php
$host="localhost";
$port=3306;
$socket="";
$user="Test";
$password="testing1234";
$dbname="coms3project";

try {
    $dbh = new PDO("mysql:host={$host};port={$port};dbname={$dbname}", $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

