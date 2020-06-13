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
<html>
<head>
    <title>Enrollment Detail</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
</head>
<body>
<!-- container -->
<div class="container">
    <div class="page-header">
        <?php
        $studentNo = isset($_GET['studentNo']) ? $_GET['studentNo'] : die('Error: User not found.');
        $unitCode = isset($_GET['unitCode']) ? $_GET['unitCode'] : die('Error: User not found.');
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $textHelper = new TextHelper();
        $enrollment = $enrollmentDatabaseHelper->getEnrollment($studentNo, $unitCode);
        echo "<h1>Enrollment Detail: {$enrollment->getStudentNo()} - {$enrollment->getUnitCode()}</h1>" ?>
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

</body>
</html>