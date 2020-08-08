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
        $databaseHelper = new DatabaseHelper("moodle");
        $databaseHelper->query("SELECT id, name, coursecount  FROM mdl_course_categories ORDER BY id");
        $result = $databaseHelper->resultSet();
        //if ($databaseHelper->rowCount() == 0) {
            //return 0;
        //} else {
            return $result;
        //}
    }

    /**
     * @param $id
     * @return int|MoodleCourseCategory
     */
    public static function getMoodleCourseCategory($id)
    {
        $databaseHelper = new DatabaseHelper("moodle");
        $databaseHelper->query("SELECT id, name, coursecount FROM mdl_course_categories WHERE id = :id LIMIT 0,1");
        $databaseHelper->bind(':id', $id);
        $moodleCourseCategory = $databaseHelper->single();
        if ($databaseHelper->rowCount() === 0) {
            return 0;
        }
        return new MoodleCourseCategory($moodleCourseCategory['id'], $moodleCourseCategory['name'], $moodleCourseCategory['coursecount']);
    }
}