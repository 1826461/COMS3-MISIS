<?php


namespace Helpers;

use Objects\Course;

class CourseDatabaseHelper
{

    /**
     * @param Course $course
     */
    public static function insertCourse(Course $course)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("INSERT INTO courses (courseID, unitCode, courseName, syncFrequency, deleteActive) VALUES (:courseID, :unitCode, :courseName, :updateFrequency, :deleteActive) ");
        $databaseHelper->bind(':courseID', $course->getCourseID());
        $databaseHelper->bind(':unitCode', $course->getUnitCode());
        $databaseHelper->bind(':courseName', $course->getCourseName());
        $databaseHelper->bind(':updateFrequency', $course->getUpdateFrequency());
        $databaseHelper->bind(':deleteActive', $course->getDeleteActive());
        $databaseHelper->execute();
    }

    /**
     * @return array|int
     */
    public static function getAllCourses()
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("SELECT DISTINCT * FROM courses ORDER BY unitCode, courseName");
        $result = $databaseHelper->resultSet();
        if ($databaseHelper->rowCount() == 0) {
            return 0;
        } else {
            return $result;
        }
    }

    /**
     * @return array|int
     */
    public static function getCourseList()
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("SELECT DISTINCT unitCode FROM courses");
        $result = $databaseHelper->resultSet();
        if ($databaseHelper->rowCount() == 0) {
            return 0;
        } else {
            return $result;
        }
    }

    /**
     * @param $unitCode
     */
    public static function deleteCourse($unitCode)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("DELETE FROM courses WHERE unitCode = :unitCode");
        $databaseHelper->bind(':unitCode', $unitCode);
        $databaseHelper->execute();
    }

    /**
     * @param $ID
     */
    public static function deleteCourseWithID($ID)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("DELETE FROM courses WHERE courseID = :ID");
        $databaseHelper->bind(':ID', $ID);
        $databaseHelper->execute();
    }

    /**
     * @param $unitCode
     * @return int|Course
     */
    public static function getCourse($unitCode)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("SELECT * FROM courses WHERE unitCode = :unitCode LIMIT 0,1");
        $databaseHelper->bind(':unitCode', $unitCode);
        $course = $databaseHelper->single();
        if ($databaseHelper->rowCount() === 0) {
            return 0;
        }
        $newCourse = new Course($course['unitCode'], $course['courseID']);
        $newCourse->setCourseName($course['courseName']);
        $newCourse->setDeleteActive($course['deleteActive']);
        $newCourse->setUpdateFrequency($course['syncFrequency']);
        return $newCourse;
    }

    /**
     * @param Course $course
     */
    public static function updateCourse(Course $course)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("UPDATE courses SET courseName = :courseName, courseID  = :courseID, syncFrequency = :updateFrequency, deleteActive = :deleteActive WHERE (unitCode = :unitCode)");
        $databaseHelper->bind(':unitCode', $course->getUnitCode());
        $databaseHelper->bind(':courseID', $course->getCourseID());
        $databaseHelper->bind(':courseName', $course->getCourseName());
        $databaseHelper->bind(':updateFrequency', $course->getUpdateFrequency());
        $databaseHelper->bind(':deleteActive', $course->getDeleteActive());
        $databaseHelper->execute();
    }

    /**
     * @param Course $course
     */
    public static function updateLastSync(Course $course)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $lastSync = date("Y:m:d H:i:s");
        $databaseHelper->query("UPDATE courses SET updatedOn = :lastSync WHERE (unitCode = :unitCode)");
        $databaseHelper->bind(':unitCode', $course->getUnitCode());
        $databaseHelper->bind(':lastSync', $lastSync);
        $databaseHelper->execute();
    }
}