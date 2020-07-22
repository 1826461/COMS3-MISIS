<?php


namespace Helpers;

use Objects\MoodleCourse;

class MoodleCourseDatabaseHelper
{

    /**
     * @return array|int
     */
    public static function getAllMoodleCourses()
    {
        $databaseHelper = new DatabaseHelper("moodle");
        $databaseHelper->query("SELECT id, fullname, shortname  FROM mdl_course ORDER BY id");
        $result = $databaseHelper->resultSet();
        if ($databaseHelper->rowCount() == 0) {
            return 0;
        } else {
            return $result;
        }
    }

    /**
     * @param $id
     * @return int|MoodleCourse
     */
    public static function getMoodleCourse($id)
    {
        $databaseHelper = new DatabaseHelper("moodle");
        $databaseHelper->query("SELECT id, fullname, shortname FROM mdl_course WHERE id = :id LIMIT 0,1");
        $databaseHelper->bind(':id', $id);
        $moodleCourse = $databaseHelper->single();
        if ($databaseHelper->rowCount() === 0) {
            return 0;
        }
        return new MoodleCourse($moodleCourse['id'], $moodleCourse['fullname'], $moodleCourse['shortname']);
    }
}