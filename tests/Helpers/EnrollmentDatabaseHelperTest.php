<?php

use Helpers\DatabaseHelper;
use Helpers\EnrollmentDatabaseHelper;
use PHPUnit\Framework\TestCase;
use Objects\Enrollment;
use function PHPUnit\Framework\assertEquals;

class EnrollmentDatabaseHelperTest extends TestCase
{

    public function testGetCourseListEmpty() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        assertEquals($enrollmentDatabaseHelper->getCourseList(), 0, "Course count zero");
    }

    public function testGetAllCourseEnrollmentsEmpty() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        assertEquals($enrollmentDatabaseHelper->getAllCourseEnrollments("Test"), 0, "Course enrollments zero");
    }

    public static function testGetCourseEnrollmentsCountEmpty() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();

        assertEquals($enrollmentDatabaseHelper->getCourseEnrollmentsCount("Test"), 0, "Course enrollments zero");
    }

    public static function testgetEnrollmentDoesNotExist() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        assertEquals($enrollmentDatabaseHelper->getEnrollment(1, "Test"), 0, "Course enrollments zero");
    }

    public function testInsertEnrollment() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $enrollment = new Enrollment(0, 1826461, "Tristen", "Paul", "COMS", "COMS3006A",
            "SM1", "A", "2020-06-30 00:00:00", "ENROLLED");
        $result = $enrollmentDatabaseHelper->insertEnrollment($enrollment);
        assertEquals(1, $result, "Enrollment added to database table");
    }

    public function testInsertEnrollmentExists() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $enrollment = new Enrollment(0, 1826461, "Tristen", "Paul", "COMS", "COMS3006A",
            "SM1", "A", "2020-06-30 00:00:00", "ENROLLED");
        $result = $enrollmentDatabaseHelper->insertEnrollment($enrollment);
        assertEquals(0, $result, "Enrollment added to database table");
    }

    public function testInsertUniqueEnrollment() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $enrollment = new Enrollment(0, 1826461, "Tristen", "Paul", "COMS2", "COMS3000A",
            "SM1", "A", "2020-06-30 00:00:00", "ENROLLED");
        $result = $enrollmentDatabaseHelper->insertUniqueEnrollment($enrollment);
        assertEquals(1, $result, "Enrollment added to database table");
    }

    public function testInsertUniqueEnrollmentExists() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $enrollment = new Enrollment(0, 1826461, "Tristen", "Paul", "COMS2", "COMS3000A",
            "SM1", "A", "2020-06-30 00:00:00", "ENROLLED");
        $result = $enrollmentDatabaseHelper->insertUniqueEnrollment($enrollment);
        assertEquals(0, $result, "Enrollment added to database table");
        $enrollmentDatabaseHelper->deleteEnrollment(1826461, "COMS3000A");
    }

    public function testUpdateEnrollment() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $enrollment = $enrollmentDatabaseHelper->getEnrollment(1826461, "COMS3006A");
        $enrollment->setName("Tristan");
        $enrollment->setSession("SM2");
        $enrollment->setClassSection("B");
        $enrollmentDatabaseHelper->updateEnrollment($enrollment);
        $result = $enrollmentDatabaseHelper->getEnrollment(1826461, 'COMS3006A');
        assertEquals("Tristan", $result->getName(), "Correct name returned");
        assertEquals("SM2", $result->getSession(), "Correct session returned");
        assertEquals("B", $result->getClassSection(), "Correct class section returned");
    }


    public function testGetEnrollment() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $result = $enrollmentDatabaseHelper->getEnrollment(1826461, 'COMS3006A');
        assertEquals(1826461, $result->getStudentNo(), "Correct student number returned");
        assertEquals("Tristan", $result->getName(), "Correct name returned");
        assertEquals("Paul", $result->getSurname(), "Correct surname returned");
        assertEquals("COMS", $result->getSubject(), "Correct subject returned");
        assertEquals("COMS3006A", $result->getUnitCode(), "Correct unit code returned");
        assertEquals("SM2", $result->getSession(), "Correct session returned");
        assertEquals("B", $result->getClassSection(), "Correct class section returned");
        assertEquals("2020-06-30 00:00:00", $result->getExpiryDate(), "Correct expiry date returned");
        assertEquals("ENROLLED", $result->getStatus(), "Correct status returned");
    }

    public function testDeleteEnrollment() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $enrollmentDatabaseHelper->deleteEnrollment(1826461, 'COMS3006A');
        assertEquals(1, 1, "Enrollment added to database table");
    }

    public function testDeleteALlCourseEnrollmentsWithID() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $enrollment = new Enrollment(0, 1826461, "Tristentest", "Paul", "COMS", "TEST1000A",
            "SM1", "A", "2020-06-30 00:00:00", "ENROLLED");
        $enrollment->setCourseID(100);
        $enrollmentDatabaseHelper->deleteAllCourseEnrollmentsWithID(100);
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("SELECT * FROM enrollments WHERE courseID = 100");
        assertEquals(0, $databaseHelper->rowCount(), "Enrollments removed from database table");
    }

    public function testDeleteAllCourseEnrollments() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $enrollment = new Enrollment(0, 1826461, "Tristen", "Paul", "COMS", "COMS4000A",
            "SM1", "A", "2020-06-30 00:00:00", "ENROLLED");
        $enrollmentDatabaseHelper->insertEnrollment($enrollment);
        $enrollment = new Enrollment(0, 1826423, "John", "Paul", "COMS", "COMS4000A",
            "SM1", "A", "2020-06-30 00:00:00", "ENROLLED");
        $enrollmentDatabaseHelper->insertEnrollment($enrollment);
        $enrollmentDatabaseHelper->deleteAllCourseEnrollments('COMS4000A');
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("SELECT * FROM enrollments WHERE unitCode = :unitCode");
        assertEquals(0, $databaseHelper->rowCount(), "Enrollments removed from database table");
    }

    public function testGetAllEnrollmentsEqualsZero() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        assertEquals($counterBeforeInsert = $enrollmentDatabaseHelper->getAllEnrollments(),0, "no enrollments ");
    }

    public function testGetAllEnrollments() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $enrollment = new Enrollment(0, 1826465, "Trist", "Pau", "COMS", "COMS4000A",
            "SM1", "A", "2020-06-30 00:00:00", "ENROLLED");
        $enrollmentDatabaseHelper->insertEnrollment($enrollment);
        $counterBeforeInsert = sizeof($enrollmentDatabaseHelper->getAllEnrollments());
        $enrollment = new Enrollment(0, 1826461, "Tristen", "Paul", "COMS", "COMS4000A",
            "SM1", "A", "2020-06-30 00:00:00", "ENROLLED");
        $enrollmentDatabaseHelper->insertEnrollment($enrollment);
        $counterAfterInsert = sizeof($enrollmentDatabaseHelper->getAllEnrollments());
        assertEquals($counterAfterInsert, $counterBeforeInsert + 1, "Enrollments count increased by one");
        $enrollmentDatabaseHelper->deleteEnrollment(1826461, "COMS4000A");

    }

    public function testGetCourseList() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $counterBeforeInsert = sizeof($enrollmentDatabaseHelper->getCourseList());
        $enrollment = new Enrollment(0, 1826461, "Tristen", "Paul", "COMS", "TEST",
            "SM1", "A", "2020-06-30 00:00:00", "ENROLLED");
        $enrollmentDatabaseHelper->insertEnrollment($enrollment);
        $counterAfterInsert = sizeof($enrollmentDatabaseHelper->getCourseList());
        assertEquals($counterAfterInsert, $counterBeforeInsert + 1, "Course count increased by one");
        $enrollmentDatabaseHelper->deleteEnrollment(1826465, "COMS4000A");
    }

    public function testGetCourseEnrollmentsCount() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        assertEquals(sizeof($enrollmentDatabaseHelper->getAllCourseEnrollments("TEST")), $enrollmentDatabaseHelper->getCourseEnrollmentsCount("TEST"), "Course enrollment count is expected value");

    }

    public function testUpdateEnrollmentWhenCourseChange() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $enrollmentDatabaseHelper->updateEnrollmentWhenCourseChange("TEST", 1);
        assertEquals($enrollmentDatabaseHelper->getEnrollment(1826461, "TEST")->getCourseID(), 1, "Course ID equals expected value");
        $enrollmentDatabaseHelper->deleteEnrollment(1826461, "TEST");
    }

}
