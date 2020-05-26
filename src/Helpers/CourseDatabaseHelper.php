<?php


namespace Helpers;

use Objects\Course;

class CourseDatabaseHelper
{

    public static function insertCourse(Course $course) {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->query("INSERT INTO courses (courseId, unitCode, courseName) VALUES (:courseId, :unitCode, :courseName) ");
        $databaseHelper->bind(':courseId', $course->getCourseId());
        $databaseHelper->bind(':unitCode', $course->getUnitCode());
        $databaseHelper->bind(':courseName', $course->getCourseName());

        $previousInsertId = $databaseHelper->lastInsertId();
        $databaseHelper->execute();

        if ($previousInsertId == $databaseHelper->lastInsertId()) {
            return 0;
        } else {
            return 1;
        }

    }

    public static function getAllCourses() {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->query("SELECT DISTINCT * FROM courses ORDER BY unitCode, courseName");
        $result = $databaseHelper->resultSet();
        if ($databaseHelper->rowCount() == 0) {
            return 0;
        } else {
            return $result;
        }
    }

    public static function getCourseList() {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->query("SELECT DISTINCT unitCode FROM courses");
        $result = $databaseHelper->resultSet();
        if ($databaseHelper->rowCount() == 0) {
            return 0;
        } else {
            return $result;
        }
    }

    public static function deleteCourse($unitCode)
    {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->query("DELETE FROM courses WHERE unitCode = :unitCode");
        $databaseHelper->bind(':unitCode', $unitCode);
        $databaseHelper->execute();
    }

    public static function getCourse($unitCode) {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->query("SELECT * FROM courses WHERE unitCode = :unitCode LIMIT 0,1");
        $databaseHelper->bind(':unitCode', $unitCode);
        $course = $databaseHelper->single();
        if ($databaseHelper->rowCount() === 0) {
            return 0;
        }
        return new Course($course['courseId'], $course['courseName'], $course['unitCode']);
    }

    public static function updateCourse(Course $course) {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->query("UPDATE courses SET  courseName = :couseName, unitCode = :unitCode WHERE (courseId = :courseId)");
        $databaseHelper->bind(':courseName', $course->getCourseName());
        $databaseHelper->bind(':unitCode', $course->getUnitCode());
        $databaseHelper->bind(':courseId', $course->getCourseId());
        $databaseHelper->execute();
    }
}