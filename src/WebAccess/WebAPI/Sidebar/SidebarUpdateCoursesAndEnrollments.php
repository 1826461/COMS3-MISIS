<?php

use Helpers\CourseDatabaseHelper;
use Helpers\EnrollmentDatabaseHelper;
use Helpers\LogEntryDatabaseHelper;
use Helpers\JSONHelper;
use Objects\Course;
use Objects\LogEntry;
use Objects\Enrollment;

include("..\..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\..\Helpers\EnrollmentDatabaseHelper.php");
include("..\..\..\Helpers\LogEntryDatabaseHelper.php");
include("..\..\..\Helpers\DatabaseHelper.php");
include("..\..\..\Helpers\JSONHelper.php");
include("..\..\..\Objects\Enrollment.php");
include("..\..\..\Objects\Course.php");
include("..\..\..\Objects\LogEntry.php");

session_start();

$courseAdditions = $_POST['courseAdditions'];
$courseDeletions = $_POST['courseDeletions'];

$courseAdd = json_decode($courseAdditions,true);
$courseDel = json_decode($courseDeletions,true);

if ($_SESSION['admin'] == 1) {
    $courseDatabaseHelper = new CourseDatabaseHelper();
    $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
    $logEntryDatabaseHelper = new LogEntryDatabaseHelper();
    $JSONHelper = new JSONHelper();

    for ($index = 0; $index < sizeof($courseAdd);$index++) {
        $enrollment = new Enrollment($courseAdd[$index]['id'],$courseAdd[$index]['studentNo'],$courseAdd[$index]['name'], $courseAdd[$index]['surname'], $courseAdd[$index]['subject'], $courseAdd[$index]['unitCode'], $courseAdd[$index]['session'], $courseAdd[$index]['classSection'], $courseAdd[$index]['expiryDate'], $courseAdd[$index]['status']);
        $enrollmentDatabaseHelper->insertEnrollmentWithCourseID($enrollment,$courseAdd[$index]['courseId']);
    }
    if (sizeof($courseAdd) != 0) {
        $logEntry = new LogEntry($_SESSION['username'], sizeof($courseAdd) . " enrollments added to " . $courseAdd[0]['unitCode']);
        $logEntryDatabaseHelper->insertLogEntry($logEntry);
    }

    for ($index = 0; $index < sizeof($courseDel); $index++) {
        $enrollmentDatabaseHelper->deleteEnrollment($courseDel[$index]['studentNo'], $courseDel[$index]['unitCode']);
    }
    if (sizeof($courseDel) != 0) {
        $logEntry = new LogEntry($_SESSION['username'], sizeof($courseDel) . " enrollments deleted from " . $courseDel[0]['unitCode']);
        $logEntryDatabaseHelper->insertLogEntry($logEntry);
    }
    $enrollmentDatabaseHelper->deleteAllTempEnrollments();

} else {
    header('Location: ../../Courses/CourseMasterView.php?action=deny');
}
