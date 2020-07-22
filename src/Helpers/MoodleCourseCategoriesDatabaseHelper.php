<?php


namespace Helpers;

use Objects\MoodleCourseCategory;

class MoodleCourseCategoriesDatabaseHelper
{

    /**
     * @return array|int
     */
    public static function getAllMoodleCourseCategories()
    {
        $moodleDatabaseHelper = new MoodleDatabaseHelper();
        $moodleDatabaseHelper->query("SELECT id, name, coursecount  FROM mdl_course_categories ORDER BY id");
        $result = $moodleDatabaseHelper->resultSet();
        if ($moodleDatabaseHelper->rowCount() == 0) {
            return 0;
        } else {
            return $result;
        }
    }

    /**
     * @param $id
     * @return int|MoodleCourseCategory
     */
    public static function getMoodleCourseCategory($id)
    {
        $moodleDatabaseHelper = new MoodleDatabaseHelper();
        $moodleDatabaseHelper->query("SELECT id, name, coursecount FROM mdl_course_categories WHERE id = :id LIMIT 0,1");
        $moodleDatabaseHelper->bind(':id', $id);
        $moodleCourseCategory = $moodleDatabaseHelper->single();
        if ($moodleDatabaseHelper->rowCount() === 0) {
            return 0;
        }
        return new MoodleCourseCategory($moodleCourseCategory['id'], $moodleCourseCategory['name'], $moodleCourseCategory['coursecount']);
    }
}