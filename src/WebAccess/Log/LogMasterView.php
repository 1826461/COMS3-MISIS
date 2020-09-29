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
<div class="detail" method="post" id="mainView">

    <!--Container-->
    <div class="container">
        <div class="page-header">
            <h1>Log</h1>
        </div>
        <!--logout button-->
        <form class="logOut" method="post">
            <button type="submit" class="btn" name="Logout" id="exitButton" value="Logout"><span
                        class="glyphicon glyphicon-log-out"></span>Log out
            </button>
        </form>
        <!-- PHP code for read records here-->
        <?php

        //search for user
        echo "<div class='topnav'>
       <input class='form-control' id='searchBar' type='text' placeholder='Search by column' onkeyup='findLogEntry()'>
       <div class='createHold'>";

        if ($_SESSION['admin'] == 1) {
            echo "<div class='viewButtons'>";
            echo "<ul class='views'>";
            echo "<li><button class='btn btn-primary' onclick='showEnrollments()'>Switch to enrollment view</button></li></ul></div></div>
       </div> ";
        } else {
            echo "<button class='btn btn-success' onclick='showEnrollments()'>Switch to enrollment view</button></div></div>";
        }


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


</script>


</html>