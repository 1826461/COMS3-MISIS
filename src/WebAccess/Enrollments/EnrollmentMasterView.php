<?php

use Helpers\CourseDatabaseHelper;
use Helpers\EnrollmentDatabaseHelper;

include("..\..\Helpers\EnrollmentDatabaseHelper.php");
include("..\..\Helpers\CourseDatabaseHelper.php");
include("..\..\Helpers\DatabaseHelper.php");
include("..\..\Objects\Enrollment.php");

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
    <title>Enrollment Master</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>

    <!--javascript code -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
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
            <button type="submit" class="btn" name="Logout" id="exitButton" value="Logout"><span
                        class="glyphicon glyphicon-log-out"></span>Log out
            </button>
        </form>
        <!-- PHP code for read records here-->
        <?php

        $action = isset($_GET['action']) ? $_GET['action'] : "";
        // if it was redirected from EnrollmentDelete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success' id='message'>Enrollment deleted.</div>";
        }

        if ($action == 'deny') {
            echo "<div class='alert alert-success' id='message'>You don't have permission to edit the database.</div>";
        }


        if ($action == 'created') {
            echo "<div class='alert alert-success' id='message'>Enrollment created.</div>";
        }


        if ($action == 'edited') {
            echo "<div class='alert alert-success' id='message'>Enrollment edited.</div>";
        }

        echo "Filter by unit code: ";
        echo "<select id='ClassList' class='selectpicker list' name='ClassList' onChange='changeClasses()'>";
        echo "<option selected='selected' name='All'>All</option>";
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $result = $enrollmentDatabaseHelper->getCourseList();

        for ($index = 0; $index < sizeof($result); $index++) {
            $listItem = $result[$index]['unitCode'];
            echo "<option name='$listItem' value=$listItem>$listItem</option>";
        }
        echo "</select>";
        //end of select

        //search for user
        echo "<div class='topnav'>
       <input class='form-control' id='searchBar' type='text' placeholder='Search by column' onkeyup='findUser()'>
       <div class='createHold'>";

        if ($_SESSION['admin'] == 1) {
            echo "<div class='viewButtons'>";
            echo "<ul class='views'>";
            echo "<li><button class='btn btn-success' onclick='showCourses()'>Switch to course view</button></li>";
            echo "<li><button class='btn btn-success' onclick='showCreate()'>Create Enrollment</button></li></ul></div></div>
       </div> ";
        } else {
            echo "<button class='btn btn-success' onclick='showCourses()'>Switch to course view</button></div></div>";
        }


        //add create button
        //echo "<div class='btnCreate'><button class='btn' onclick='showCreate()'>Create User</button></div>";
        function console_log($output, $with_script_tags = true)
        {
            $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
                ');';
            if ($with_script_tags) {
                $js_code = '<script>' . $js_code . '</script>';
            }
            echo $js_code;
        }

        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $enrollments = $enrollmentDatabaseHelper->getAllEnrollments();

        //start table
        //creating our table heading

        echo "<table id='tableData' class='table table-hover table-responsive table-bordered'>";

        echo "<tr>";




        if ($enrollments != 0) {

            //add echos for table fields from database
            echo "<th>Student Number</th>";
            echo "<th>Name</th>";
            echo "<th>Surname</th>";
            echo "<th>Subject</th>";
            echo "<th>Unit Code</th>";
            echo "<th>Course ID</th>";
            echo "<th>Class Section</th>";
            echo "<th>Session</th>";
            echo "<th>Expiry Date</th>";
            echo "<th>Actions</th>";
            echo "</tr>";

            //add table contents
            for ($index = 0; $index < sizeof($enrollments); $index++) {
                //while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                //extract($row);
                //create new table row per record
                echo "<tr>";
                echo "<td>{$enrollments[$index]['studentNo']}</td>";
                echo "<td>{$enrollments[$index]['name']}</td>";
                echo "<td>{$enrollments[$index]['surname']}</td>";
                echo "<td>{$enrollments[$index]['subject']}</td>";
                echo "<td>{$enrollments[$index]['unitCode']}</td>";
                echo "<td>{$enrollments[$index]['courseId']}</td>";
                echo "<td>{$enrollments[$index]['classSection']}</td>";
                echo "<td>{$enrollments[$index]['session']}</td>";
                echo "<td>{$enrollments[$index]['expiryDate']}</td>";

                $user = $enrollments[$index]['studentNo'];
                $sub = $enrollments[$index]['subject'];
                $code = $enrollments[$index]['unitCode'];
                $arr = array($enrollments[$index]['studentNo'], $enrollments[$index]['subject']);
                $deleteParams = json_encode(array($enrollments[$index]['studentNo'], $enrollments[$index]['unitCode']));

                //issue in returning 2 variables to javascript

                //add more columns for td
                echo "<td>";
                // read one record for this user
                echo "<a href='EnrollmentDetailView.php?studentNo={$enrollments[$index]['studentNo']}&unitCode={$enrollments[$index]['unitCode']}' class='btn btn-info m-r-1em'>View</a>";
                //edit user
                if ($_SESSION['admin'] == 1) {
                    echo "<a class='btn btn-warning' href='EnrollmentEditView.php?studentNo={$enrollments[$index]['studentNo']}&unitCode={$enrollments[$index]['unitCode']}'>Edit</a>";
                    //href='editUser.php?studentNo={$row['studentNo']}'

                    // link for deleting this user
                    echo "<a onclick='showDelete({$deleteParams})' class='btn btn-danger  m-l-1em'>Delete</a>";
                }

                echo "</td>";
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


<div class="form-popup" id="deleteForm" method="post">
    <div class="form-container">
        <ul class="buttonGroup">
            <li><b>Are you sure you want to delete this enrollment?</b></li>
            <li>
                <button type="submit" class='btn btn-danger' onclick="deleteUser()">Delete</button>
            </li>
            <li>
                <button type="submit" id="close" class='btn btn-info' onclick="closeForm()">Cancel</button>
            </li>
        </ul>
    </div>
</div>

<div class="create_pop" id="create">
    <div class="create-container">
        <h2>Add Enrollment:</h2>
        <div class="ulDiv">
            <ul class="createList">
                <li><input type="text" id="studentNo" placeholder="Student Number" class="form-control"></li>
                <li><input type="text" id="name" placeholder="Name" class="form-control"></li>
                <li><input type="text" id="surname" placeholder="Surname" class="form-control"></li>
                <li><input type="text" id="subject" placeholder="Subject" class="form-control"></li>
                <li>Select a code:</li>
                <li><select class="selectpicker" type="text" id="unitCode">
                        <?php
                        echo "<option selected='selected' name='All'></option>";
                        $courseDatabaseHelper = new CourseDatabaseHelper();
                        $result = $courseDatabaseHelper->getCourseList();

                        for ($index = 0; $index < sizeof($result); $index++) {
                            $listItem = $result[$index]['unitCode'];
                            echo "<option name='$listItem' value=$listItem>$listItem</option>";
                        }
                        echo "</select>";
                        ?>
                    </select>
                </li>
                <li>Select a class section:</li>
                <li><select class="selectpicker" type="text" id="classSection">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                    </select></li>
                <li>Select a session:</li>
                <li><select class="selectpicker" type="text" id="session">
                        <option value="SM1">SM1</option>
                        <option value="SM2">SM2</option>
                    </select></li>
                <li>Expiry Date:</li>
                <li>
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' id="expiryDate" class="form-control" placeholder="Expiry Date" readonly/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </li>

                <div class="createButtons">
                    <li>
                        <button type="submit" class='btn btn-success' onclick="createUser()">Create New User</button>
                    </li>
                    <li>
                        <button type="submit" id="close" class='btn btn-info' onclick="closeCreate()">Cancel</button>
                    </li>
                </div>
            </ul>
        </div>
    </div>
</div>


</body>

<script>
    //hide records that dont have class value
    var deleteStudentNumber;
    var deleteUnitCode;

    function changeClasses() {
        var element = document.getElementById("ClassList").value;
        var table = document.getElementById("tableData");
        var tr = table.getElementsByTagName("tr");
        if (element == 'All') {
            for (var i = 0; i < tr.length; i++) {
                tr[i].style.display = "";
            }
        } else {
            for (var i = 0; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td")[4]; //gets unit code
                if (td) {
                    var txtVal = td.textContent || td.innerText;
                    // window.alert(txtVal);
                    if (txtVal == element) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    }


    function showDelete(studentNumber) {
        //passing student number works
        //show delete popup menu
        var delForm = document.getElementById("deleteForm");
        delForm.style.display = "block";
        //hide table and make it un-editable
        document.getElementById("mainView").style.webkitFilter = "brightness(50%)blur(4px)grayscale(30%)";
        deleteStudentNumber = studentNumber[0];
        deleteUnitCode = studentNumber[1];
    }

    function deleteUser() {
        var student = deleteStudentNumber;
        var unit = deleteUnitCode;
        window.location.href = '../WebAPI/Enrollments/EnrollmentDelete.php?studentNo=' + student + '&unitCode=' + unit;
    }

    function closeForm() {
        document.getElementById("deleteForm").style.display = "none";
        document.getElementById("mainView").style.webkitFilter = "";
    }

    function closeCreate() {
        document.getElementById("create").style.display = "none";
        document.getElementById("mainView").style.webkitFilter = "";
    }

    function findUser() {
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

    function showCreate() {
        var createForm = document.getElementById("create");
        createForm.style.display = "block";
        //hide table and make it un-editable
        document.getElementById("mainView").style.webkitFilter = "brightness(50%)blur(4px)grayscale(30%)";
        document.getElementById("cNum").focus();
    }

    function showCourses() {
        window.location.href = '../Courses/CourseMasterView.php';
    }

    function isBlank() {
        var studentNo = document.getElementById("studentNo").value;
        var name = document.getElementById("name").value;
        var surname = document.getElementById("surname").value;
        var subject = document.getElementById("subject").value;
        var unitCode = document.getElementById("unitCode").value;

        //null checks
        if (studentNo === "") {
            document.getElementById("studentNo").focus();
            return [true, "Please insert a student number."];
        }
        if (name === "") {
            document.getElementById("name").focus();
            return [true, "Please insert a name."];
        }
        if (surname === "") {
            document.getElementById("surname").focus();
            return [true, "Please insert a surname."];
        }
        if (subject === "") {
            document.getElementById("subject").focus();
            return [true, "Please insert a subject."];
        }
        if (unitCode === "" || unitCode === null) {
            document.getElementById("unitCode").focus();
            return [true, "Please insert a unit code."];
        }


        //TODO improve input validation
        //checking valid student number
        if (isNaN(studentNo) || studentNo.length < 2) {
            document.getElementById("studentNo").focus();
            return [true, "Please insert a valid student number."];
        }
        //checking valid name and surname with certain special characters
        var format = /[ `!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/?~0123456789]/;

        if (format.test(name) || name.length < 3) {
            document.getElementById("name").focus();
            return [true, "Please insert a valid name."]
        }
        //surnames can have spaces
        var format2 = /[`!@#$%^&*()_+\=\[\]{};':"\\|,.<>\/?~0123456789]/;
        if (format2.test(surname) || surname.length < 3) {
            document.getElementById("surname").focus();
            return [true, "Please insert a valid surname."]
        }
        //subjects are only strings
        if (format.test(subject) || subject.length < 4) {
            document.getElementById("subject").focus();
            return [true, "Please insert a valid subject."]
        }
        //checking valid unitCode
        var unitCheck = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
        if (unitCheck.test(unitCode) || unitCode.length < 8) {
            document.getElementById("unitCode").focus();
            return [true, "Please insert a valid unit code."]
        }
        return [false, "none"];
    }

    function createUser() {
        if (isBlank()[0]) {
            var msg = isBlank()[1];
            alert(msg);
        } else {
            var student = 'studentNo=' + document.getElementById("studentNo").value + '&';
            var name = 'name=' + document.getElementById("name").value + '&';
            var surname = 'surname=' + document.getElementById("surname").value + '&';
            var subject = 'subject=' + document.getElementById("subject").value + '&';
            var unitCode = 'unitCode=' + document.getElementById("unitCode").value + '&';
            var session = 'session=' + document.getElementById("session").value + '&';
            var classSection = 'classSection=' + document.getElementById("classSection").value + '&';
            var expiryDate = 'expiryDate=' + document.getElementById("expiryDate").value;

            //send to php create script
            var statement = '../WebAPI/Enrollments/EnrollmentCreate.php?' + student + name + surname + subject + unitCode + session + classSection + expiryDate;
            window.location.href = statement;
        }
    }

    $(function () {
        $('#datetimepicker1').datetimepicker({
            defaultDate: new Date(),
            format: 'YYYY-MM-DD HH:mm:ss',
            sideBySide: true,
            ignoreReadonly: true
        });
    });

    setTimeout(function () {
        $('#message').fadeOut('fast');
    }, 5000); // <-- time in milliseconds


</script>


</html>