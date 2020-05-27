<?php

use Helpers\EnrollmentDatabaseHelper;
use Objects\Course;
use Helpers\JSONHelper;

include("..\..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\..\Helpers\DatabaseHelper.php");
include("..\..\..\Helpers\JSONHelper.php");
include("..\..\..\Objects\Course.php");

session_start();

$unitCode = isset($_GET['unitCode']) ? $_GET['unitCode'] : die('Error: Unit code not found.');

$JSONHelper = new JSONHelper();
$JSONHelper->updateCourseData($unitCode);
header('Location: ../../Courses/CourseMasterView.php?action=updated');

