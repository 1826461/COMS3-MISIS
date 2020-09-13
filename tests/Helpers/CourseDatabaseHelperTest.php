<?php

use Helpers\CourseDatabaseHelper;
use Helpers\DatabaseHelper;
use Objects\Course;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertGreaterThan;

class CourseDatabaseHelperTest extends TestCase
{

    public function testGetAllCoursesEmpty() {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("TRUNCATE TABLE courses");
        $databaseHelper->execute();
        $databaseHelper->query("TRUNCATE TABLE enrollments");
        $databaseHelper->execute();
        $databaseHelper->query("TRUNCATE TABLE enrollments_temp");
        $databaseHelper->execute();
        $courseDatabaseHelper = new CourseDatabaseHelper();
        assertEquals($courseDatabaseHelper->getAllCourses(), 0, "returns correct course count");
    }

    public function testGetCourseListEmpty() {
        $courseDatabaseHelper = new CourseDatabaseHelper();
        assertEquals($courseDatabaseHelper->getCourseList(), 0, "returns correct course count");
    }

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

    public function testDeleteCourseWithID() {
        $courseDatabaseHelper = new CourseDatabaseHelper();
        $course = new Course("TEST2000A", 100);
        $courseDatabaseHelper->insertCourse($course);
        $courseDatabaseHelper->deleteCourseWithID(100);
        assertEquals($courseDatabaseHelper->getCourse("TEST2000A"),0, "returns no course");
    }



    public function testGetAllCourses() {
        $courseDatabaseHelper = new CourseDatabaseHelper();
        $course = new Course("TEST100A", 1);
        $courseDatabaseHelper->insertCourse($course);
        $courseCount = sizeof($courseDatabaseHelper->getAllCourses());
        $course = new Course("TEST200A", 3);
        $courseDatabaseHelper->insertCourse($course);
        assertEquals(sizeof($courseDatabaseHelper->getAllCourses()), $courseCount + 1, "returns correct course count");
    }

    public function testUpdateLastSync() {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $courseDatabaseHelper = new CourseDatabaseHelper();
        $course = new Course("TEST100A", 1);
        $courseDatabaseHelper->insertCourse($course);
        $databaseHelper->query("SELECT updatedOn FROM courses WHERE unitCode = 'TEST100A' LIMIT 0,1");
        $lastSync = $databaseHelper->single();
        $course = $courseDatabaseHelper->getCourse("TEST100A");
        $courseDatabaseHelper->updatelastSync($course);
        $databaseHelper->query("SELECT updatedOn FROM courses WHERE unitCode = 'TEST100A' LIMIT 0,1");
        $currentSync = $databaseHelper->single();
        \PHPUnit\Framework\assertNotEquals($lastSync, $currentSync, "returns new sync timestamp");
    }

    public function testGetCourseList() {
        $courseDatabaseHelper = new CourseDatabaseHelper();
        assertGreaterThan(0, sizeof($courseDatabaseHelper->getCourseList()), "returns correct course list");
        $courseDatabaseHelper->deleteCourse("TEST200A");
        $courseDatabaseHelper->deleteCourse("TEST100A");
    }


}
