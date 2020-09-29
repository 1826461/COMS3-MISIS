<?php

use Helpers\EnrollmentDatabaseHelper;
use Helpers\TextHelper;

include("..\..\Helpers\EnrollmentDatabaseHelper.php");
include("..\..\Helpers\TextHelper.php");
include("..\..\Helpers\DatabaseHelper.php");
include("..\..\Objects\Enrollment.php");

session_start();
if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
    header("Location: ../index.php");
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Enrollment Detail</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <!---->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
</head>
<body>
<!-- container -->
<div class="container">
    <div class="page-header">
    </div>
    <!--logout button-->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">COMS3-MISIS</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#" onclick="showEnrollments()">Enrollments</a></li>
                    <li><a href="#" onclick="showCourses()">Courses</a></li>
                    <li><a href="#" onclick="showLog()">Log</a></li>
                    <li><a href="#" onclick="showMoodleCourses()" >Moodle Courses</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" onclick="logout()">Logout</a></li>
                </ul>

            </div>
        </div>
    </nav>





    <div>
        <?php
        $studentNo = isset($_GET['studentNo']) ? $_GET['studentNo'] : die('Error: User not found.');
        $unitCode = isset($_GET['unitCode']) ? $_GET['unitCode'] : die('Error: User not found.');
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $textHelper = new TextHelper();
        $enrollment = $enrollmentDatabaseHelper->getEnrollment($studentNo, $unitCode);
        echo "<h1 class='text-center'>Enrollment Detail: {$enrollment->getStudentNo()} - {$enrollment->getUnitCode()}</h1>" ?>
    </div>


    <!-- HTML read one record table will be here -->
    <!--we have our html table here where the record will be displayed-->
    <table id="table" class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Student Number</td>
            <td><?php echo $textHelper->getSpecialChars($enrollment->getStudentNo()); ?></td>
        </tr>
        <tr>
            <td>Name</td>
            <td><?php echo $textHelper->getSpecialChars($enrollment->getName()); ?></td>
        </tr>
        <tr>
            <td>Surname</td>
            <td><?php echo $textHelper->getSpecialChars($enrollment->getSurname()); ?></td>
        </tr>
        <!-- add more table records -->
        <tr>
            <td>Subject</td>
            <td><?php echo $textHelper->getSpecialChars($enrollment->getSubject()); ?></td>
        </tr>
        <tr>
            <td>Unit Code</td>
            <td><?php echo $textHelper->getSpecialChars($enrollment->getUnitCode()); ?></td>
        </tr>
        <tr>
            <td>Course ID</td>
            <td><?php echo $textHelper->getSpecialChars($enrollment->getCourseID()); ?></td>
        </tr>
        <tr>
            <td>Session</td>
            <td><?php echo $textHelper->getSpecialChars($enrollment->getSession()); ?></td>
        </tr>
        <tr>
            <td>Class Section</td>
            <td><?php echo $textHelper->getSpecialChars($enrollment->getClassSection()); ?></td>
        </tr>
        <tr>
            <td>Expiry Date</td>
            <td><?php echo $textHelper->getSpecialChars($enrollment->getExpiryDate()); ?></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><?php echo $textHelper->getSpecialChars($enrollment->getStatus()); ?></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <a href='EnrollmentMasterView.php' class='btn btn-danger'>Back to Moodle users</a>
            </td>
        </tr>
    </table>

</div> <!-- end .container -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
    body {
        background-image: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
    }

    #table {
        background-color: white;
    }
</style>

<script>

    function showUpdate() {
        window.location.href = '../Sidebar/UpdateCourse.php';
    }

    function showCourses() {
        window.location.href = '../Courses/CourseMasterView.php';
    }

    function showLog() {
        window.location.href = '../Log/LogMasterView.php';
    }

    function showMoodleCourses() {
        window.location.href = "../Sidebar/UpdateCourse.php";
    }

    function logout() {
        window.location.href = "../WebAPI/Logout/logout.php";
    }
</script>

</body>
</html>