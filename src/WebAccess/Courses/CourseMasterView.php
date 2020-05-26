<?php

use Helpers\CourseDatabaseHelper;
include("..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\Helpers\DatabaseHelper.php");
include("..\..\Objects\Course.php");

session_start();
if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
    header ("Location: ../index.php");
}
$timeout = 3600; // Number of seconds until it times out.

// Check if the timeout field exists.
if(isset($_SESSION['timeout'])) {
    // See if the number of seconds since the last
    // visit is larger than the timeout period.
    $duration = time() - (int)$_SESSION['timeout'];
    if($duration > $timeout) {
        // Destroy the session and restart it.
        $_SESSION =array();
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
    <title>Enrollment Master</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <!-- custom css -->
    <link href="style.css" rel="stylesheet">
</head>

<body>
<!--main form-->
<div class="detail" method="post" id="mainView">

    <!--Container-->
    <div class="container">
        <div class="page-header">
            <h1>Enrollment Master</h1>
        </div>
        <!--logout button-->
        <form class="logOut" method="post">
            <button type="submit" class="btn" name="Logout" id="exitButton" value="Logout"><span class="glyphicon glyphicon-log-out"></span>Log out</button>
        </form>
        <!-- PHP code for read records here-->
        <?php

        $action = isset($_GET['action']) ? $_GET['action'] : "";
        // if it was redirected from EnrollmentDelete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success' id='message'>Course deleted.</div>";
        }

        if ($action == 'deny') {
            echo "<div class='alert alert-success' id='message'>You don't have permission to edit the database.</div>";
        }


        if ($action == 'created') {
            echo "<div class='alert alert-success' id='message'>Course created.</div>";
        }


        if ($action == 'edited') {
            echo "<div class='alert alert-success' id='message'>Course edited.</div>";
        }

        echo "Filter by unit code: ";
        echo "<select id='CourseList' class='selectpicker list' name='CourseList' onChange='changeCourses()'>";
        echo"<option selected='selected' name='All'>All</option>";
        $courseDatabaseHelper = new CourseDatabaseHelper();
        $result = $courseDatabaseHelper->getCourseList();

        for ($index = 0; $index < sizeof($result); $index++) {
            $listItem = $result[$index]['unitCode'];
            echo"<option name='$listItem' value=$listItem>$listItem</option>";
        }
        echo "</select>";
        //end of select

        //search for user
        echo  "<div class='topnav'>
       <input class='form-control' id='searchBar' type='text' placeholder='Search by column' onkeyup='findCourse()'>
       <div class='createHold'>";

        if ($_SESSION['admin']==1) {
            echo "<button class='btn btn-success' onclick='showCreate()'>Create Course</button></div>
       </div> ";
        } else {
            echo "</div>
       </div> ";
        }




        //add create button
        //echo "<div class='btnCreate'><button class='btn' onclick='showCreate()'>Create User</button></div>";
        function console_log($output, $with_script_tags = true) {
            $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
                ');';
            if ($with_script_tags) {
                $js_code = '<script>' . $js_code . '</script>';
            }
            echo $js_code;
        }

        $courseDatabaseHelper = new CourseDatabaseHelper();
        $courses = $courseDatabaseHelper->getAllCourses();

        if (sizeof($courses) > 0){
            //code to create database table
            echo"<div class='scrollit'>";
            echo "<table id='tableData' class='table table-hover table-responsive table-bordered'>";
            //start table
            //creating our table heading

            echo "<tr>";
            //add echos for table fields from database
            echo "<th>Course Name</th>";
            echo "<th>Unit Code</th>";
            echo "</tr>";


            //add table contents
            for ($index = 0; $index < sizeof($courses); $index++) {
                //while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                //extract($row);
                //create new table row per record
                echo "<tr>";
                echo "<td>{$courses[$index]['courseName']}</td>";
                echo "<td>{$courses[$index]['unitCode']}</td>";

                $name = $courses[$index]['courseName'];
                $code = $courses[$index]['unitCode'];
                $arr = array($courses[$index]['courseName'],$courses[$index]['unitCode']);
                $deleteParams = json_encode($courses[$index]['unitCode']);

                //issue in returning 2 variables to javascript

                //add more columns for td
                echo "<td>";
                // read one record for this user
                echo "<a href='CourseDetailView.php?courseName={$courses[$index]['courseName']}&unitCode={$courses[$index]['unitCode']}' class='btn btn-info m-r-1em'>View</a>";
                //edit user
                if ($_SESSION['admin']==1) {
                    echo "<a class='btn btn-warning' href='CourseEditView.php?courseName={$courses[$index]['courseName']}&unitCode={$courses[$index]['unitCode']}'>Edit</a>";
                    //href='editUser.php?studentNo={$row['studentNo']}'

                    // link for deleting this user
                    echo "<a onclick='showDelete({$deleteParams});' class='btn btn-danger  m-l-1em'>Delete</a>";
                }

                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        }else{
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>
    </div>


</div>


<div class="form-popup" id="deleteForm" method="post">
    <div class="form-container">
        <ul class="buttonGroup">
            <li><b>Are you sure you want to delete this course?</b></li>
            <li><button type="submit" class='btn btn-danger' onclick="deleteCourse()">Delete</button></li>
            <li><button type="submit" id="close" class='btn btn-info' onclick="closeForm()">Cancel</button></li>
        </ul>
    </div>
</div>

<div class="create_pop" id="create">
    <div class="create-container">
        <h2>Add Course:</h2>
        <div class="ulDiv">
            <ul class="createList">
                <li><input type="text" id="courseName" placeholder="Course Name"class="form-control"></li>
                <li><input type="text" id="unitCode" placeholder="Unit Code"class="form-control"></li>

                <div class="createButtons"><li><button type="submit" class='btn btn-success' onclick="createCourse()">Create New Course</button></li>
                    <li><button type="submit" id="close" class='btn btn-info' onclick="closeCreate()">Cancel</button></li></div>
            </ul>
        </div>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<script>
    //hide records that dont have class value
    //var deleteStudentNumber;
    var deleteUnitCode;

    function changeCourses() {
        var element = document.getElementById("ClassList").value;
        var table = document.getElementById("tableData");
        var tr = table.getElementsByTagName("tr");
        if (element=='All'){
            for (var i =0;i<tr.length;i++){
                tr[i].style.display="";
            }
        }else{
            for (var i =0;i<tr.length;i++){
                var td = tr[i].getElementsByTagName("td")[4]; //gets unit code
                if (td){
                    var txtVal = td.textContent||td.innerText;
                    // window.alert(txtVal);
                    if (txtVal==element){
                        tr[i].style.display = "";
                    }else{
                        tr[i].style.display="none";
                    }
                }
            }
        }
    }


    function showDelete(unitCode){
        //passing unit code works
        //show delete popup menu
        var delForm = document.getElementById("deleteForm");
        delForm.style.display="block";
        //hide table and make it un-editable
        document.getElementById("mainView").style.webkitFilter="brightness(50%)blur(4px)grayscale(30%)";
        deleteUnitCode = unitCode;
    }

    function deleteCourse() {
        var unit = deleteUnitCode;
        window.location.href = 'WebAPI/CourseDelete.php?unitCode=' + unit;
    }

    function closeForm(){
        document.getElementById("deleteForm").style.display="none";
        document.getElementById("mainView").style.webkitFilter="";
    }

    function closeCreate(){
        document.getElementById("create").style.display="none";
        document.getElementById("mainView").style.webkitFilter="";
    }

    function findCourse() {
        var element = document.getElementById("searchBar").value.toUpperCase();
        var table = document.getElementById("tableData");
        var tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            a = tr[i].getElementsByTagName("td")[0];
            b  = tr[i].getElementsByTagName("td")[1];
            c = tr[i].getElementsByTagName("td")[2];
            txtValue1 = a.textContent || a.innerText;
            txtValue2 = b.textContent || b.innerText;
            txtValue3 = c.textContent || c.innerText;
            if (txtValue1.indexOf(element) > -1||txtValue2.toUpperCase().indexOf(element) > -1||txtValue3.toUpperCase().indexOf(element) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    function showCreate() {
        var createForm = document.getElementById("create");
        createForm.style.display="block";
        //hide table and make it un-editable
        document.getElementById("mainView").style.webkitFilter="brightness(50%)blur(4px)grayscale(30%)";
        document.getElementById("cNum").focus();
    }

    function isBlank(){
        var courseName = document.getElementById("courseName").value;
        var unitCode = document.getElementById("unitCode").value;

        //TODO improve input validation
        if(isNaN(unitCode)){
            document.getElementById("unitCode").focus();
            return [true,"Please insert a valid unit code."];
        }

        if(courseName === ""){document.getElementById("courseName").focus(); return [true,"Please insert a course name."];}
        if(unitCode === ""){document.getElementById("unitCode").focus(); return[true,"Please insert a unit code."];}

        return [false,"none"];
    }
    function createUser() {
        if (isBlank()[0]){
            var msg = isBlank()[1];
            alert(msg);
        }else{
            var courseName = 'courseName=' + document.getElementById("courseName").value + '&';
            var unitCode = 'unitCode=' + document.getElementById("unitCode").value;

            //send to php create script
            var statement = 'WebAPI/CourseCreate.php?'+ courseName + unitCode;
            window.location.href = statement;
        }
    }

    $(function () {
        $('#datetimepicker1').datetimepicker({
            defaultDate: new Date(),
            format: 'YYYY-MM-DD HH:mm:ss',
            sideBySide: true
        });
    });

    setTimeout(function() {
        $('#message').fadeOut('fast');
    }, 5000); // <-- time in milliseconds


</script>


</html>