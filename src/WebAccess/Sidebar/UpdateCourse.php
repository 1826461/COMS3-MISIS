<?php

use Helpers\CourseDatabaseHelper;
use Helpers\EnrollmentDatabaseHelper;
use Helpers\MoodleCourseCategoriesDatabaseHelper;
use Helpers\MoodleCourseDatabaseHelper;

include("..\..\Helpers\DatabaseHelper.php");
include("..\..\Helpers\MoodleCourseCategoriesDatabaseHelper.php");
include("..\..\Helpers\MoodleCourseDatabaseHelper.php");


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
            <h1>Update Courses Master</h1>
        </div>
        <!--logout button-->
        <form class="logOut" method="post">
            <button type="submit" class="btn" name="Logout" id="exitButton" value="Logout"><span
                    class="glyphicon glyphicon-log-out"></span>Log out
            </button>
        </form>
        <div class="collapseButtons">
            <button class='btn btn-primary' onclick='showMain()'>Switch to Main view</button>
        </div>
    </div>

    <!-- Side navigation -->
    <div class="sidenav">
    <?php

        //get all courses and make them into an a clickable object eg. echo "<a>Button</a>";
        //create helper object
        $allCategoryObject = new MoodleCourseDatabaseHelper();
        $moodleCategoryHelper = new MoodleCourseCategoriesDatabaseHelper();
        $categories = $moodleCategoryHelper->getAllMoodleCourseCategories();

        $numCategories = sizeof($categories);
        for ($i =0;$i<$numCategories;$i++){
            echo "<div class='categoryButtons'>";
            echo "<button type=\"button\" class=\" btn btn-danger collapsible\">{$categories[$i]['name']}</button>";
            echo "<div class=\"content\">";

            //get each course associated to this category
            $courses = $allCategoryObject->getAllMoodleCoursesByCategory($categories[$i]['id']);

//            echo '<script>';
//            echo 'console.log('. json_encode($courses, JSON_HEX_TAG) .')';
//            echo '</script>';

            if($courses != 0){
                $numSubjects = sizeof($courses);
                for ($k=0;$k<$numSubjects;$k++){
                    echo "<a href='#'>{$courses[$k]['shortname']}</a>";
                }
            }else{
                echo "<a>None</a>";
            }

            echo "</div>";
            echo "</div>";
            }
    ?>
    </div>

</div>
</body>

<script>
    //for collapsable pane
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }

    function showMain() {
        window.location.href = "../Enrollments/EnrollmentMasterView.php";
    }

</script>

</html>