<?php
    use Helpers\CourseDatabaseHelper;
    use Helpers\EnrollmentDatabaseHelper;
    use Objects\Course;

    include("..\..\..\Helpers\CourseDatabaseHelper.php");
    include("..\..\..\Helpers\EnrollmentDatabaseHelper.php");
    include("..\..\..\Helpers\DatabaseHelper.php");
    include("..\..\..\Helpers\JSONHelper.php");
    include("..\..\..\Objects\Course.php");

    session_start();

    //first method deleted correctly but did not do rest correctly
    //$courseIDStr = isset($_GET['courseID']) ? $_GET['courseID'] : die('Error: ID not found.');
    //$courseSame = isset($_GET['courseSame']) ? $_GET['courseSame'] : die('Error: Array not found.');

    //second method
    $courseIDStr = $_POST['courseID'];
    $courseSame = $_POST['courseSame'];
    var_dump($courseSame);
    if ($_SESSION['admin'] == 1) {
        //delete all courses with the course id of the main course
        $courseDatabaseHelper = new CourseDatabaseHelper();
        $courseDatabaseHelper->deleteCourseWithID($courseIDStr);
        //delete all enrollments with the course id of the main course
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $enrollmentDatabaseHelper->deleteAllCourseEnrollmentsWithID($courseIDStr);

        //supposed to go through the posted array containing associated course codes and add them back into DB and their enrollments
        //have a feeling the error occurs here
        for ($index = 0; $index < $courseSame.length; $index++) {
            $course = new Course($courseSame[$index], $courseIDStr);
            if ($courseName != "") {
                $course->setCourseName($courseName);
            }
            $courseDatabaseHelper->insertCourse($course);
            $JSONHelper = new JSONHelper();
            $work = $JSONHelper->addCourseData($unitCode);
            $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
            $enrollmentDatabaseHelper->updateEnrollmentWhenCourseChange($course->getUnitCode(), $course->getCourseID());
        }

        header('Location: ../../Courses/CourseMasterView.php?action=edited');
    } else {
        header('Location: ../../Courses/CourseMasterView.php?action=deny');
    }