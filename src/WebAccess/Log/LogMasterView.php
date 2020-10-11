<?php

use Helpers\LogEntryDatabaseHelper;
use Objects\LogEntry;

include("..\..\Helpers\LogEntryDatabaseHelper.php");
include("..\..\Helpers\DatabaseHelper.php");
include("..\..\Helpers\JSONHelper.php");
include("..\..\Helpers\TextHelper.php");
include("..\..\Objects\LogEntry.php");

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
    <title>Log</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <!-- custom css -->
    <link href="style.css" rel="stylesheet">
</head>

<body>
<!--main form-->
<div class="container">
    <div class="page-header">
    </div>
    <!--logout button-->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
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
                    <li><a href="#" onclick="showEnrollments()">Enrollments</a></li>
                    <li><a href="#" onclick="showCourses()">Courses</a></li>
                    <li class="active" ><a href="#" onclick="showLog()">Log</a></li>
                    <li><a href="#" onclick="showMoodleCourses()" >Moodle Courses</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" onclick="logout()">Logout</a></li>
                </ul>
                <div class="input-group navbar-form navbar-right">
                    <input class='form-control' id='searchBar' type='text' placeholder='Search by column' onkeyup='findLogEntry()'>
                </div>


            </div>
        </div>
    </nav>
        <!-- PHP code for read records here-->
        <?php

        //search for user
        echo "<div class='createHold'> 
<h1 class='text-center'>Log Master</h1><br>";


        //add create button
        //echo "<div class='btnCreate'><button class='btn' onclick='showCreate()'>Create User</button></div>";

        $logEntryDatabaseHelper = new LogEntryDatabaseHelper();
        $logs = $logEntryDatabaseHelper->getAllLogEntries();
        echo "<table id='tableData' class='table table-hover table-responsive table-bordered'>";
        //start table
        //creating our table heading

        echo "<tr>";


        if ($logs !== 0) {

            //add echos for table fields from database
            echo "<th>User</th>";
            echo "<th>Message</th>";
            echo "<th>Created At</th>";
            echo "</tr>";

            //add table contents
            for ($index = 0; $index < sizeof($logs); $index++) {
                //while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                //extract($row);
                //create new table row per record


                echo "<tr>";

                echo "<td>{$logs[$index]['user']}</td>";
                echo "<td>{$logs[$index]['message']}</td>";
                echo "<td>{$logs[$index]['created_at']}</td>";

                //issue in returning 2 variables to javascript

                //add more columns for td




                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";

        } else {
            //add echos for table fields from database
            echo "<td style='text-align: center' >No records to display</td>";
            echo "</tr>";
            echo "</table>";
        }
        ?>
    </div>


</div>

</body>

<!--javascript code -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
<!---->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<script>
    //hide records that dont have class value
    //var deleteStudentNumber;

    function findLogEntry() {
        var element = document.getElementById("searchBar").value.toUpperCase();
        var table = document.getElementById("tableData");
        var tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            a = tr[i].getElementsByTagName("td")[0];
            b = tr[i].getElementsByTagName("td")[1];
            c = tr[i].getElementsByTagName("td")[2];
            txtValue1 = a.textContent || a.innerText;
            txtValue2 = b.textContent || b.innerText;
            txtValue3 = c.textContent || c.innerText;
            if (txtValue1.indexOf(element) > -1 || txtValue2.toUpperCase().indexOf(element) > -1 || txtValue3.toUpperCase().indexOf(element) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    function showEnrollments() {
        window.location.href = "../Enrollments/EnrollmentMasterView.php";
    }

    function logout() {
        window.location.href = "../WebAPI/Logout/logout.php";
    }

    function showCourses() {
        window.location.href = "../Courses/CourseMasterView.php";
    }

    function showLog() {
        window.location.href = "../Log/LogMasterView.php";
    }
    function showMoodleCourses() {
        window.location.href = "../Sidebar/UpdateCourse.php";
    }


</script>


</html>