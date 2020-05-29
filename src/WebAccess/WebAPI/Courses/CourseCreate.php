<?php

use Helpers\CourseDatabaseHelper;
use Helpers\EnrollmentDatabaseHelper;
use Objects\Course;
use Helpers\JSONHelper;

include("..\..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\..\Helpers\EnrollmentDatabaseHelper.php");
include("..\..\..\Helpers\DatabaseHelper.php");
include("..\..\..\Objects\Course.php");
include("..\..\..\Objects\Enrollment.php");
include("..\..\..\Helpers\JSONHelper.php");

session_start();

$courseID = isset($_GET['courseID']) ? $_GET['courseID'] : die('Error: Name not found.');
$courseName = isset($_GET['courseName']) ? $_GET['courseName'] : die('Error: Name not found.');
$unitCode = isset($_GET['unitCode']) ? $_GET['unitCode'] : die('Error: Unit code not found.');

if ($_SESSION['admin'] == 1) {
    $course = new Course($unitCode, $courseID);
    if ($courseName !="") {
        $course->setCourseName($courseName);
    }
    $courseDatabaseHelper = new CourseDatabaseHelper();
    $courseDatabaseHelper->insertCourse($course);
    $JSONHelper = new JSONHelper();
    $work = $JSONHelper->addCourseData($unitCode);
    $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
    $enrollmentDatabaseHelper->updateEnrollmentWhenCourseChange($course->getUnitCode(), $course->getCourseID());
    if($work === true){
        header('Location: ../../Courses/CourseMasterView.php?action=created');
    }
} else {
    header('Location: ../../Courses/CourseMasterView.php?action=deny');
}

