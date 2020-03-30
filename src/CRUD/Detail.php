<?php
session_start();
if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
    header ("Location: login.php");
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
    header("Location: login.php");
}

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
        .m-r-2em{background-color: blue}
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
            right: 16%;
            top: 50px;
        }
        .form-popup{
            display: none;
            width: 350px;
            border: 3px solid #f1f1f1;
            position: fixed;
            left: 40%;
            top: 30%;
        }
        .form-container{
            margin: auto;
            padding:20px;
            height:200px;
            background-color: white;
        }
        ul.buttonGroup{
            list-style: none;
            text-align: center;
        }
        ul.buttonGroup li{
            width: 250px;
            padding: 5px;
        }
        #ClassList{
            margin-top: 5px;
        }
        .scrollit {
            overflow:auto;
            overflow-x: hidden;
            height:700px;
            margin-top: 10px;
        }
        #searchBar{
            background-image: url('https://img.icons8.com/color/search'); /* Add a search icon to input */
            background-size: 30px 30px;
            background-position: 1px 2px; /* Position the search icon */
            height: 40px;
            padding: 12px 20px 12px 40px;
            background-repeat: no-repeat; /* Do not repeat the icon image */
            font-size: 16px; /* Increase font-size */
            border: 1px solid #ddd; /* Add a grey border */
        }
        .topnav{
            list-style: none;
            overflow: hidden;
            float: right;
        }

    </style>
</head>

<!--javascript code -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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


    function showDelete(studentNumber){
        //passing student number works
        //show delete popup menu
        var delForm = document.getElementById("deleteForm");
        delForm.style.display="block";
        //hide table and make it un-editable
        document.getElementById("mainView").style.webkitFilter="blur(4px)grayscale(30%)";
        document.getElementById("exitButton").style.webkitFilter="blur(4px)grayscale(30%)";
        deleteStudentNumber = studentNumber[0];
        delSub = studentNumber[1];
    }

    function deleteUser() {
        //string here is fine
        var user= deleteStudentNumber;
        var sub = delSub;
        window.location.href = 'deleteUser.php?studentNo=' + user+ '&subject='+sub;
    }

    function closeForm(){
        document.getElementById("deleteForm").style.display="none";
        document.getElementById("mainView").style.webkitFilter="";
        document.getElementById("exitButton").style.webkitFilter="";
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


</script>

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
            <input type="submit" class="btn" name="Logout" id="exitButton" value="Logout">
        </form>
    <!-- PHP code for read records here-->
        <?php
        include 'readRecords.php';
        ?>
    </div>

    <!--confirm delete record here-->

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


</body>

</html>