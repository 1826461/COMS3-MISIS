<?php

use Helpers\CourseDatabaseHelper;
use Helpers\EnrollmentDatabaseHelper;
use Objects\Course;
use Objects\Enrollment;

include("..\..\..\Helpers\EnrollmentDatabaseHelper.php");
include("..\..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\..\Helpers\DatabaseHelper.php");
include("..\..\..\Objects\Enrollment.php");
include("..\..\..\Objects\Course.php");

session_start();

$id = 0;
$studentNo = isset($_GET['studentNo']) ? $_GET['studentNo'] : die('Error: Username not found.');
$name = isset($_GET['name']) ? $_GET['name'] : die('Error: Name not found');
$surname = isset($_GET['surname']) ? $_GET['surname'] : die('Error: Surname not found.');
$subject = isset($_GET['subject']) ? $_GET['subject'] : die('Error: Subject not found.');
$unitCode = isset($_GET['unitCode']) ? $_GET['unitCode'] : die('Error: Unit code not found.');
$session = isset($_GET['session']) ? $_GET['session'] : die('Error: Session not found.');
$classSection = isset($_GET['classSection']) ? $_GET['classSection'] : die('Error: Class Section not found.');
$expiryDate = isset($_GET['expiryDate']) ? $_GET['expiryDate'] : die('Error: Expiry date not found.');
$status = "ENROLLED";

if ($_SESSION['admin'] == 1) {
    $course = new Course($unitCode, 0);
    $enrollment = new Enrollment($id, $studentNo, $name, $surname, $subject, $unitCode, $session, $classSection, $expiryDate, $status);
    $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
    $courseDatabaseHelper = new CourseDatabaseHelper();
    $enrollmentDatabaseHelper->insertEnrollment($enrollment);
    $course = $courseDatabaseHelper->getCourse($unitCode);
    if ($course != 0) {
        $enrollmentDatabaseHelper->updateEnrollmentWhenCourseChange($course->getUnitCode(), $course->getCourseID());
    }

    header('Location: ../../Enrollments/EnrollmentMasterView.php?action=created');

} else {
    header('Location: ../../Enrollments/EnrollmentMasterView.php?action=deny');
}

