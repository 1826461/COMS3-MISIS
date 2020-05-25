<?php
session_start();
if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
    header("Location: index.php");
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Edit User</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
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

</head>
<body>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <?php
            $studentNo =isset($_GET['studentNo']) ? $_GET['studentNo']: die('Error: User not found.');
            $code = isset($_GET['unitCode']) ? $_GET['unitCode']: die('Error: Unit code not found.');

            echo "<h1>Edit User: {$studentNo}</h1>";
            echo "<h1>Unit: {$code}</h1>";
            ?>
        </div>

        <!-- PHP read one record will be here -->
        <?php
            include 'database.php';
            $studentNo = isset($_GET['studentNo']) ? $_GET['studentNo'] : die('Error: User not found.');
            $code = isset($_GET['unitCode']) ? $_GET['unitCode']: die('Error: Unit code not found.');

        try {
                $data = "SELECT * FROM enrollments WHERE studentNo = ? AND unitCode = ?";
                $stmt = $dbh->prepare($data);
                $stmt->bindParam(1, $studentNo);
                $stmt->bindParam(2, $code);
                $stmt->execute();
                $name = "";
                $surname = "";
                $subjects = "";
                $unit = "";
                $session = "";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $name = $row['name'];
                    $surname = $row['surname'];
                    $slot = $row['classSection'];
                    $expiry = $row['expiryDate'];
                    $enrolled = $row['status'];
                }
                // store retrieved row to a variable
                // values to fill up our form
                //add for for other fields

            } catch (PDOException $exception) {
                die('Error: ' . $exception->getMessage());
            }
        ?>

        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->
        <table id="table" class='table table-hover table-responsive '>
            <tr>
                <td>Name</td>

                <td><input id="name" class="form-control" type="text" value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>"></input></td>
            </tr>
            <tr>
                <td>Surname</td>
                <td><input id="surname" class="form-control" type="text" value="<?php echo htmlspecialchars($surname, ENT_QUOTES);  ?>"></input></td>
            </tr>
            <tr>
                <td>Slot</td>
                <td>
                    <?php
                   // echo $code;
                      switch ($slot){
                            case 'A': echo '<select class="selectpicker" id="slots"">
                                                <option value="A" selected>A</option>
                                                <option value="B" >B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                 </select>';
                                    break;
                            case 'B': echo '<select class="selectpicker" id="slots">
                                                <option value="A">A</option>
                                                <option value="B" selected>B</option>
                                                <option value="C" >C</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                 </select>';
                                break;
                            case 'C': echo '<select class="selectpicker" id="slots">
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C" selected>C</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                 </select>';
                                break;
                            case 'D': echo '<select class="selectpicker" id="slots">
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D" selected>D</option>
                                                <option value="E">E</option>
                                                 </select>';
                                break;
                            case 'E': echo '<select class="selectpicker" id="slots">
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="E" selected>E</option>
                                                 </select>';
                                break;
                        }
                        
                    ?>

            </tr>
            <tr>
                <td>Expiry Date</td>
                <td><div class='input-group date' id='datetimepicker1'>
                        <input type='text' id="time" class="form-control" value="<?php echo htmlspecialchars($expiry, ENT_QUOTES);  ?>" />
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    <?php
                    switch ($enrolled){
                        case 'ENROLLED': echo '<select class="selectpicker" id="status">
                                                    <option value="ENROLLED" selected>ENROLLED</option>
                                                    <option value="UNENROLLED">UN-ENROLLLED</option></option>
                                               </select>';
                                               break;
                        case 'UNENROLLED': echo '<select class="selectpicker" id="status">
                                                    <option value="ENROLLED">ENROLLED</option>
                                                    <option value="UN-ENROLLED" selected>UN-ENROLLLED</option></option>
                                               </select>';
                            break;
                    }
                    
                    ?>
                    
                    </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <button type="submit" onclick="doUpdate()" class="btn btn-primary">Update record</button>
                    <a href='Detail.php' class='btn btn-danger'>Back to Moodle users</a>
                </td>
            </tr>
        </table>


    </div> <!-- end .container -->

<style>
    body{
        background-image: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
    }
    #table{
        background-color: white;
    }
</style>

    <script>
        var sNum;
        var sCode;

        function setValues(){
            sNum= <?php echo(json_encode($studentNo))?>;
            sCode = <?php echo(json_encode($code))?>;
        }

        $(function () {
            $('#datetimepicker1').datetimepicker({
                defaultDate: new Date(),
                format: 'YYYY-MM-DD HH:mm:ss',
                sideBySide: true
            });
        });

        function doUpdate() {
            setValues();
            var student = 'studentNo=' + sNum + '&';
            var cod = 'code=' +sCode + '&';
            var name = 'name=' + document.getElementById("name").value + '&';
            var sur = 'surname=' + document.getElementById("surname").value + '&';
            var slot = 'slot=' + document.getElementById("slots").value + '&';
            var time = 'time=' + document.getElementById("time").value +'&';
            var expiry = 'enrolled=' + document.getElementById('status').value;

            //send to php edit script
            var statement = 'update.php?'+student+name+sur+cod+slot+time+expiry;
          //  alert(statement);
            window.location.href = statement;
        }
    </script>

</body>
</html>