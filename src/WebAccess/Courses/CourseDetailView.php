<?php

use Helpers\CourseDatabaseHelper;
use Helpers\TextHelper;
use Helpers\EnrollmentDatabaseHelper;
include("..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\Helpers\TextHelper.php");
include("..\..\Helpers\EnrollmentDatabaseHelper.php");
include("..\..\Helpers\DatabaseHelper.php");
include("..\..\Objects\Course.php");

session_start();
if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
    header ("Location: ../index.php");
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Course Detail</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>
<!-- container -->
<div class="container">
    <div class="page-header">
        <?php
        $unitCode = isset($_GET['unitCode']) ? $_GET['unitCode'] : die('Error: Course not found.');
        $courseDatabaseHelper = new CourseDatabaseHelper();
        $course = $courseDatabaseHelper->getCourse($unitCode);
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $textHelper = new TextHelper();

        if ($enrollmentDatabaseHelper->getAllCourseEnrollments($unitCode) === 0) {
            $enrollmentCount = 0;
        } else {
            $enrollmentCount = sizeof($enrollmentDatabaseHelper->getAllCourseEnrollments($unitCode));
        }
        echo "<h1>Course Detail: {$course->getUnitCode()}</h1>" ?>
    </div>


    <!-- HTML read one record table will be here -->
    <!--we have our html table here where the record will be displayed-->
    <table id="table" class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Unit Code</td>
            <td><?php echo $textHelper->getSpecialChars($course->getUnitCode());  ?></td>
        </tr>
        <tr>
            <td>Course ID</td>
            <td><?php echo $textHelper->getSpecialChars($course->getCourseID());  ?></td>
        </tr>
        <tr>
            <td>Course Name</td>
            <td><?php echo $textHelper->getSpecialChars($course->getCourseName());  ?></td>
        </tr>
        <tr>
            <td>Enrollment Count</td>
            <td><?php echo $textHelper->getSpecialChars($enrollmentCount);  ?></td>
        </tr>


        <tr>
            <td></td>
            <td>
                <a href='CourseMasterView.php' class='btn btn-danger'>Back to Moodle courses</a>
            </td>
        </tr>
    </table>

</div> <!-- end .container -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
    body{
        background-image: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
    }
    #table{
        background-color: white;
    }
</style>

</body>
</html>