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
$oldUnitCode = isset($_GET['oldUnitCode']) ? $_GET['oldUnitCode'] : die('Error: Old unit code not found.');

$course = new Course($courseID, $courseName, $unitCode);

$courseDatabaseHelper = new CourseDatabaseHelper();
$courseDatabaseHelper->updateCourse($course);

if ($_SESSION['admin'] == 1) {
    $JSONHelper = new JSONHelper();
    $JSONHelper->editCourseData($unitCode,$oldUnitCode);
    header('Location: ../../Courses/CourseMasterView.php?action=edited');
} else {
    header('Location: ../../Courses/CourseMasterView.php?action=deny');
}