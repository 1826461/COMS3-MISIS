<?php

use Objects\Course;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class CourseTest extends TestCase
{
    private static Course $course;

    public function testUserConstructor() {
        self::$course = new Course("TEST101", 1);
        assertEquals("TEST101", self::$course->unitCode, "created unit code equals expected value");
        assertEquals(1, self::$course->courseID, "created course ID equals expected value");
    }

    public function testGetUnitCode()
    {
        assertEquals("TEST101", self::$course->getUnitCode(),
            "unit code equals expected value");

    }
    public function testSetUnitCode()
    {
        self::$course->setUnitCode("TEST102");
        assertEquals("TEST102", self::$course->getUnitCode(),
            "new unit code equals expected value");

    }
    public function testGetCourseID()
    {
        assertEquals(1, self::$course->getCourseID(),
            "course ID equals expected value");

    }
    public function testSetCourseID()
    {
        self::$course->setCourseID(2);
        assertEquals(2, self::$course->getCourseID(),
            "new course ID equals expected value");

    }

    public function testGetCourseName()
    {
        assertEquals("TEST101", self::$course->getCourseName(),
            "course name equals expected value");

    }

    public function testSetRole()
    {
        self::$course->setCourseName("TEST101-TEST");
        assertEquals("TEST101-TEST", self::$course->getCourseName(),
            "new course name equals expected value");

    }

    public function testSetUpdateFrequency()
    {
        self::$course->setUpdateFrequency(10);
        assertEquals(10, self::$course->getUpdateFrequency(),
            "update frequency equals expected value");

    }

}
