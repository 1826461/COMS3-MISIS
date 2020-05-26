<?php
include 'Enrollments.php';
session_start();
if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
    header ("Location: index.php");
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>User Record</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <?php
            $studentNo =isset($_GET['studentNo']) ? $_GET['studentNo']: die('Error: User not found.');
              echo "<h1>Current User: {$studentNo}</h1>" ?>
        </div>

        <!-- PHP read one record will be here -->
        <?php
        $studentNo =isset($_GET['studentNo']) ? $_GET['studentNo']: die('Error: User not found.');

        $enroll = new Enrollments();
        $enroll->viewEnrollmentDetails($studentNo);
        ?>

        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->

    </div> <!-- end .container -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
    body{
        background-image: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
    }
    #table{
        background-color: white;
    }
</style>

</body>
</html>