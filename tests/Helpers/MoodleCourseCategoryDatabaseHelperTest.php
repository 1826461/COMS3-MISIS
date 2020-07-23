<?php

use Helpers\MoodleCourseCategoriesDatabaseHelper;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertGreaterThan;

class MoodleCourseCategoryDatabaseHelperTest extends TestCase
{


    public function testGetAllMoodleCourses() {
        $moodleCourseCategoriesDatabaseHelper = new MoodleCourseCategoriesDatabaseHelper();
        assertGreaterThan(0, sizeof($moodleCourseCategoriesDatabaseHelper->getAllMoodleCourseCategories()), "returns correct category list");
    }

    public function  testGetMoodleCourseCategory() {
        $moodleCourseCategoriesDatabaseHelper = new MoodleCourseCategoriesDatabaseHelper();
        $moodleCourseCategory = $moodleCourseCategoriesDatabaseHelper->getMoodleCourseCategory(3);
        assertEquals(3, $moodleCourseCategory->getId(), "returns correct id");
        assertEquals("2020", $moodleCourseCategory->getName(), "returns correct name");
        assertEquals(0, $moodleCourseCategory->getCourseCount(), "returns correct course count");

    }

    public function  testGetMoodleCourseCategoryNone() {
        $moodleCourseCategoriesDatabaseHelper = new MoodleCourseCategoriesDatabaseHelper();
        $moodleCourseCategory = $moodleCourseCategoriesDatabaseHelper->getMoodleCourseCategory(0);
        assertEquals(0, $moodleCourseCategory, "returns correct value");

    }
}
