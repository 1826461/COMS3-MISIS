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
            <h1>Read User</h1>
        </div>

        <!-- PHP read one record will be here -->
        <?php
        $studentNo =isset($_GET['studentNo']) ? $_GET['studentNo']: die('Error: User not found.');

        include 'database.php';
        try {
            $data = "SELECT * FROM COMS3Project WHERE studentNo = ? LIMIT 0,1";
            $stmt = $connection->prepare($data);
            $stmt->bindParam(1,$studentNo);
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $name = $row['name'];
            $surname = $row['surname'];
            //add for for other fields

        }catch (PDOException $exception){
            die('Error: ' .$exception->getMessage());
        }

        ?>

        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->
        <table class='table table-hover table-responsive table-bordered'>
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
                <td><!--etc--></td>
<!--                <td>--><?php //echo htmlspecialchars($, ENT_QUOTES);  ?><!--</td>-->
            </tr>

            <tr>
                <td></td>
                <td>
                    <a href='Detail.php' class='btn btn-danger'>Back to read products</a>
                </td>
            </tr>
        </table>

    </div> <!-- end .container -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</body>
</html>