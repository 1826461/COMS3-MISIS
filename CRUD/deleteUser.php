<?php
include 'database.php';

try{
    $studentNo =isset($_GET['studentNo']) ? $_GET['studentNo']: die('Error: User not found.');
    $query='DELETE FROM users WHERE studentNo=? ';
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(1,$student_no);

    if($stmt->execute()){
        header('Location: Detail.php?action=deleted');
    }else{
        die('Unable to delete record.');
    }

}catch (PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}



