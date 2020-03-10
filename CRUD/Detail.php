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
    </style>

</head>
<body>
    <!--Container-->
    <div class="container">
            <div class="page-header">
                <h1>Read Users</h1>
            </div>

    <!-- PHP code for read records here-->
        <?php
        // Add code to connect to database
        include 'database.php';
        //delete message prompt here

        //select all data from database
        $data = "SELECT * FROM COMS3Project ORDER BY studentNo DESC";
        $stmt = $connection->prepare($data);
        $stmt ->execute();

        $numrows = $stmt->rowCount();

        if ($numrows>0){
            //code to create database table
            echo "<table class='table table-hover table-responsive table-bordered'>";
            //start table
            //creating our table heading
            echo "<tr>";
            //add echos for table fields from database
                    echo "<th><!--Name of columns--></th>";

                echo "</tr>";
            echo "</table>";

            //add table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                //create new table row per record
                echo "<tr>";
                    echo "<td> </td>";
                    //add more columns for td

                echo "<td>";
                    // read one record for this user
                    //     echo "<a href='read_one.php?id={$id}' class='btn btn-info m-r-1em'>Read</a>";

                    // link for deleting this user
                    //    echo "<a href='#' onclick='delete_user({$id});'  class='btn btn-danger'>Delete</a>";
                     echo "</td>";
                echo "</tr>";
            }
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

</body>
</html>