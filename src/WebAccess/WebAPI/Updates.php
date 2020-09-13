<?php

include("..\..\Helpers\DatabaseHelper.php");
include("..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\Helpers\EnrollmentDatabaseHelper.php");
include("..\..\Objects\Enrollment.php");
include("..\..\Helpers\JSONHelper.php");
include("..\..\Objects\Course.php");

use Helpers\EnrollmentDatabaseHelper;
use Helpers\CourseDatabaseHelper;
use Objects\Enrollment;
use Objects\Course;
use Helpers\JSONHelper;

/*Triggers update on unitCode*/
function triggerSync($unitCode){
    $JSONHelper = new JSONHelper();
    $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
    $courseHelper = new CourseDatabaseHelper();
    $course = $courseHelper->getCourse($unitCode);

    //Delete old enrollments from specific course
    $enrollDel = $enrollmentDatabaseHelper->getAllEnrollments();
    for ($index = 0; $index < sizeof($enrollDel); $index++) {
        if ($enrollDel[$index]['unitCode']===$unitCode){
            $enrollmentDatabaseHelper->deleteEnrollment($enrollDel[$index]['studentNo'], $enrollDel[$index]['unitCode']);
        }
    }

    //Get current virtus enrollments
    $enrollAdd = $JSONHelper->getVirtusCourseJSON($unitCode);
    for ($index = 0; $index < sizeof($enrollAdd);$index++) {
        //need to get an ID for insert
        $insertID = 0;
        $enrollment = new Enrollment($insertID,$enrollAdd[$index]['studentNumber'],$enrollAdd[$index]['firstName'], $enrollAdd[$index]['surname'], $enrollAdd[$index]['subject'], $enrollAdd[$index]['unitCode'], $enrollAdd[$index]['sessionCode'], $enrollAdd[$index]['classSection'], $enrollAdd[$index]['expiryDate'], $enrollAdd[$index]['unitStatus']);
        $courseID = $course->getCourseID();
        $enrollmentDatabaseHelper->insertEnrollmentWithCourseID($enrollment,$courseID);
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
    $currDate = date("Y:m:d H:i:s");

    $currDate = date_create($currDate);
    $oldDate = date_create($oldDate);
    $interval = date_diff($currDate,$oldDate);

    /*Checking if sync is required*/
    if ($syncFreq==0){
        /*Default trigger means do no update*/
    }else if($syncFreq==1){
        /*Trigger Update Hourly*/
        if ($interval->format('%h')>1){
            triggerSync($courseName);
        }
    }else if($syncFreq==2){
        /*Trigger Update Daily*/
        if ($interval->format('%a')>7){
            triggerSync($courseName);
        }
    }else if($syncFreq==3){
        /*Trigger Update Monthly*/
        if ($interval->format('%m')>=1){
            triggerSync($courseName);
        }
    }else if($syncFreq==4){
        /*Trigger Update Yearly*/
        if ($interval->format('%a')>365){
            triggerSync($courseName);
        }
    }
}
