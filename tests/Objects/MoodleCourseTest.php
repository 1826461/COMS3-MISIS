<?php

use Objects\MoodleCourse;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class MoodleCourseTest extends TestCase
{
    private static MoodleCourse $moodleCourse;

    public function testMoodleCourseConstructor() {
        self::$moodleCourse = new MoodleCourse(0, "TEST1000A/TEST1001A - Long Name", "TEST1000A", 0);
        assertEquals("TEST1000A/TEST1001A - Long Name", self::$moodleCourse->longName, "created long name equals expected value");
        assertEquals("TEST1000A", self::$moodleCourse->shortName, "created short name equals expected value");
        assertEquals(0, self::$moodleCourse->id, "created id equals expected value");
    }

    public function testGetId()
    {
        assertEquals(0, self::$moodleCourse->getId(),
            "id equals expected value");

    }
    public function testSetId()
    {
        self::$moodleCourse->setId(1);
        assertEquals(1, self::$moodleCourse->getId(),
            "new id equals expected value");

    }
    public function testGetLongName()
    {
        assertEquals("TEST1000A/TEST1001A - Long Name", self::$moodleCourse->getLongName(),
            "long name equals expected value");

    }
    public function testSetLongName()
    {
        self::$moodleCourse->setLongName("TEST1000A/TEST1001A - New Long Name");
        assertEquals("TEST1000A/TEST1001A - New Long Name", self::$moodleCourse->getLongName(),
            "new long name equals expected value");

    }

    public function testGetShortName()
    {
        assertEquals("TEST1000A", self::$moodleCourse->getShortName(),
            "short name equals expected value");

    }
    public function testSetShortName()
    {
        self::$moodleCourse->setShortName("TEST1001A");
        assertEquals("TEST1001A", self::$moodleCourse->getShortName(),
            "new short name equals expected value");

    }
    public function testGetCategory()
    {
        assertEquals(0, self::$moodleCourse->getCategory(),
            "category equals expected value");

    }
    public function testSetCategory()
    {
        self::$moodleCourse->setCategory(1);
        assertEquals(1, self::$moodleCourse->getCategory(),
            "new category equals expected value");

    }


}
