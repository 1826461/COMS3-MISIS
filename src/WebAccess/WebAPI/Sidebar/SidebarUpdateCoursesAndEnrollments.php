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

$unitCodesAddedTo = array();
$unitCodesDeletedFrom = array();

if ($_SESSION['admin'] == 1) {
    $courseDatabaseHelper = new CourseDatabaseHelper();
    $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
    $logEntryDatabaseHelper = new LogEntryDatabaseHelper();
    $JSONHelper = new JSONHelper();

    for ($index = 0; $index < sizeof($courseAdd);$index++) {
        $enrollment = new Enrollment($courseAdd[$index]['id'],$courseAdd[$index]['studentNo'],$courseAdd[$index]['name'], $courseAdd[$index]['surname'], $courseAdd[$index]['subject'], $courseAdd[$index]['unitCode'], $courseAdd[$index]['session'], $courseAdd[$index]['classSection'], $courseAdd[$index]['expiryDate'], $courseAdd[$index]['status']);
        $enrollmentDatabaseHelper->insertEnrollmentWithCourseID($enrollment,$courseAdd[$index]['courseId']);
        $flag = False;
        for($index2 = 0; $index2 < sizeof($unitCodesAddedTo);$index2++){
            if($unitCodesAddedTo[$index2] == $courseAdd[$index]['unitCode']){
                $flag = True;
                break;
            }
        }
        if($flag == False) {
            array_push($unitCodesAddedTo, $courseAdd[$index]['unitCode']);
        }
    }

    if (sizeof($unitCodesAddedTo) != 0) {
        for($index = 0; $index < sizeof($unitCodesAddedTo);$index++){
            $count = 0;
            for ($index2 = 0; $index2 < sizeof($courseAdd);$index2++) {
                if($courseAdd[$index2]['unitCode'] == $unitCodesAddedTo[$index]) {
                    $count = $count + 1;
                }
            }
            $logEntry = new LogEntry($_SESSION['username'], $count . " enrollments added to " . $unitCodesAddedTo[$index]);
            $logEntryDatabaseHelper->insertLogEntry($logEntry);
        }
    }

    for ($index = 0; $index < sizeof($courseDel); $index++) {
        $enrollmentDatabaseHelper->deleteEnrollment($courseDel[$index]['studentNo'], $courseDel[$index]['unitCode']);
        $flag = False;
        for($index2 = 0; $index2 < sizeof($unitCodesDeletedFrom);$index2++){
            if($unitCodesDeletedFrom[$index2] == $courseDel[$index]['unitCode']){
                $flag = True;
                break;
            }
        }
        if($flag == False) {
            array_push($unitCodesDeletedFrom, $courseDel[$index]['unitCode']);
        }
    }

    if (sizeof($unitCodesDeletedFrom) != 0) {
        for($index = 0; $index < sizeof($unitCodesDeletedFrom);$index++){
            $count = 0;
            for ($index2 = 0; $index2 < sizeof($courseDel);$index2++) {
                if($courseDel[$index2]['unitCode'] == $unitCodesDeletedFrom[$index]) {
                    $count = $count + 1;
                }
            }
            $logEntry = new LogEntry($_SESSION['username'], $count . " enrollments deleted from " . $unitCodesDeletedFrom[$index]);
            $logEntryDatabaseHelper->insertLogEntry($logEntry);
        }
    }

    $enrollmentDatabaseHelper->deleteAllTempEnrollments();

} else {
    header('Location: ../../Courses/CourseMasterView.php?action=deny');
}
