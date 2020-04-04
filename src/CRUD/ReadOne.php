<?php
session_start();
if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
    header ("Location: login.php");
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
        include 'database.php';
        $studentNo =isset($_GET['studentNo']) ? $_GET['studentNo']: die('Error: User not found.');
        try {
            $data = "SELECT * FROM enrollments WHERE studentNo = ?";
            $stmt = $dbh->prepare($data);
            $stmt->bindParam(1,$studentNo);
            $stmt->execute();
            $name ="";
            $surname="";
            $subjects ="";
            $unit = "";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $name = $row['name'];
                $surname = $row['surname'];
                $subjects .=",".$row['subject'];
                $session = $row['session'];
                $slot = $row['classSection'];
                $expiry = $row['expiryDate'];
                $unit .= ",".$row['unitCode'];
                $enrolled = $row['status'];
            }
            $subjects = substr($subjects,1);
            $unit = substr($unit,1);
            // store retrieved row to a variable
            // values to fill up our form
            //add for for other fields

        }catch (PDOException $exception){
            die('Error: ' .$exception->getMessage());
        }

        ?>

        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->
        <table id="table" class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Student Number</td>
                <td><?php echo htmlspecialchars($studentNo, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Name</td>
                <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Surname</td>
                <td><?php echo htmlspecialchars($surname, ENT_QUOTES);  ?></td>
            </tr>
            <!-- add more table records -->
            <tr>
                <td>Subjects</td>
                <td><?php echo htmlspecialchars($subjects, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Unit Code</td>
                <td><?php echo htmlspecialchars($unit, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Session</td>
                <td><?php echo htmlspecialchars($session, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Slot</td>
                <td><?php echo htmlspecialchars($slot, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Expiry Date</td>
                <td><?php echo htmlspecialchars($expiry, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td><?php echo htmlspecialchars($enrolled, ENT_QUOTES);  ?></td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <a href='Detail.php' class='btn btn-danger'>Back to Moodle users</a>
                </td>
            </tr>
        </table>

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