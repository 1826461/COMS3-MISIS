<?php

use Objects\Enrollment;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class EnrollmentTest extends TestCase
{
    private static Enrollment $enrollment;

    public function testEnrollmentConstructor() {
        self::$enrollment = new Enrollment(1, 1826461, "Tristen", "Paul", "COMS",
            "COMS3007A", "SM1", "A", "2020-06-30 00:00:00", "ENROLLED" );
        assertEquals(1, self::$enrollment->id, "created id equals expected value");
        assertEquals(1826461, self::$enrollment->studentNo, "created student number equals expected value");
        assertEquals("Tristen", self::$enrollment->name, "created name equals expected value");
        assertEquals("Paul", self::$enrollment->surname, "created surname equals expected value");
        assertEquals("COMS", self::$enrollment->subject, "created subject equals expected value");
        assertEquals("COMS3007A", self::$enrollment->unitCode, "created unit code equals expected value");
        assertEquals("SM1", self::$enrollment->session, "created session equals expected value");
        assertEquals("A", self::$enrollment->classSection, "created class section equals expected value");
        assertEquals("2020-06-30 00:00:00", self::$enrollment->expiryDate, "created expiry date equals expected value");
        assertEquals("ENROLLED", self::$enrollment->status, "created class section equals expected value");
    }

    public function testGetID()
    {
        assertEquals(1, self::$enrollment->getId(),
            "ID equals expected value");

    }
    public function testSetUserID()
    {
        self::$enrollment->setId(2);
        assertEquals(2, self::$enrollment->getId(),
            "new ID equals expected value");

    }

    public function testGetStudentNo()
    {
        assertEquals(1826461, self::$enrollment->getStudentNo(),
            "Student no equals expected value");

    }
    public function testSetStudentNo()
    {
        self::$enrollment->setStudentNo(1826462);
        assertEquals(1826462, self::$enrollment->getStudentNo(),
            "new student no equals expected value");

    }

    public function testGetName()
    {
        assertEquals("Tristen", self::$enrollment->getName(),
            "name equals expected value");

    }
    public function testSetName()
    {
        self::$enrollment->setName("Tristan");
        assertEquals("Tristan", self::$enrollment->getName(),
            "new name equals expected value");

    }

    public function testGetSurname()
    {
        assertEquals("Paul", self::$enrollment->getSurname(),
            "surname equals expected value");

    }
    public function testSetSurname()
    {
        self::$enrollment->setSurname("Paula");
        assertEquals("Paula", self::$enrollment->getSurname(),
            "new surname equals expected value");

    }

    public function testGetSubject()
    {
        assertEquals("COMS", self::$enrollment->getSubject(),
            "subject equals expected value");

    }
    public function testSetSubject()
    {
        self::$enrollment->setSubject("MATH");
        assertEquals("MATH", self::$enrollment->getSubject(),
            "new subject equals expected value");

    }

    public function testGetUnitCode()
    {
        assertEquals("COMS3007A", self::$enrollment->getUnitCode(),
            "unit code equals expected value");

    }
    public function testSetUnitCode()
    {
        self::$enrollment->setUnitCode("COMS3006A");
        assertEquals("COMS3006A", self::$enrollment->getUnitCode(),
            "new unit code equals expected value");

    }

    public function testGetSession()
    {
        assertEquals("SM1", self::$enrollment->getSession(),
            "session equals expected value");

    }
    public function testSetSession()
    {
        self::$enrollment->setSession("SM2");
        assertEquals("SM2", self::$enrollment->getSession(),
            "new session equals expected value");

    }

    public function testGetClassSection()
    {
        assertEquals("A", self::$enrollment->getClassSection(),
            "class section equals expected value");

    }
    public function testSetClassSection()
    {
        self::$enrollment->setClassSection("C");
        assertEquals("C", self::$enrollment->getClassSection(),
            "new class section equals expected value");

    }

    public function testGetExpiryDate()
    {
        assertEquals("2020-06-30 00:00:00", self::$enrollment->getExpiryDate(),
            "expiry date equals expected value");

    }
    public function testSetExpiryDate()
    {
        self::$enrollment->setExpiryDate("2021-06-30 00:00:00");
        assertEquals("2021-06-30 00:00:00", self::$enrollment->getExpiryDate(),
            "new expiry date equals expected value");

    }

    public function testGetStatus()
    {
        assertEquals("ENROLLED", self::$enrollment->getStatus(),
            "status equals expected value");

    }
    public function testSetStatus()
    {
        self::$enrollment->setStatus("DEREGISTERED");
        assertEquals("DEREGISTERED", self::$enrollment->getStatus(),
            "new status equals expected value");

    }

    public function testSetCourseID()
    {
        self::$enrollment->setCourseID(100);
        assertEquals(100, self::$enrollment->getCourseID(),
            "new course ID equals expected value");
    }




}
