<?php

use Helpers\CourseDatabaseHelper;
use Helpers\EnrollmentDatabaseHelper;
use Helpers\JSONHelper;
use Objects\Course;

include("..\..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\..\Helpers\EnrollmentDatabaseHelper.php");
include("..\..\..\Helpers\DatabaseHelper.php");
include("..\..\..\Helpers\JSONHelper.php");
include("..\..\..\Objects\Enrollment.php");
include("..\..\..\Objects\Course.php");

session_start();

$courseIDStr = $_POST['courseID'];
$courseSame = $_POST['courseSame'];
$updateFrequency = $_POST['updateFrequency'];
$deleteActive = $_POST['deleteActive'];


$courseListJSON = json_decode($courseSame);
$courseList = [];

for ($index = 0; $index < sizeof($courseListJSON); $index++) {
    if (substr($courseListJSON[$index], -1) == "A") {
        array_push($courseList, rtrim($courseListJSON[$index], "A"));
        array_push($courseList, $courseListJSON[$index]);
    } else {
        array_push($courseList, $courseListJSON[$index] . "A");
        array_push($courseList, $courseListJSON[$index]);
    }
}

if ($_SESSION['admin'] == 1) {
    $courseDatabaseHelper = new CourseDatabaseHelper();
    $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
    $JSONHelper = new JSONHelper();

    for ($index = 0; $index < sizeof($courseList); $index++) {
        $course = new Course($courseList[$index], $courseIDStr);
        $course->setUpdateFrequency($updateFrequency);
        $course->setDeleteActive($deleteActive);
        if ($courseDatabaseHelper->getCourse($courseList[$index]) != 0) {
            $courseDatabaseHelper->updateCourse($course);
        } else {
            $courseDatabaseHelper->insertCourse($course);
        }
        //$JSONHelper->addCourseDataTemp($courseList[$index]);
        //$enrollmentDatabaseHelper->updateEnrollmentWhenCourseChangeTemp($courseList[$index], $courseIDStr);
    }

    $courses = $courseDatabaseHelper->getCourseList();
    for ($index = 0; $index < sizeof($courses); $index++) {
        $JSONHelper->addCourseDataTemp($courses[$index]['unitCode']);
        $enrollmentDatabaseHelper->updateEnrollmentWhenCourseChangeTemp($courses[$index]['unitCode'], $courseDatabaseHelper->getCourse($courses[$index]['unitCode'])->getCourseID());
    }


} else {
    header('Location: ../../Courses/CourseMasterView.php?action=deny');
}