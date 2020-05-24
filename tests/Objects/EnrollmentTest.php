<?php

use Objects\Enrollment;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class EnrollmentTest extends TestCase
{
    private static Enrollment $enrollment;

    public function testUserConstructor() {
        self::$enrollment = new Enrollment(1, 1826461, "Tristen", "Paul", "COMS",
            "COMS3007A", "SM1", "A", DateTime::createFromFormat('Y-m-d H:i:s',
                '2020-06-30 00:00:00') );
        assertEquals(1, self::$enrollment->id, "created id equals expected value");
        assertEquals(1826461, self::$enrollment->studentNo, "created student number equals expected value");
        assertEquals("Tristen", self::$enrollment->name, "created name equals expected value");
        assertEquals("Paul", self::$enrollment->surname, "created surname equals expected value");
        assertEquals("COMS", self::$enrollment->subject, "created subject equals expected value");
        assertEquals("COMS3007A", self::$enrollment->unitCode, "created unit code equals expected value");
        assertEquals("SM1", self::$enrollment->session, "created session equals expected value");
        assertEquals("A", self::$enrollment->classSection, "created class section equals expected value");
        assertEquals(DateTime::createFromFormat('Y-m-d H:i:s',
            '2020-06-30 00:00:00'), self::$enrollment->expiryDate, "created expiry date equals expected value");
    }


}
