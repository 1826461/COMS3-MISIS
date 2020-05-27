<?php

use Helpers\CourseDatabaseHelper;
use Helpers\DatabaseHelper;
use Objects\Course;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class CourseDatabaseHelperTest extends TestCase
{

    public function testInsertCourse() {
        $courseDatabaseHelper = new CourseDatabaseHelper();
        $course = new Course("TEST100A", 3);
        $courseDatabaseHelper->insertCourse($course);
        assertEquals($courseDatabaseHelper->getCourse("TEST100A")->getCourseID(),3, "returns correct course ID");
        assertEquals($courseDatabaseHelper->getCourse("TEST100A")->getCourseName(),"TEST100A", "returns correct course name");
        assertEquals($courseDatabaseHelper->getCourse("TEST100A")->getUnitCode(),"TEST100A", "returns correct unit code");
    }

    public function testGetCourse() {
        $courseDatabaseHelper = new CourseDatabaseHelper();
        assertEquals($courseDatabaseHelper->getCourse("TEST100A")->getCourseID(),3, "returns correct course ID");
        assertEquals($courseDatabaseHelper->getCourse("TEST100A")->getCourseName(),"TEST100A", "returns correct course name");
        assertEquals($courseDatabaseHelper->getCourse("TEST100A")->getUnitCode(),"TEST100A", "returns correct unit code");
    }

    public function testUpdateCourse() {
        $courseDatabaseHelper = new CourseDatabaseHelper();
        $course = $courseDatabaseHelper->getCourse("TEST100A");
        $course->setCourseID(4);
        $course->setCourseName("TEST100AA");
        $courseDatabaseHelper->updateCourse($course);
        assertEquals($courseDatabaseHelper->getCourse("TEST100A")->getCourseID(),4, "returns correct course ID");
        assertEquals($courseDatabaseHelper->getCourse("TEST100A")->getCourseName(),"TEST100AA", "returns correct course name");
        assertEquals($courseDatabaseHelper->getCourse("TEST100A")->getUnitCode(),"TEST100A", "returns correct unit code");
    }

    public function testDeleteCourse() {
        $courseDatabaseHelper = new CourseDatabaseHelper();
        $courseDatabaseHelper->deleteCourse("TEST100A");
        assertEquals($courseDatabaseHelper->getCourse("TEST100A"),0, "returns no course");
    }

    public function testGetAllCourses() {
        $courseDatabaseHelper = new CourseDatabaseHelper();
        $courseCount = sizeof($courseDatabaseHelper->getAllCourses());
        $course = new Course("TEST200A", 3);
        $courseDatabaseHelper->insertCourse($course);
        assertEquals(sizeof($courseDatabaseHelper->getAllCourses()), $courseCount + 1, "returns correct course count");
        $courseDatabaseHelper->deleteCourse("TEST200A");

    }
}
