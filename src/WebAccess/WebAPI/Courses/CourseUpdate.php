<?php

use Helpers\CourseDatabaseHelper;
use Objects\Course;
use Helpers\JSONHelper;

include("..\..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\..\Helpers\DatabaseHelper.php");
include("..\..\..\Helpers\JSONHelper.php");
include("..\..\..\Objects\Course.php");

session_start();

$courseId = isset($_GET['courseId']) ? $_GET['courseId'] : die('Error: ID not found.');
$courseName = isset($_GET['courseName']) ? $_GET['courseName'] : die('Error: Name not found.');
$unitCode = isset($_GET['unitCode']) ? $_GET['unitCode'] : die('Error: Unit code not found.');

$course = new Course($courseId, $courseName, $unitCode);

$courseDatabaseHelper = new CourseDatabaseHelper();
$courseDatabaseHelper->updateCourse($course);

    if ($_SESSION['admin'] == 1) {
        $JSONHelper = new JSONHelper();
        $JSONHelper->updateCourseData($unitCode);
        header('Location: ..\CourseMasterView.php?action=edited');
    } else {
        header('Location: ..\CourseMasterView.php?action=deny');
    }

