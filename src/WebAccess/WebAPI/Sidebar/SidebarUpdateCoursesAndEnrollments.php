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

//CAN USE THIS TO CONVERT A STRING TO A NUMBER IN PHP IF NEEDED
//$courseIDStr = $courseIDStr + 0;

//$courseIDStr = 5;

//TESTED WORKING FOR MULTIPLE COURSES WITH HARDCODED COURSEID. ISSUES COME IN WITH THE MESSY CODE XD

$courseList = json_decode($courseSame);

if ($_SESSION['admin'] == 1) {
    $courseDatabaseHelper = new CourseDatabaseHelper();
    $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
    $JSONHelper = new JSONHelper();

    for ($index = 0; $index < sizeof($courseList); $index++) {
        $courseDatabaseHelper->deleteCourse($courseList[$index]);
        $enrollmentDatabaseHelper->deleteAllCourseEnrollments($courseList[$index]);
        $course = new Course($courseList[$index], $courseIDStr);
        $courseDatabaseHelper->insertCourse($course);
        $JSONHelper->addCourseData($courseList[$index]);
        $enrollmentDatabaseHelper->updateEnrollmentWhenCourseChange($courseList[$index], $courseIDStr);
    }

} else {
    header('Location: ../../Courses/CourseMasterView.php?action=deny');
}
