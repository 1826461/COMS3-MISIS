<?php
include 'database.php';
$studentNo = isset($_GET['studentNo']) ? $_GET['studentNo'] : die('Error: User not found.');
try {
    $data = "SELECT * FROM enrollments WHERE studentNo = ?";
    $stmt = $dbh->prepare($data);
    $stmt->bindParam(1, $studentNo);
    $stmt->execute();
    $name = "";
    $surname = "";
    $subjects = "";
    $unit = "";
    $session = "";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $name = $row['name'];
        $surname = $row['surname'];
        $subjects .= "," . $row['subject'];
        $session .= "," . $row['session'];
        $slot = $row['classSection'];
        $expiry = $row['expiryDate'];
        $unit .= "," . $row['unitCode'];
        $enrolled = $row['status'];
    }
    $subjects = substr($subjects, 1);
    $unit = substr($unit, 1);
    $session = substr($session, 1);
    // store retrieved row to a variable
    // values to fill up our form
    //add for for other fields

} catch (PDOException $exception) {
    die('Error: ' . $exception->getMessage());
}

