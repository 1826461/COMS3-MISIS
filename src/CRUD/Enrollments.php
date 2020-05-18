<?php

class Enrollments
{
    private $results = array();

    public function viewEnrollmentDetails($studentNo)
    {
        include 'database.php';
        try {
            $data = "SELECT * FROM enrollments WHERE studentNo = ?";
            $stmt = $dbh->prepare($data);
            $stmt->bindParam(1, $studentNo);
            $stmt->execute();

            $this->results = $stmt->fetchAll();
            foreach($this->results as $row) {
                echo "<table id=\"table\" class='table table-hover table-responsive table-bordered'>";

                //student number:
                echo "<tr>";
                echo "<td>Student Number</td>";
                echo "<td>{$row['studentNo']}</td>";
                echo "</tr>";
                //name
                echo "<tr>";
                echo "<td>Name</td>";
                echo "<td>{$row['name']}</td>";
                echo "</tr>";
                //surname
                echo "<tr>";
                echo "<td>Surname</td>";
                echo "<td>{$row['surname']}</td>";
                echo "</tr>";
                //subjects
                echo "<tr>";
                echo "<td>Subject(s)</td>";
                echo "<td>{$row['subject']}</td>";
                echo "</tr>";
                //unit codes
                echo "<td>Unit Code(s)</td>";
                echo "<td>{$row['unitCode']}</td>";
                echo "</tr>";
                //sessions
                echo "<td>Session(s)</td>";
                echo "<td>{$row['session']}</td>";
                echo "</tr>";
                //expiry date
                echo "<td>Expiry Date</td>";
                echo "<td>{$row['expiryDate']}</td>";
                echo "</tr>";
                //status
                echo "<td>Status</td>";
                echo "<td>{$row['status']}</td>";
                echo "</tr>";

                //back to Moodle button
                echo "<tr>";
                    echo "<td></td>";
                    echo "<td>";
                        echo "<a href='enrollmentsDetails.php' class='btn btn-danger'>Back to Moodle users</a>";
                    echo "</td>";
                echo "</tr>";

                echo "</table>";
            }

        }catch (PDOException $exception){
            die('Error: ' .$exception->getMessage());
        }

    }

    public function getEnrollments()
    {
        include "database.php";
        $data = "SELECT * FROM enrollments";
        $stmt = $dbh->prepare($data);
        $stmt ->execute();
        $numRows = $stmt->rowCount();

        if ($numRows>0){
            $this->results = $stmt->fetchAll();
        }else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
    }

    public function showAllEnrollments() {
        $this->getEnrollments();

        echo"<div class='scrollit'>";
        echo "<table id='tableData' class='table table-hover table-responsive table-bordered'>";
        //start table
        //creating our table heading
        echo "<tr>";
        //add echos for table fields from database
        echo "<th>Student Number</th>";
        echo "<th>Name</th>";
        echo "<th>Surname</th>";
        echo "<th>Subject</th>";
        echo "<th>Unit Code</th>";
        echo "<th>Session</th>";
        echo "<th>Expiry Date</th>";
        echo "</tr>";

        //add table contents
        foreach($this->results as $row) {
            echo "<tr>";
            echo "<td>{$row['studentNo']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['surname']}</td>";
            echo "<td>{$row['subject']}</td>";
            echo "<td>{$row['unitCode']}</td>";
            echo "<td>{$row['session']}</td>";
            echo "<td>{$row['expiryDate']}</td>";
            //echo "</tr>";
            //mod from here
            $user = $row['studentNo'];
            $sub = $row['subject'];
            $arr = array($user,$sub);
            $sendVar = json_encode($arr);
            //issue in returning 2 variables to javascript

            //add more columns for td
            echo "<td>";
            // read one record for this user
            echo "<a href='viewOneEnrollment.php?studentNo={$row['studentNo']}' class='btn btn-info m-r-1em'>View</a>";
            //edit user
            if ($_SESSION['admin']==1) {
                //TODO implement button functionality
                //echo "<a class='btn btn-warning'>Edit</a>";
                //href='editUser.php?studentNo={$row['studentNo']}'

                // link for deleting this user
                echo "<a onclick='showDelete({$sendVar});' class='btn btn-danger  m-l-1em'>Delete</a>";
            }

            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }

    public function filterByUnitCode()
    {
        include "database.php";

        $querySubjects = "SELECT DISTINCT unitCode FROM enrollments";
        $stmt = $dbh->prepare($querySubjects); //issue
        $stmt ->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $item = $row['unitCode'];
            echo"<option name='$item' value=$item>'$item'</option>";
        }

        echo "</select>";

    }

    public function createEnrollment($studentNo,$name,$surname,$subject,$code,$session,$slot,$time,$enrolled)
    {
        include "database.php";
        try {
            $data = "INSERT INTO enrollments(studentNo,name,surname,subject,unitCode,session,classSection,expiryDate,status) VALUES(:num,:nam,:surname,:subject,:code,:sess,:sec,:tim,:en)";
            $stmt = $dbh->prepare($data);

            $stmt->bindParam(":num",$studentNo);
            $stmt->bindParam(":nam",$name);
            $stmt->bindParam(":surname",$surname);
            $stmt->bindParam(":subject",$subject);
            $stmt->bindParam(":code",$code);
            $stmt->bindParam(":sess",$session);
            $stmt->bindParam(":sec",$slot);
            $stmt->bindParam(":tim",$time);
            $stmt->bindParam(":en",$enrolled);

            if ($_SESSION['admin']==1){
                if($stmt->execute()){
                    echo header('Location: enrollmentsDetails.php?action=created');
                }
                else{
                    die('Unable to create record.');
                }
            }else{
                header('Location: enrollmentsDetails.php?action=deny');
            }

        }
        catch (PDOException $exception) {
            die('Error: ' . $exception->getMessage());
        }

    }

    public function deleteEnrollment($studentNo, $subject)
    {
        include "database.php";
        try{
            $query='DELETE FROM enrollments WHERE studentNo = :num AND subject= :sub';
            $stmt = $dbh->prepare($query);
            $stmt->bindValue(":num", $studentNo);
            $stmt->bindParam(":sub",$subject);

            if ($_SESSION['admin']==1){
                if($stmt->execute()){
                    header('Location: enrollmentsDetails.php?action=deleted');
                }else{
                    die('Unable to delete record.');
                }
            }else{
                header('Location: enrollmentsDetails.php?action=deny');
            }

        }catch (PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
    }

}
?>