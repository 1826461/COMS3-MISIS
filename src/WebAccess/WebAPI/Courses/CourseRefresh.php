<?php

use Helpers\CourseDatabaseHelper;
use Helpers\EnrollmentDatabaseHelper;
use Helpers\JSONHelper;

include("..\..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\..\Helpers\EnrollmentDatabaseHelper.php");
include("..\..\..\Helpers\DatabaseHelper.php");
include("..\..\..\Helpers\JSONHelper.php");
include("..\..\..\Objects\Course.php");
include("..\..\..\Objects\Enrollment.php");

session_start();

$unitCode = isset($_GET['unitCode']) ? $_GET['unitCode'] : die('Error: Unit code not found.');

$JSONHelper = new JSONHelper();
$work = $JSONHelper->updateCourseData($unitCode);
$courseDatabaseHelper = new CourseDatabaseHelper();
$course = $courseDatabaseHelper->getCourse($unitCode);
$enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
$enrollmentDatabaseHelper->updateEnrollmentWhenCourseChange($course->getUnitCode(), $course->getCourseID());
if ($work === true) {
    header('Location: ../../Courses/CourseMasterView.php?action=updated');
} else {
    header('Location: ../../Courses/CourseMasterView.php?action=invalid');
}

