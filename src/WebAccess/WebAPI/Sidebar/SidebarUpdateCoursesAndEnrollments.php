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

$courseList = json_decode($courseSame);

if ($_SESSION['admin'] == 1) {
    $courseDatabaseHelper = new CourseDatabaseHelper();
    $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
    $JSONHelper = new JSONHelper();

    $courseDatabaseHelper->deleteCourseWithID($courseIDStr);
    $enrollmentDatabaseHelper->deleteAllCourseEnrollmentsWithID($courseIDStr);

    for ($index = 0; $index < sizeof($courseList); $index++) {
        $course = new Course($courseList[$index], $courseIDStr);
        $courseDatabaseHelper->insertCourse($course);
        $JSONHelper->addCourseData($courseList[$index]);
        $enrollmentDatabaseHelper->updateEnrollmentWhenCourseChange($courseList[$index], $courseIDStr);
    }

} else {
    header('Location: ../../Courses/CourseMasterView.php?action=deny');
}
