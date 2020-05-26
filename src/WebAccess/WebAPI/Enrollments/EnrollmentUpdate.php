<?php

use Helpers\EnrollmentDatabaseHelper;
use Objects\Enrollment;
include("..\..\..\Helpers\EnrollmentDatabaseHelper.php");
include("..\..\..\Helpers\DatabaseHelper.php");
include("..\..\..\Objects\Enrollment.php");

session_start();

$id = isset($_GET['id']) ? $_GET['id'] : die('Error: ID not found.');
$studentNo = isset($_GET['studentNo']) ? $_GET['studentNo'] : die('Error: Username not found.');
$name = isset($_GET['name']) ? $_GET['name'] : die('Error: Name not found');
$surname = isset($_GET['surname']) ? $_GET['surname'] : die('Error: Surname not found.');
$subject = isset($_GET['subject']) ? $_GET['subject'] : die('Error: Subject not found.');
$unitCode = isset($_GET['unitCode']) ? $_GET['unitCode'] : die('Error: Unit code not found.');
$session = isset($_GET['session']) ? $_GET['session'] : die('Error: Session not found.');
$classSection = isset($_GET['classSection']) ? $_GET['classSection'] : die('Error: Class section not found.');
$expiryDate = isset($_GET['expiryDate']) ? $_GET['expiryDate'] : die('Error: Expiry date not found.');
$status = isset($_GET['status']) ? $_GET['status'] : die('Error: Status not found.');

$enrollment = new Enrollment($id, $studentNo, $name, $surname, $subject, $unitCode, $session, $classSection,
    $expiryDate, $status);

$enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
$enrollmentDatabaseHelper->updateEnrollment($enrollment);

    if ($_SESSION['admin'] == 1) {
        header('Location: ../../Enrollments/EnrollmentMasterView.php?action=edited');

    } else {
        header('Location: ../../Enrollments/EnrollmentMasterView.php?action=deny');
    }

