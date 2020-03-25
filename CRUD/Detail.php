<?php
session_start();
if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
    header ("Location: login.php");
}
$timeout = 600; // Number of seconds until it times out.

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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Database</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

    <!-- custom css -->
    <style>
        .m-r-1em{ margin-right:1em; }
        .m-b-1em{ margin-bottom:1em; }
        .m-l-1em{ margin-left:1em; }
        .mt0{ margin-top:0; }
        .list{ padding: 5px;width: 150px; margin-bottom: 10px;}
        body{
            background-image: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
        }
        #tableData{
            background-color: white;
        }
        .logOut{
            position: absolute;
            right: 15%;
            padding-top: 50px;
        }
    </style>

</head>
<body>
<div class="content">
<form class="detail" method="post">
    <!--Container-->
    <div class="container">
            <div class="logOut">
                <input type="submit" name="Logout" id="exitButton" value="Logout"></input>
                <?php
                if(isset($_POST["Logout"])) {
                    session_start();
                    unset($_SESSION["loggedin"]);
                    unset($_SESSION["username"]);
                    header("Location:login.php");
                }
                ?>
            </div>
            <div class="page-header">
                <h1>Moodle Users</h1>
            </div>

        <script>
        //hide records that dont have class value
            function changeClasses() {
                var element = document.getElementById("ClassList").value;
                var table = document.getElementById("tableData");
                var tr = table.getElementsByTagName("tr");
                if (element=='All'){
                    for (var i =0;i<tr.length;i++){
                        tr[i].style.display="";
                    }
                }else{
                    for (var i =0;i<tr.length;i++){
                        var td = tr[i].getElementsByTagName("td")[3]; //gets subject
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
            
        </script>

    <!-- PHP code for read records here-->
        <?php
        // Add code to connect to database
        include 'database.php';
        //delete message prompt here

        //populate select
        echo "Subjects: ";
        echo "<select id='ClassList' class='list' name='ClassList' onChange='changeClasses()'>";
        echo"<option selected='selected' name='All'>All</option>";
        $querySubjects = "SELECT DISTINCT subject FROM users";
        $stmt = $dbh->prepare($querySubjects); //issue
        $stmt ->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $item = $row['subject'];
            echo"<option name='$item' value=$item>'$item'</option>";
        }
        echo "</select>";
       //end of select

        $data = "SELECT * FROM users";
        $stmt = $dbh->prepare($data); //issue
        $stmt ->execute();
        $numRows = $stmt->rowCount();

        if ($numRows>0){
            //code to create database table
            echo "<table id='tableData' class='table table-hover table-responsive table-bordered'>";
            //start table
            //creating our table heading
            echo "<tr>";
            //add echos for table fields from database
            echo "<th>Student Number</th>";
            echo "<th>Name</th>";
            echo "<th>Surname</th>";
            echo "<td>Subject</td>";
            echo "<td>Expiry Date</td>";
            echo "</tr>";


            //add table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                //create new table row per record
                echo "<tr>";
                echo "<td>{$row['studentNo']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['surname']}</td>";
                echo "<td>{$row['subject']}</td>";
                echo "<td>{$row['expiryDate']}</td>";

                //add more columns for td
                echo "<td>";
                // read one record for this user
                echo "<a href='ReadOne.php?studentNo={$row['studentNo']}' class='btn btn-info m-r-1em'>Read</a>";

                // link for deleting this user
                echo "<a href='#' onclick='delete_user({$row['studentNo']});'  class='btn btn-danger'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";

        }else{
            echo "<div class='alert alert-danger'>No records found.</div>";
        }

        //link to create record form
        //echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";
        ?>

    </div> <!-- end of container-->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- confirm delete record will be here -->
</form>
</div>
</body>

</html>