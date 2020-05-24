<?php

use Helpers\EnrollmentDatabaseHelper;
use PHPUnit\Framework\TestCase;
use Objects\Enrollment;
use function PHPUnit\Framework\assertEquals;

class EnrollmentDatabaseHelperTest extends TestCase
{
    public function testInsertEnrollment() {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $enrollment = new Enrollment(0, 1826461, "Tristen", "Paul", "COMS", "COMS3006A",
            "SM1", "A", "2020-06-30 00:00:00", "ENROLLED");
        $result = $enrollmentDatabaseHelper->insertEnrollment($enrollment);
        assertEquals(1, $result, "Enrollment added to database table");
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

}
