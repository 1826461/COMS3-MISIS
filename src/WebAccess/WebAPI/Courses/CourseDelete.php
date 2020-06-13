<?php

use Helpers\CourseDatabaseHelper;
use Helpers\EnrollmentDatabaseHelper;

include("..\..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\..\Helpers\EnrollmentDatabaseHelper.php");
include("..\..\..\Helpers\DatabaseHelper.php");
include("..\..\..\Objects\Course.php");

session_start();
$unitCode = isset($_GET['unitCode']) ? $_GET['unitCode'] : die('Error: Unit code not found.');
$courseDatabaseHelper = new CourseDatabaseHelper();
$enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();

if ($_SESSION['admin'] == 1) {
    $courseDatabaseHelper->deleteCourse($unitCode);
    $enrollmentDatabaseHelper->deleteAllCourseEnrollments($unitCode);
    header('Location: ../../Courses/CourseMasterView.php?action=deleted');

} else {
    header('Location: ../../Courses/CourseMasterView.php?action=deny');
}



