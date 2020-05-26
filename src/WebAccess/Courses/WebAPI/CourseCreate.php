<?php

use Helpers\CourseDatabaseHelper;
use Objects\Course;

include("..\..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\..\Helpers\DatabaseHelper.php");
include("..\..\..\Objects\Course.php");

session_start();

$courseId = 0;
$courseName = isset($_GET['courseName']) ? $_GET['courseName'] : die('Error: Name not found.');
$unitCode = isset($_GET['unitCode']) ? $_GET['unitCode'] : die('Error: Unit code not found.');
$course = new Course($courseId, $courseName, $unitCode);
$courseDatabaseHelper = new CourseDatabaseHelper();

if ($_SESSION['admin'] == 1) {
    $courseDatabaseHelper->insertCourse($course);
    header('Location: ../CourseMasterView.php?action=created');

} else {
    header('Location: ../CourseMasterView.php?action=deny');
}

