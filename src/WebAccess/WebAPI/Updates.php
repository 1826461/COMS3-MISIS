<?php

include("..\..\Helpers\DatabaseHelper.php");
include("..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\Helpers\EnrollmentDatabaseHelper.php");
include("..\..\Helpers\LogEntryDatabaseHelper.php");
include("..\..\Objects\Enrollment.php");
include("..\..\Helpers\JSONHelper.php");
include("..\..\Objects\Course.php");
include("..\..\Objects\LogEntry.php");

use Helpers\EnrollmentDatabaseHelper;
use Helpers\CourseDatabaseHelper;
use Helpers\LogEntryDatabaseHelper;
use Objects\Enrollment;
use Objects\Course;
use Objects\LogEntry;
use Helpers\JSONHelper;

/*Triggers update on unitCode*/
function triggerSync($unitCode, $delActive){
    $JSONHelper = new JSONHelper();
    $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
    $logEntryDatabaseHelper = new LogEntryDatabaseHelper();
    $courseHelper = new CourseDatabaseHelper();
    $course = $courseHelper->getCourse($unitCode);

    $courseAdditionCount = 0;
    $courseDeletionCount = 0;


    //Only do new user additions
        //Get current virtus enrollments
        $enrollAdd = $JSONHelper->getVirtusCourseJSON($unitCode);
        for ($index = 0; $index < sizeof($enrollAdd);$index++) {
            //need to get an ID for insert
            $insertID = 0;
            $enrollment = new Enrollment($insertID,$enrollAdd[$index]['studentNumber'],$enrollAdd[$index]['firstName'], $enrollAdd[$index]['surname'], $enrollAdd[$index]['subject'], $enrollAdd[$index]['unitCode'], $enrollAdd[$index]['sessionCode'], $enrollAdd[$index]['classSection'], $enrollAdd[$index]['expiryDate'], $enrollAdd[$index]['unitStatus']);
            $courseID = $course->getCourseID();
            $curr = $enrollmentDatabaseHelper->getEnrollment($enrollAdd[$index]['studentNumber'], $enrollAdd[$index]['unitCode']);
            if ($curr == 0){
                $enrollmentDatabaseHelper->insertUniqueEnrollmentWithCourseID($enrollment,$courseID);
                $courseAdditionCount = $courseAdditionCount + 1;
            }
        }
        $logEntry = new LogEntry("CRON", $courseAdditionCount . " enrollments added to " . $course->getCourseName());
        $logEntryDatabaseHelper->insertLogEntry($logEntry);
    if ($delActive==1){//Delete old users and insert new users

        for ($index = 0; $index < sizeof($enrollAdd); $index++) {
            $enrollment = new Enrollment(0,$enrollAdd[$index]['studentNumber'],$enrollAdd[$index]['firstName'], $enrollAdd[$index]['surname'], $enrollAdd[$index]['subject'], $enrollAdd[$index]['unitCode'], $enrollAdd[$index]['sessionCode'], $enrollAdd[$index]['classSection'], $enrollAdd[$index]['expiryDate'], $enrollAdd[$index]['unitStatus']);
            $enrollmentDatabaseHelper->insertTempEnrollment($enrollment);
        }

        //Delete old enrollments from specific course
        $enrollDel = $enrollmentDatabaseHelper->getAllEnrollmentsWhereNotInTemp();

        if ($enrollDel != 0) {
            for ($index = 0; $index < sizeof($enrollDel); $index++) {
                if ($enrollDel[$index]['unitCode']===$unitCode){
                    $enrollmentDatabaseHelper->deleteEnrollment($enrollDel[$index]['studentNo'], $enrollDel[$index]['unitCode']);
                    $courseDeletionCount = $courseDeletionCount + 1;
                }
            }
        }
        $logEntry = new LogEntry("CRON", $courseDeletionCount . " enrollments deleted from " . $course->getCourseName());
        $logEntryDatabaseHelper->insertLogEntry($logEntry);
    }
    //once finished update last sync in Database
    $courseHelper->updateLastSync($course);

}

/*Helper setup*/
$courseHelper = new CourseDatabaseHelper();

/*Get all courses*/
$courses = $courseHelper->getAllCourses();

for($iter = 0; $iter<sizeof($courses);$iter++){
    /*Check each course update frequency */
    $courseName = $courses[$iter]['unitCode'];
    $oldDate =  $courses[$iter]['updatedOn'];
    $syncFreq = $courses[$iter]['syncFrequency'];
    $deleteActive = $courses[$iter]['deleteActive'];

    $currDate = date("Y:m:d H:i:s");

    $currDate = date_create($currDate);
    $oldDate = date_create($oldDate);
    $interval = date_diff($currDate,$oldDate);

    $diff = $currDate->diff($oldDate);
    $hours = $diff->h + ($diff->days * 24);

    /*Checking if sync is required*/
    if ($syncFreq==0){
        /*Default trigger means do no update*/
    }else if($syncFreq==1){
        /*Trigger Update Hourly*/
        if ($hours >= 1){
             triggerSync($courseName,$deleteActive);
        }
    }else if($syncFreq==2){
        /*Trigger Update Daily*/
        if ($hours >= 24){
            triggerSync($courseName,$deleteActive);
        }
    }else if($syncFreq==3){
        /*Trigger Update Weekly*/
        if ($hours >= 168){
            triggerSync($courseName,$deleteActive);
        }
    }
    else if($syncFreq==4){
        /*Trigger Update Month;y*/
        if ($hours >= 730){
            triggerSync($courseName,$deleteActive);
        }
    }
    else if($syncFreq==5){
        /*Trigger Update Yearly*/
        if ($hours >= 8760){
            triggerSync($courseName,$deleteActive);
        }
    }

}
