<?php
include 'Enrollments.php';
$enrollment = new Enrollments();

$action = isset($_GET['action']) ? $_GET['action'] : "";

// if it was redirected from deleteEnrollment.php
if ($action == 'deleted') {
    echo "<div class='alert alert-success' id='message'>Record was deleted.</div>";
}

// if it was redirected from createEnrollment.php
if ($action == 'deny') {
    echo "<div class='alert alert-success' id='message'>You don't have permission to edit the database.</div>";
}

if ($action == 'created') {
    echo "<div class='alert alert-success' id='message'>User record was created.</div>";
}


//filter displayed enrollments using drop down list of unit codes:
echo "Filter by unit code: ";
echo "<select id='ClassList' class='selectpicker list' name='ClassList' onChange='changeClasses()'>";
echo"<option selected='selected' name='All'>All</option>";
$enrollment->filterByUnitCode();

echo "</select>";
//end of select

//search for user
echo  "<div class='topnav'>
       <input class='form-control' id='searchBar' type='text' placeholder='Search for user...' onkeyup='findUser()'>
       <div class='createHold'><button class='btn btn-success' onclick='showCreate()'>Create New User</button></div>
       </div>";

//add create button
//echo "<div class='btnCreate'><button class='btn' onclick='showCreate()'>Create User</button></div>";

$enrollment->showAllEnrollments();
