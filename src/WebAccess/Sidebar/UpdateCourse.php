<?php

use Helpers\MoodleCourseCategoriesDatabaseHelper;
use Helpers\MoodleCourseDatabaseHelper;
use Helpers\CourseDatabaseHelper;
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
    <title>Course Update Master</title>
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
<div class="detail" method="post" id="mainView">

    <!--Container-->
    <div class="container">
        <div class="page-header">
            <h1>Update Courses Master</h1>
        </div>
        <!--logout button-->
        <form class="logOut" method="post">
            <button type="submit" class="btn" name="Logout" id="exitButton" value="Logout"><span
                        class="glyphicon glyphicon-log-out"></span>Log out
            </button>
        </form>
        <div class="collapseButtons2">
            <button class='btn btn-info' onclick='saveCourseConfig()'>Save course configuration</button>
        </div>
        <div class="collapseButtons">
            <button class='btn btn-primary' onclick='showMain()'>Switch to Main view</button>
        </div>
    </div>

    <!-- Side navigation -->
    <div class="sidenav">
        <h2>All courses:</h2>
        <?php
        //get all courses and make them into an a clickable object eg. echo "<a>Button</a>";
        //create helper object
        $moodleCourseDatabaseHelper = new MoodleCourseDatabaseHelper();
        $moodleCourseCategoryHelper = new MoodleCourseCategoriesDatabaseHelper();
        $moodleCategories = $moodleCourseCategoryHelper->getAllMoodleCourseCategories();

        $courseDatabaseHelper = new CourseDatabaseHelper();
        $courseVirtus = $courseDatabaseHelper->getAllCourses();

        $allCourses = [];

        echo "<div class=\"panel-group\" id='accordion'>";
                    for ($index = 0; $index < sizeof($moodleCategories); $index++) { //accordion
                        echo "<div class='panel'>";

                        //panel header
                        echo "<div class=\"panel-heading\">";
                        echo "<button class=\"btn btn-danger acc\" data-toggle=\"collapse\" data-parent=\"#accordion\" data-target=\"#{$moodleCategories[$index]['id']}\" aria-expanded=\"false\" aria-controls=\"{$moodleCategories[$index]['id']}\">{$moodleCategories[$index]['name']}</button>";
                        echo "</div>";

                        echo "<div id='{$moodleCategories[$index]['id']}' class=\"panel-collapse collapse\">";
                        echo "<div class=\"panel-body\">";

                        //get each course associated to this category
                        $courses = $moodleCourseDatabaseHelper->getAllMoodleCoursesByCategory($moodleCategories[$index]['id']);

                        if ($courses != 0) {
                            $numCourse = sizeof($courses);
                            for ($coursesIndex = 0; $coursesIndex < sizeof($courses); $coursesIndex++) {

                                //moodle object
                                $courseObject = new MoodleCourse($courses[$coursesIndex]['id'], $courses[$coursesIndex]['fullname'], $courses[$coursesIndex]['shortname'], $courses[$coursesIndex]['category']);
                                array_push($allCourses, $courseObject);

                                echo "<a href=\"#\" onclick=\"clickCourse(this.id,{$courses[$coursesIndex]['id']})\" id=\"{$courses[$coursesIndex]['fullname']}\">{$courses[$coursesIndex]['shortname']}</a>";
                            }
                        } else {
                            echo "<a>None</a>";
                        }
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                echo "</div>";

        ?>
    </div>

    <!-- id start from 200 upwards for course code a tags -->
    <!-- name start from 200 upwards for course code associated remove button -->
    <div class="sidenav2">
        <h2>Associated courses:</h2>
        <?php
        echo "<div class=\"panel-group\" id='accordion'>";
        echo "<div class='panel'>";

        echo "<div class=\"panel-body\">";

        echo "<table id=\"tableAssociated\" class=\"table table-hover table-responsive table-bordered\">";
        for ($index = 0; $index < 5; $index++) {
            echo "<tr>";
            $newIndex = $index+200;
            if ($index != 0) {
                echo "<td>";
                echo "<a href=\"#\" id=$newIndex>None</a>";
                echo "</td>";
                if($index >= 1){
                    echo "<td>";
                    echo "<button class=\"btn btn-warning\" onclick=\"removeCourse(this.name)\" name=$newIndex style=\"display: none;\"></button>";
                    echo "</td>";
                }
            } else {
                echo "<td>";
                echo "<a id=200>None</a>";
                echo "</td>";
                echo "<td>";
                echo "<button name=200 class=\"btn btn-warning\" onclick=\"removeCourse(this.name)\" style=\"display: none;\"></button>";
                echo "</td>";
            }
            echo "</tr>";

        }
        echo "</table>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        ?>
    </div>

    <!-- id start from 100 upwards for course code a tags -->
    <!-- name start from 100 upwards for course code associated add button -->
    <div class="sidenav3">
        <h2>Suggested courses:</h2>
        <?php
        echo "<div class=\"panel-group\" id='accordion'>";
        echo "<div class='panel'>";

        echo "<div class=\"panel-body\">";

        echo "<table id=\"tableSuggested\" class=\"table table-hover table-responsive table-bordered\">";
        for ($index = 0; $index < 5; $index++) {
            echo "<tr>";
            $newIndex = $index+100;
            if ($index != 0) {
                echo "<td>";
                echo "<a href=\"#\" id=$newIndex>None</a>";
                echo "</td>";
                if($index >= 1){
                    echo "<td>";
                    echo "<button name=$newIndex class=\"btn btn-success\" onclick=\"addCourse(this.name)\" style=\"display: none;\"></button>";
                    echo "</td>";
                }
            } else {
                echo "<td>";
                echo "<a id=100>None</a>";
                echo "</td>";
                echo "<td>";
                echo "<button name=$newIndex class=\"btn btn-success\" onclick=\"addCourse(this.name)\" style=\"display: none;\"></button>";
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        ?>
    </div>
</div>

<div class="form-popup" id="saveForm" method="post">
    <div class="form-container">
        <ul class="buttonGroup">
            <li><b>Are you sure you want to save your changes for this course?</b></li>
            <li>
                <button type="submit" class='btn btn-danger' onclick="saveCourse()">Save</button>
            </li>
            <li>
                <button type="submit" id="close" class='btn btn-info' onclick="closeForm()">Cancel</button>
            </li>
        </ul>
    </div>
</div>

</body>

<script type='text/javascript'>
    var sameCourseID = [];
    var courseID = 0;
    //var takenID = [];
    function clickCourse(clickedID,id) {
        var chosenID = clickedID;
        var dash = chosenID.indexOf("-");
        courseID = id;
        dash = dash - 1;
        while (chosenID[dash] == " ") {
            dash = dash - 1;
        }
        var coursesCon = chosenID.substring(0, dash + 1);
        var courses = coursesCon.split("/");

        var jArray = <?php echo json_encode($courseVirtus); ?>;
        sameCourseID.splice(0, sameCourseID.length);
        sameCourseID.push(courses[0]);

        //reset suggested table
        for(var i = 1; i <= 5; ++i) {
            document.getElementById(100 + i - 1).innerHTML = 'None';
            document.getElementById(100 + i - 1).style.display = "initial";
            document.getElementsByName(100 + i - 1)[0].innerHTML = '';
            document.getElementsByName(100 + i - 1)[0].style.display = "none";
        }

        //find if any already associated are suggested
        var flag = false;
        for (var i = 1; i < courses.length; ++i) {
            flag = false;
            for(var j = 0;j < jArray.length;++j) {
                if(jArray[j]['unitCode'] == courses[i]) {
                    flag = true;
                }
            }
            if(flag == false) {
                document.getElementById(100 + i - 1).innerHTML = courses[i];
                document.getElementById(100 + i - 1).style.display = "initial";
                if (i >= 1) {
                    document.getElementsByName(100 + i - 1)[0].innerHTML = 'Add';
                    document.getElementsByName(100 + i - 1)[0].style.display = "initial";
                }
            }
        }

        //clear all after certain point
        for (var i = courses.length; i < 4; ++i) {
            document.getElementById(100+i - 1).innerHTML = 'None';
            document.getElementsByName(100+i - 1)[0].innerHTML = '';
            document.getElementsByName(100+i - 1)[0].style.display = "none";
        }

        //clear associated table
        for (var iLoop = 0; iLoop <= 4; ++iLoop) {
            document.getElementById(200+iLoop).innerHTML = 'None';
            document.getElementsByName(200+iLoop)[0].innerHTML = '';
            document.getElementsByName(200+iLoop)[0].style.display = "none";
        }

       /* for (var iLoop = 0; iLoop < jArray.length; ++iLoop) {
            //takenID.push(jArray[iLoop]['courseID']);
            if (jArray[iLoop]['unitCode'] == courses[0]) {
                courseID = jArray[iLoop]['courseID'];
            }
        }*/

        for (var iLoop = 0; iLoop < jArray.length; ++iLoop) {
            if (jArray[iLoop]['courseID'] == courseID && jArray[iLoop]['unitCode'] != courses[0]) {
                sameCourseID.push(jArray[iLoop]['unitCode']);
            }
        }

        for (var iLoop = 0; iLoop < sameCourseID.length; ++iLoop) {
            document.getElementById(200+iLoop).innerHTML = sameCourseID[iLoop];
            document.getElementById(200+iLoop).style.display = "initial";
            if (iLoop >= 1) {
                document.getElementsByName(200+iLoop)[0].innerHTML = 'Remove';
                document.getElementsByName(200+iLoop)[0].style.display = "initial";
            }
        }

        for (var i = sameCourseID.length; i < 4; ++i) {
            document.getElementById(200+i).innerHTML = 'None';
            document.getElementsByName(200+i)[0].innerHTML = '';
            document.getElementsByName(200+i)[0].style.display = "none";
        }
    }

    function addCourse(addedCourse) {
        if(sameCourseID.length+1 <= 5) {
            var courseName = document.getElementById(addedCourse).innerHTML;
            sameCourseID.push(courseName);
            var indexSame = 0;
            //remove it from suggested
            for (var iLoop = 0; iLoop <= 4; ++iLoop) {
                if(document.getElementById(100+iLoop).innerHTML == courseName){
                    indexSame = iLoop;
                }
            }
            for (var iLoop = indexSame; iLoop < 4; ++iLoop) {
                document.getElementById(100+iLoop).innerHTML = document.getElementById(100+iLoop+1).innerHTML;
                if(document.getElementById(100+iLoop).innerHTML == "None"){
                    document.getElementsByName(100+iLoop)[0].innerHTML = '';
                    document.getElementsByName(100+iLoop)[0].style.display = "none";
                }
            }

            //add to associated
            for (var iLoop = 0; iLoop < 4; ++iLoop) {
                document.getElementById(200+iLoop).innerHTML = 'None';
                document.getElementsByName(200+iLoop)[0].innerHTML = '';
                document.getElementsByName(200+iLoop)[0].style.display = "none";
            }
            for (var iLoop = 0; iLoop < sameCourseID.length; ++iLoop) {
                document.getElementById(200+iLoop).innerHTML = sameCourseID[iLoop];
                document.getElementById(200+iLoop).style.display = "initial";
                if (iLoop >= 1) {
                    document.getElementsByName(200+iLoop)[0].innerHTML = 'Remove';
                    document.getElementsByName(200+iLoop)[0].style.display = "initial";
                }
            }
        }
        else{
            alert("No more courses can be associated with this course");
        }
    }

    function removeCourse(removedCourse) {
        var courseName = document.getElementById(removedCourse).innerHTML;
        var indexCourse = sameCourseID.indexOf(courseName);
        sameCourseID.splice(indexCourse, 1);

        var indexSame = 0;
        for (var iLoop = 0; iLoop <= 4; ++iLoop) {
            if(document.getElementById(200+iLoop).innerHTML == courseName){
                indexSame = iLoop;
            }
        }
        for (var iLoop = indexSame; iLoop < 4; ++iLoop) {
            document.getElementById(200+iLoop).innerHTML = document.getElementById(200+iLoop+1).innerHTML;
            if(document.getElementById(200+iLoop).innerHTML == "None"){
                document.getElementsByName(200+iLoop)[0].innerHTML = '';
                document.getElementsByName(200+iLoop)[0].style.display = "none";
            }
        }

        for (var iLoop = 0; iLoop <= 4; ++iLoop) {
            if(document.getElementById(100+iLoop).innerHTML == 'None'){
                document.getElementById(100+iLoop).innerHTML = courseName;
                document.getElementsByName(100+iLoop)[0].innerHTML = 'Add';
                document.getElementsByName(100+iLoop)[0].style.display = "initial";
                break;
            }
        }
    }

    //function when save is clicked
    function saveCourse() {
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
       // }
    }

    function saveCourseConfig() {
        var saveForm = document.getElementById("saveForm");
        saveForm.style.display = "block";
        saveForm.style.webkitFilter = "";
        document.getElementById("mainView").style.webkitFilter = "brightness(50%)blur(4px)grayscale(30%)";
    }

    function closeForm() {
        document.getElementById("saveForm").style.display = "none";
        document.getElementById("mainView").style.webkitFilter = "";
    }
    //for collapsable pane
    // var acc = document.getElementsByClassName("accordion");
    // var i;
    //
    // for (i = 0; i < acc.length; i++) {
    //     acc[i].addEventListener("click", function() {
    //         this.classList.toggle("active");
    //         var panel = this.nextElementSibling;
    //         if (panel.style.maxHeight) {
    //             panel.style.maxHeight = null;
    //         } else {
    //             panel.style.maxHeight = panel.scrollHeight + "px";
    //         }
    //     });
    // }

    //switch to main view
    function showMain() {
        window.location.href = "../Enrollments/EnrollmentMasterView.php";
    }

</script>

</html>