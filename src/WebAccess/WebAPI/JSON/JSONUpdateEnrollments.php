<?php

use Helpers\JSONHelper;

include("..\..\..\Helpers\JSONHelper.php");
include("..\..\..\Helpers\EnrollmentDatabaseHelper.php");
include("..\..\..\Helpers\DatabaseHelper.php");
include("..\..\..\Objects\Enrollment.php");

session_start();

$unitCode = isset($_GET['unitCode']) ? $_GET['unitCode'] : die('Error: Unit code not found.');
$jsonHelper = new JSONHelper();


if ($_SESSION['admin'] == 1) {
    $success = $jsonHelper->updateCourseData($unitCode);
    if ($success) {
        header('Location: ../../Enrollments/EnrollmentMasterView.php?action=created');
    } else {
        header('Location: ../../Enrollments/EnrollmentMasterView.php?action=deny');
    }


} else {
    header('Location: ../../Enrollments/EnrollmentMasterView.php?action=deny');
}