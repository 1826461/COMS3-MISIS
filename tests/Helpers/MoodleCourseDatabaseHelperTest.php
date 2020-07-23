<?php

use Helpers\MoodleCourseDatabaseHelper;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertGreaterThan;

class MoodleCourseDatabaseHelperTest extends TestCase
{


    public function testGetAllMoodleCourses() {
        $moodleCourseDatabaseHelper = new MoodleCourseDatabaseHelper();
        assertGreaterThan(0, sizeof($moodleCourseDatabaseHelper->getAllMoodleCourses()), "returns correct course list");
    }

    public function  testGetMoodleCourse() {
        $moodleCourseDatabaseHelper = new MoodleCourseDatabaseHelper();
        $moodleCourse = $moodleCourseDatabaseHelper->getMoodleCourse(1);
        assertEquals(1, $moodleCourse->getId(), "returns correct id");
        assertEquals("COMS3-MISIS Test Site", $moodleCourse->getLongName(), "returns correct long name");
        assertEquals("COMS3-MISIS", $moodleCourse->getShortName(), "returns correct short name");
        assertEquals(0, $moodleCourse->getCategory(), "returns correct category");

    }

    public function  testGetMoodleCourseNone() {
        $moodleCourseDatabaseHelper = new MoodleCourseDatabaseHelper();
        $moodleCourse = $moodleCourseDatabaseHelper->getMoodleCourse(0);
        assertEquals(0, $moodleCourse, "returns correct value");
    }

    public function testGetAllMoodleCoursesByCategory() {
        $moodleCourseDatabaseHelper = new MoodleCourseDatabaseHelper();
        assertEquals(1, sizeof($moodleCourseDatabaseHelper->getAllMoodleCoursesByCategory(0)), "returns correct course list");
    }

    public function testGetAllMoodleCoursesByCategoryNone() {
        $moodleCourseDatabaseHelper = new MoodleCourseDatabaseHelper();
        assertEquals(0, $moodleCourseDatabaseHelper->getAllMoodleCoursesByCategory(-1), "returns correct value");
    }
}
