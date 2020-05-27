<?php

use Helpers\CourseDatabaseHelper;
use Objects\Course;
use Helpers\JSONHelper;

include("..\..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\..\Helpers\DatabaseHelper.php");
include("..\..\..\Helpers\JSONHelper.php");
include("..\..\..\Objects\Course.php");

session_start();

$courseID = isset($_GET['courseID']) ? $_GET['courseID'] : die('Error: ID not found.');
$courseName = isset($_GET['courseName']) ? $_GET['courseName'] : die('Error: Name not found.');
$unitCode = isset($_GET['unitCode']) ? $_GET['unitCode'] : die('Error: Unit code not found.');

if ($_SESSION['admin'] == 1) {
    $course = new Course($unitCode, $courseID);
    $course->setCourseName($courseName);
    $courseDatabaseHelper = new CourseDatabaseHelper();
    $courseDatabaseHelper->updateCourse($course);
    header('Location: ../../Courses/CourseMasterView.php?action=edited');
} else {
    header('Location: ../../Courses/CourseMasterView.php?action=deny');
}