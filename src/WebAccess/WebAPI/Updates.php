<?php

include("..\..\Helpers\DatabaseHelper.php");
include("..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\Helpers\JSONHelper.php");

use Helpers\CourseDatabaseHelper;
use Helpers\JSONHelper;

/*Triggers update on unitCode*/
function triggerSync($unitCode){

}

/*Helper setup*/
$courseHelper = new CourseDatabaseHelper();
$JSONHelper = new JSONHelper();

/*Get all courses*/
$courses = $courseHelper->getAllCourses();

for($iter = 0; $iter<sizeof($courses);$iter++){
    /*Check each course update frequency */
    $courseName = $courses[$iter]['unitCode'];
    $oldDate =  $courses[$iter]['updatedOn'];
    $syncFreq = $courses[$iter]['syncFrequency'];
    $currDate = date("Y:m:d h:m:s");

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
        if ($interval->format('%m')>1){
            triggerSync($courseName);
        }
    }else if($syncFreq==4){
        /*Trigger Update Yearly*/
        if ($interval->format('%a')>365){
            triggerSync($courseName);
        }
    }
}
