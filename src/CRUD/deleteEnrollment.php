<?php
include 'Enrollments.php';
$enroll = new Enrollments();

session_start();

$studentNo =isset($_GET['studentNo']) ? $_GET['studentNo']: die('Error: User not found.');
$subject =isset($_GET['subject']) ? $_GET['subject']: die('Error: Subject not found.');

$enroll->deleteEnrollment($studentNo, $subject);