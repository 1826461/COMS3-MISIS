<?php

use Helpers\CourseDatabaseHelper;
use Helpers\EnrollmentDatabaseHelper;
use Helpers\JSONHelper;
use Objects\Course;
use Objects\Enrollment;

include("..\..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\..\Helpers\EnrollmentDatabaseHelper.php");
include("..\..\..\Helpers\DatabaseHelper.php");
include("..\..\..\Helpers\JSONHelper.php");
include("..\..\..\Objects\Enrollment.php");
include("..\..\..\Objects\Course.php");

session_start();

$courseAdditions = $_POST['courseAdditions'];
$courseDeletions = $_POST['courseDeletions'];

$courseAdd = json_decode($courseAdditions);
$courseDel = json_decode($courseDeletions);

if ($_SESSION['admin'] == 1) {
    $courseDatabaseHelper = new CourseDatabaseHelper();
    $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
    $JSONHelper = new JSONHelper();

    for ($index = 0; $index < sizeof($courseAdd);$index++) {
        $enrollmentDatabaseHelper->deleteAllTempEnrollments();
        $enrollment = new Enrollment($courseAdd[$index]['id'],$courseAdd[$index]['studentNo'],$courseAdd[$index]['name'], $courseAdd[$index]['surname'], $courseAdd[$index]['subject'], $courseAdd[$index]['unitCode'], $courseAdd[$index]['session'], $courseAdd[$index]['classSection'], $courseAdd[$index]['expiryDate'], $courseAdd[$index]['status']);
        //$enrollment = new Enrollment("0","1644868","Michael", "Gomes", "COMS", "COMS1016A", "A", "B", "2022", "ENROLLED");
        $enrollmentDatabaseHelper->insertEnrollment($enrollment);
    }

    for ($index = 0; $index < sizeof($courseDel); $index++) {
        $enrollmentDatabaseHelper->deleteEnrollment($courseDel[$index]['studentNo'], $courseDel[$index]['unitCode']);
    }
    //$enrollmentDatabaseHelper->deleteAllTempEnrollments();

} else {
    header('Location: ../../Courses/CourseMasterView.php?action=deny');
}
