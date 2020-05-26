<?php
session_start();
if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
    header ("Location: index.php");
}
$timeout = 3600; // Number of seconds until it times out.

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

if (isset($_POST["Logout"])) {
    session_start();
    $_SESSION = array();
    session_unset();
    session_destroy();
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Database</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <!-- custom css -->
    <link href="style.css" rel="stylesheet">
</head>

<body>
<!--main form-->
<div class="detail" method="post" id="mainView">

    <!--Container-->
    <div class="container">
        <div class="page-header">
            <h1>Moodle Users</h1>
        </div>
        <!--logout button-->
        <form class="logOut" method="post">
            <button type="submit" class="btn" name="Logout" id="exitButton" value="Logout"><span class="glyphicon glyphicon-log-out"></span>Log out</button>
        </form>
        <!-- PHP code for read records here-->
        <?php
        include 'viewAllEnrollments.php';
        ?>
    </div>


</div>


<div class="form-popup" id="deleteForm" method="post">
    <div class="form-container">
        <ul class="buttonGroup">
            <li><b>Are you sure you want to delete this user?</b></li>
            <li><button type="submit" class='btn btn-danger' onclick="deleteUser()">Delete</button></li>
            <li><button type="submit" id="close" class='btn btn-info' onclick="closeForm()">Cancel</button></li>
        </ul>
    </div>
</div>

<div class="create_pop" id="create">
    <div class="create-container">
        <h2>Create a new user:</h2>
        <div class="ulDiv">
            <ul class="createList">
                <li><input type="text" id="cNum" placeholder="Student Number"class="form-control"></li>
                <li><input type="text" id="cName" placeholder="Name"class="form-control"></li>
                <li><input type="text" id="sName" placeholder="Surname"class="form-control"></li>
                <li><input type="text" id="sub" placeholder="Subject"class="form-control"></li>
                <li><input type="text" id="cod" placeholder="Unit Code"class="form-control"></li>
                <li>Select a session:</li>
                <li><select class="selectpicker" type="text" id="session">
                        <option value="SM1">SM1</option>
                        <option value="SM2">SM2</option>
                        <option value="FYR">FYR</option>
                    </select></li>
                <li>Select a slot:</li>
                <li><select class="selectpicker" type="text" id="slot">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                    </select></li>
                <li>Expiry Date:</li>
                <li><div class='input-group date' id='datetimepicker1'>
                        <input type='text' id="time" class="form-control" placeholder="Expiry Date" />
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div></li>
                <div class="createButtons"><li><button type="submit" class='btn btn-success' onclick="createUser()">Create New User</button></li>
                    <li><button type="submit" id="close" class='btn btn-info' onclick="closeCreate()">Cancel</button></li></div>
            </ul>
        </div>
    </div>
</div>


</body>

<!--javascript code -->
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

<script>
    //hide records that dont have class value
    var deleteStudentNumber;
    var delSub;

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
                var td = tr[i].getElementsByTagName("td")[4]; //gets unit code
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


    function showDelete(studentNumber){
        //passing student number works
        //show delete popup menu
        var delForm = document.getElementById("deleteForm");
        delForm.style.display="block";
        //hide table and make it un-editable
        document.getElementById("mainView").style.webkitFilter="brightness(50%)blur(4px)grayscale(30%)";
        deleteStudentNumber = studentNumber[0];
        delSub = studentNumber[1];
    }

    function deleteUser() {
        //string here is fine
        var user= deleteStudentNumber;
        var sub = delSub;
        window.location.href = 'deleteEnrollment.php?studentNo=' + user+ '&subject='+sub;
    }

    function closeForm(){
        document.getElementById("deleteForm").style.display="none";
        document.getElementById("mainView").style.webkitFilter="";
    }

    function closeCreate(){
        document.getElementById("create").style.display="none";
        document.getElementById("mainView").style.webkitFilter="";
    }

    function findUser() {
        var element = document.getElementById("searchBar").value.toUpperCase();
        var table = document.getElementById("tableData");
        var tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            a = tr[i].getElementsByTagName("td")[0];
            b  = tr[i].getElementsByTagName("td")[1];
            c = tr[i].getElementsByTagName("td")[2];
            txtValue1 = a.textContent || a.innerText;
            txtValue2 = b.textContent || b.innerText;
            txtValue3 = c.textContent || c.innerText;
            if (txtValue1.indexOf(element) > -1||txtValue2.toUpperCase().indexOf(element) > -1||txtValue3.toUpperCase().indexOf(element) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    function showCreate() {
        var createForm = document.getElementById("create");
        createForm.style.display="block";
        //hide table and make it un-editable
        document.getElementById("mainView").style.webkitFilter="brightness(50%)blur(4px)grayscale(30%)";
        document.getElementById("cNum").focus();
    }

    function isBlank(){
        var student = document.getElementById("cNum").value;
        var name = document.getElementById("cName").value;
        var sur =  document.getElementById("sName").value;
        var sub = document.getElementById("sub").value ;
        var cod = document.getElementById("cod").value ;

        if(isNaN(student)){
            document.getElementById("cNum").focus();
            return [true,"Please insert a valid student number."];
        }

        if(student==""){document.getElementById("cNum").focus(); return [true,"Please insert a student number."];}
        if(name==""){document.getElementById("cName").focus(); return[true,"Please insert a name."];}
        if(sur==""){document.getElementById("sName").focus(); return[true,"Please insert a surname."];}
        if(sub==""){document.getElementById("sub").focus(); return[true,"Please insert a subject."];}
        if(cod==""){document.getElementById("cod").focus(); return[true,"Please insert a unit code."];}

        return [false,"none"];
    }
    function createUser() {
        if (isBlank()[0]){
            var msg = isBlank()[1];
            alert(msg);
        }else{
            var student = 'studentNo=' + document.getElementById("cNum").value + '&';
            var name = 'name=' + document.getElementById("cName").value + '&';
            var sur = 'surname=' + document.getElementById("sName").value + '&';
            var sub = 'subject=' + document.getElementById("sub").value + '&';
            var cod = 'code=' + document.getElementById("cod").value + '&';
            var session = 'session=' + document.getElementById("session").value + '&';
            var slot = 'slot=' + document.getElementById("slot").value + '&';
            var time = 'time=' + document.getElementById("time").value;

            //send to php create script
            var statement = 'createEnrollment.php?'+student+name+sur+sub+cod+session+slot+time;
            window.location.href = statement;
        }
    }

    $(function () {
        $('#datetimepicker1').datetimepicker({
            defaultDate: new Date(),
            format: 'YYYY-MM-DD HH:mm:ss',
            sideBySide: true
        });
    });

    setTimeout(function() {
        $('#message').fadeOut('fast');
    }, 5000); // <-- time in milliseconds


</script>


</html>