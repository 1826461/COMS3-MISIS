<?php

use Helpers\MoodleCourseCategoriesDatabaseHelper;
use Helpers\MoodleCourseDatabaseHelper;
use Helpers\CourseDatabaseHelper;
use Helpers\EnrollmentDatabaseHelper;
use Helpers\JSONHelper;
use Objects\MoodleCourse;

include("..\..\Helpers\DatabaseHelper.php");
include("..\..\Helpers\MoodleCourseCategoriesDatabaseHelper.php");
include("..\..\Helpers\MoodleCourseDatabaseHelper.php");
include("..\..\Objects\MoodleCourse.php");
include("..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\Helpers\TextHelper.php");
include("..\..\Helpers\EnrollmentDatabaseHelper.php");
include("..\..\Helpers\JSONHelper.php");
include("..\..\Objects\Course.php");


session_start();

if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
    header("Location: ../index.php");
}
$timeout = 3600; // Number of seconds until it times out.

// Check if the timeout field exists.
if (isset($_SESSION['timeout'])) {
    // See if the number of seconds since the last
    // visit is larger than the timeout period.
    $duration = time() - (int)$_SESSION['timeout'];
    if ($duration > $timeout) {
        // Destroy the session and restart it.
        $_SESSION = array();
        session_destroy();
        session_start();
    }
}
// Update the timout field with the current time.
$_SESSION['timeout'] = time();

if (isset($_POST["Logout"])) {
    session_start();
    $_SESSION = array();
    session_unset();
    session_destroy();
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm anomalies</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"/>

    <!--javascript code -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <!---->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

    <!-- custom css -->
    <link href="style.css" rel="stylesheet">
</head>


<body>
<!--main form-->
<div class="diff-popup" id="diffForm" method="post">
    <div class="diff-container">
        <div class="container">
            <div class="page-header">
                <h1>Save course sync</h1>
            </div>
            <form class="logOut" method="post">
                <button type="submit" class="btn" name="Logout" id="exitButton" value="Logout"><span
                            class="glyphicon glyphicon-log-out"></span>Log out
                </button>
            </form>
            <div class="confirm">
                <button id='confirm' class='btn btn-success' onclick='confirm()'>Confirm selections</button>
            </div>
        </div>

        <div class="additions">
            <h2>Suggested additions:</h2>
            <?php
            $courseDatabaseHelper = new CourseDatabaseHelper();
            $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
            $JSONHelper = new JSONHelper();

            $virtusEnrollmentsNotInCurrent = $enrollmentDatabaseHelper->getAllEnrollmentsWhereInTemp();
            $allAdditions = json_encode($virtusEnrollmentsNotInCurrent);
            echo "<table id=\"tableAdditions\" class=\"table table-hover table-responsive table-bordered\">";
            echo "<tr>";


            if ($virtusEnrollmentsNotInCurrent != 0) {

                //add echos for table fields from database
                echo "<th><input type=\"checkbox\" onclick='checkAllAdditions(this)'>Select all additions</th>";
                echo "<th>Student Number</th>";
                echo "<th>Name</th>";
                echo "<th>Surname</th>";
                echo "<th>Subject</th>";
                echo "<th>Unit Code</th>";
                echo "<th>Course ID</th>";
                echo "<th>Class Section</th>";
                echo "<th>Session</th>";
                echo "<th>Expiry Date</th>";
                echo "</tr>";

                //add table contents
                for ($index = 0; $index < sizeof($virtusEnrollmentsNotInCurrent); $index++) {
                    $currEnrollment = json_encode($virtusEnrollmentsNotInCurrent[$index]);
                    echo "<tr>";
                    echo "<td><input type=\"checkbox\" onclick='toBeAdded({$currEnrollment})' name=\"checkboxAddition\"></td>";
                    echo "<td>{$virtusEnrollmentsNotInCurrent[$index]['studentNo']}</td>";
                    echo "<td>{$virtusEnrollmentsNotInCurrent[$index]['name']}</td>";
                    echo "<td>{$virtusEnrollmentsNotInCurrent[$index]['surname']}</td>";
                    echo "<td>{$virtusEnrollmentsNotInCurrent[$index]['subject']}</td>";
                    echo "<td>{$virtusEnrollmentsNotInCurrent[$index]['unitCode']}</td>";
                    echo "<td>{$virtusEnrollmentsNotInCurrent[$index]['courseId']}</td>";
                    echo "<td>{$virtusEnrollmentsNotInCurrent[$index]['classSection']}</td>";
                    echo "<td>{$virtusEnrollmentsNotInCurrent[$index]['session']}</td>";
                    echo "<td>{$virtusEnrollmentsNotInCurrent[$index]['expiryDate']}</td>";
                    echo "</tr>";
                }
                echo "</table>";

            } else {
                echo "<td style='text-align: center' >No records to display</td>";
                echo "</tr>";
                echo "</table>";

            }
            ?>
        </div>

        <div class="deletions">
            <h2>Suggested deletions:</h2>
            <?php
            $courseDatabaseHelper = new CourseDatabaseHelper();
            $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
            $JSONHelper = new JSONHelper();

            $virtusEnrollmentsNotInTemp = $enrollmentDatabaseHelper->getAllEnrollmentsWhereNotInTemp();
            $allDeletions = json_encode($virtusEnrollmentsNotInTemp);
            echo "<table id=\"tableDeletions\" class=\"table table-hover table-responsive table-bordered\">";
            echo "<tr>";


            if ($virtusEnrollmentsNotInTemp != 0) {

                //add echos for table fields from database
                echo "<th><input type=\"checkbox\" onclick='checkAllDeletions(this)'>Select all deletions</th>";
                echo "<th>Student Number</th>";
                echo "<th>Name</th>";
                echo "<th>Surname</th>";
                echo "<th>Subject</th>";
                echo "<th>Unit Code</th>";
                echo "<th>Course ID</th>";
                echo "<th>Class Section</th>";
                echo "<th>Session</th>";
                echo "<th>Expiry Date</th>";
                echo "</tr>";

                //add table contents
                for ($index = 0; $index < sizeof($virtusEnrollmentsNotInTemp); $index++) {
                    $currEnrollment = json_encode($virtusEnrollmentsNotInTemp[$index]);
                    echo "<tr>";
                    echo "<td><input type=\"checkbox\" onclick='toBeDeleted({$currEnrollment})' name=\"checkboxDeletion\"></td>";
                    echo "<td>{$virtusEnrollmentsNotInTemp[$index]['studentNo']}</td>";
                    echo "<td>{$virtusEnrollmentsNotInTemp[$index]['name']}</td>";
                    echo "<td>{$virtusEnrollmentsNotInTemp[$index]['surname']}</td>";
                    echo "<td>{$virtusEnrollmentsNotInTemp[$index]['subject']}</td>";
                    echo "<td>{$virtusEnrollmentsNotInTemp[$index]['unitCode']}</td>";
                    echo "<td>{$virtusEnrollmentsNotInTemp[$index]['courseId']}</td>";
                    echo "<td>{$virtusEnrollmentsNotInTemp[$index]['classSection']}</td>";
                    echo "<td>{$virtusEnrollmentsNotInTemp[$index]['session']}</td>";
                    echo "<td>{$virtusEnrollmentsNotInTemp[$index]['expiryDate']}</td>";
                    echo "</tr>";
                }
                echo "</table>";

            } else {
                echo "<td style='text-align: center' >No records to display</td>";
                echo "</tr>";
                echo "</table>";

            }
            ?>
        </div>
    </div>
</div>
</div>
</body>

<script type='text/javascript'>
    var additions = [];
    var deletions = [];
    var tempAdditions = [];
    var tempDeletions = [];

    function toBeAdded(enrollment) {
        var student = JSON.stringify(enrollment);
        var index = tempAdditions.indexOf(student);
        if(index === -1){
            tempAdditions.push(student);
        }
        else{
            tempAdditions.splice(index, 1);
        }
    }

    function toBeDeleted(enrollment) {
        var student = JSON.stringify(enrollment);
        var index = tempDeletions.indexOf(student);
        if(index === -1){
            tempDeletions.push(student);
        }
        else{
            tempDeletions.splice(index, 1);
        }
    }

    function checkAllAdditions(source){
        var checkboxes = document.querySelectorAll('input[name="checkboxAddition"]');
        for(var i = 0;i < checkboxes.length;i++){
            if(checkboxes[i] !== source){
                checkboxes[i].click();
            }
        }
    }

    function checkAllDeletions(source){
        var checkboxes = document.querySelectorAll('input[name="checkboxDeletion"]');
        for(var i = 0;i < checkboxes.length;i++){
            if(checkboxes[i] !== source){
                checkboxes[i].click();
            }
        }
    }

    //function when save is clicked
    function confirm() {
        /*if(courseID == -1){
            alert("This course has no associated ID");
            var flag = true;
            while(courseID == -1 || courseID == null || courseID == '' || courseID == NaN || flag == true){
                courseID = Number(prompt("Please enter a course ID(number) to associate with these courses", '0'));
                flag = false;
                for(var iLoop = 0; iLoop < takenID.length; ++iLoop){
                    if(takenID[iLoop] == courseID){
                        flag = true;
                        alert("This course ID is being used already");
                        break;
                    }
                }
                if(flag == false){
                    $.ajax({
                        type: "POST",
                        url: "../WebAPI/Sidebar/SidebarUpdateCoursesAndEnrollments.php",
                        data: {
                            courseID : courseID,
                            courseSame : JSON.stringify(sameCourseID)
                        },
                        success: function() {
                            alert("Success");
                            document.getElementById("saveForm").style.display = "none";
                            document.getElementById("mainView").style.webkitFilter = ""
                        }
                    });
                }
            }
        }
        else{*/
        for(var iLoop = 0; iLoop < tempAdditions.length; ++iLoop){
            additions.push(JSON.parse(tempAdditions[iLoop]));
        }
        for(var iLoop = 0; iLoop < tempDeletions.length; ++iLoop){
            deletions.push(JSON.parse(tempDeletions[iLoop]));
        }
            $.ajax({
                type: "POST",
                url: "../WebAPI/Sidebar/SidebarUpdateCoursesAndEnrollments.php",
                data: {
                    courseAdditions : JSON.stringify(additions),
                    courseDeletions : JSON.stringify(deletions)
                },
                success: function() {
                    alert("Success");
                    window.location.href = "../Sidebar/UpdateCourse.php";
                }
            });

        // }
    }
</script>

</html>