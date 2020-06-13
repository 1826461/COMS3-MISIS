<?php

use Helpers\CourseDatabaseHelper;
use Helpers\TextHelper;
include ("..\..\Helpers\CourseDatabaseHelper.php");
include ("..\..\Helpers\DatabaseHelper.php");
include ("..\..\Helpers\TextHelper.php");
include ("..\..\Objects\Course.php");

session_start();
if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
    header("Location: ../index.php");
}
set_time_limit(0);
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Course Edit</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <!---->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

</head>
<body>
<!-- container -->
<div class="container">
    <div class="page-header">
        <?php
        $unitCode = isset($_GET['unitCode']) ? $_GET['unitCode'] : die('Error: Course not found.');
        $courseDatabaseHelper = new CourseDatabaseHelper();
        $textHelper = new TextHelper();
        $course = $courseDatabaseHelper->getCourse($unitCode);
        echo "<h1>Course Edit: {$course->getUnitCode()}</h1>" ?>
    </div>

    <!-- HTML read one record table will be here -->
    <!--we have our html table here where the record will be displayed-->
    <table id="table" class='table table-hover table-responsive '>
        <tr>
            <td>Course ID</td>
            <td><input id="courseID" class="form-control" type="text"
                       value="<?php echo $textHelper->getSpecialChars($course->getCourseID());  ?>"/></td>
        </tr>
        <tr>
            <td>Course Name</td>
            <td><input id="courseName" class="form-control" type="text"
                       value="<?php echo $textHelper->getSpecialChars($course->getCourseName());  ?>"/></td>
        </tr>


        <tr>
            <td></td>
            <td>
                <button type="submit" onclick="doEdit()" class="btn btn-primary">Update course</button>
                <a href='CourseMasterView.php' class='btn btn-danger'>Back to Moodle courses</a>
            </td>
        </tr>
    </table>


</div> <!-- end .container -->

<style>
    body{
        background-image: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
    }
    #table{
        background-color: white;
    }
</style>

<script>
//    $(function () {
//        $('#datetimepicker1').datetimepicker({
//            defaultDate: new Date(),
//            format: 'YYYY-MM-DD HH:mm:ss',
//            sideBySide: true,
//            ignoreReadonly:true
//        });
//    });

    function doEdit() {
        var courseID = 'courseID=' + document.getElementById("courseID").value + '&';
        var courseName = 'courseName=' + document.getElementById("courseName").value + '&';
        var unitCode = 'unitCode=' + <?php echo(json_encode($course->getUnitCode()))?>;


        //send to php edit script
        window.location.href = '../WebAPI/Courses/CourseUpdate.php?' + courseID + courseName + unitCode;
    }
</script>

</body>
</html>