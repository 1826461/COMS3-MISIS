<?php

use Objects\MoodleCourseCategory;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class MoodleCourseCategoryTest extends TestCase
{
    private static MoodleCourseCategory $moodleCourseCategory;

    public function testMoodleCourseConstructor() {
        self::$moodleCourseCategory = new MoodleCourseCategory(0, "Test Category", 0);
        assertEquals("Test Category", self::$moodleCourseCategory->name, "created name equals expected value");
        assertEquals(0, self::$moodleCourseCategory->courseCount, "created course count equals expected value");
        assertEquals(0, self::$moodleCourseCategory->id, "created id equals expected value");
    }

    public function testGetId()
    {
        assertEquals(0, self::$moodleCourseCategory->getId(),
            "id equals expected value");

    }
    public function testSetId()
    {
        self::$moodleCourseCategory->setId(1);
        assertEquals(1, self::$moodleCourseCategory->getId(),
            "new id equals expected value");

    }
    public function testGetName()
    {
        assertEquals("Test Category", self::$moodleCourseCategory->getName(),
            "name equals expected value");

    }
    public function testSetName()
    {
        self::$moodleCourseCategory->setName("New Test Category");
        assertEquals("New Test Category", self::$moodleCourseCategory->getName(),
            "new name equals expected value");

    }

    public function testGetCourseCount()
    {
        assertEquals(0, self::$moodleCourseCategory->getCourseCount(),
            "course count equals expected value");

    }
    public function testSetCourseCount()
    {
        self::$moodleCourseCategory->setCourseCount(1);
        assertEquals(1, self::$moodleCourseCategory->getCourseCount(),
            "new course count equals expected value");

    }

}
