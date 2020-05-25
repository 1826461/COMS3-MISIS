<?php
include 'Enrollments.php';
session_start();
$enroll = new Enrollments();

$studentNo = isset($_GET['studentNo']) ? $_GET['studentNo']: die('Error: Username not found.');
$name = isset($_GET['name']) ? $_GET['name']: die('Error: Name not found');
$surname = isset($_GET['surname']) ? $_GET['surname']: die('Error: Surname not found.');
$subject = isset($_GET['subject']) ? $_GET['subject']: die('Error: Subject not found.');
$code = isset($_GET['code']) ? $_GET['code']: die('Error: Unit code not found.');
$session = isset($_GET['session']) ? $_GET['session']: die('Error: Session not found.');
$slot = isset($_GET['slot']) ? $_GET['slot']: die('Error: Slot not found.');
$time = isset($_GET['time']) ? $_GET['time']: die('Error: Time not found.');
$enrolled = "ENROLLED";

$enroll->createEnrollment($studentNo,$name,$surname,$subject,$code,$session,$slot,$time,$enrolled);
