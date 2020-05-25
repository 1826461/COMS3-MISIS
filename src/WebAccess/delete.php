<?php

use Helpers\EnrollmentDatabaseHelper;
include ("..\Helpers\EnrollmentDatabaseHelper.php");
include ("..\Helpers\DatabaseHelper.php");
include ("..\Objects\Enrollment.php");
session_start();
$studentNo =isset($_GET['studentNo']) ? $_GET['studentNo']: die('Error: User not found.');
$unitCode = isset($_GET['unitCode']) ? $_GET['unitCode']: die('Error: Unit code not found.');
$enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();

if ($_SESSION['admin']==1){
        $enrollmentDatabaseHelper->deleteEnrollment($studentNo, $unitCode);
        header('Location: Detail.php?action=deleted');

}else{
        header('Location: Detail.php?action=deny');
}



