<?php
include 'database.php';
session_start();

try{
    $studentNo =isset($_GET['studentNo']) ? $_GET['studentNo']: die('Error: User not found.');
    $subject =isset($_GET['subject']) ? $_GET['subject']: die('Error: Subject not found.');
    $query='DELETE FROM enrollments WHERE studentNo = :num AND subject= :sub';
    $stmt = $dbh->prepare($query);
    $stmt->bindValue(":num", $studentNo);
    $stmt->bindParam(":sub",$subject);

    if ($_SESSION['admin']==1){
        if($stmt->execute()){
            header('Location: EnrollmentMasterView.php?action=deleted');
        }else{
            die('Unable to delete record.');
        }
    }else{
        header('Location: EnrollmentMasterView.php?action=deny');
    }

}catch (PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}


