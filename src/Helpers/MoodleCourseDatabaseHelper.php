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
        $moodleDatabaseHelper = new MoodleDatabaseHelper();
        $moodleDatabaseHelper->query("SELECT id, fullname, shortname  FROM mdl_course ORDER BY id");
        $result = $moodleDatabaseHelper->resultSet();
        if ($moodleDatabaseHelper->rowCount() == 0) {
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
        $moodleDatabaseHelper = new MoodleDatabaseHelper();
        $moodleDatabaseHelper->query("SELECT id, fullname, shortname FROM mdl_course WHERE id = :id LIMIT 0,1");
        $moodleDatabaseHelper->bind(':id', $id);
        $moodleCourse = $moodleDatabaseHelper->single();
        if ($moodleDatabaseHelper->rowCount() === 0) {
            return 0;
        }
        return new MoodleCourse($moodleCourse['id'], $moodleCourse['fullname'], $moodleCourse['shortname']);
    }
}