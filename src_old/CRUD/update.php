<?php

session_start();
include 'database.php';

$studentNo = isset($_GET['studentNo']) ? $_GET['studentNo'] : die('Error: Username not found.');
$name = isset($_GET['name']) ? $_GET['name'] : die('Error: Name not found');
$surname = isset($_GET['surname']) ? $_GET['surname'] : die('Error: Surname not found.');
//$subject = isset($_GET['subject']) ? $_GET['subject'] : die('Error: Subject not found.');
$code = isset($_GET['code']) ? $_GET['code'] : die('Error: Unit code not found.');
//$session = isset($_GET['session']) ? $_GET['session'] : die('Error: Session not found.');
$slot = isset($_GET['slot']) ? $_GET['slot'] : die('Error: Slot not found.');
$time = isset($_GET['time']) ? $_GET['time'] : die('Error: Time not found.');
$enrolled = isset($_GET['enrolled']) ? $_GET['enrolled'] : die('Error: Enrolled not found.');
;

try {
    $query = "UPDATE enrollments SET name =:nam,surname=:surname, classSection = :sec,expiryDate=:tim,status=:en WHERE (studentNo=:num AND unitCode=:code)";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(":nam", $name);
    $stmt->bindParam(":surname", $surname);
    $stmt->bindParam(":sec", $slot);
    $stmt->bindParam(":tim", $time);
    $stmt->bindParam(":en", $enrolled);
    $stmt->bindParam(":num", $studentNo);
    $stmt->bindParam(":code", $code);

    if ($_SESSION['admin'] == 1) {
        if ($stmt->execute()) {
            header('Location: EnrollmentMasterView.php?action=edited');
        } else {
            die('Unable to edit record.');
        }
    } else {
        header('Location: EnrollmentMasterView.php?action=deny');
    }

} catch (PDOException $exception) {
    die('Error: ' . $exception->getMessage());
}