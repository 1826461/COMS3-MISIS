<?php

namespace Helpers;

use Objects\Enrollment;

class JSONHelper
{

    /**
     * @param string $unitCode
     * @return bool
     */
    function updateCourseData(string $unitCode)
    {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $data = self::getVirtusCourseJSON($unitCode);
//        $enrollmentDatabaseHelper->deleteAllCourseEnrollments($unitCode);
        return self::parseEnrollmentJSON($data);
    }

    /**
     * @param string $unitCode
     * @return mixed
     */
    function getVirtusCourseJSON(string $unitCode)
    {
        $url = 'http://wims-service-user:w!im5-5erv1s-u5er@127.0.0.1:3128/wits-wims-services/wims/student/unitStudents/';
        $url = $url . $unitCode . '/';
        return json_decode(file_get_contents($url), true);
    }

    /**
     * @param array $json
     * @return bool
     */
    function parseEnrollmentJSON(array $json)
    {
        $success = false;
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        foreach ($json as $enrollmentJSON) {
            $enrollment = new Enrollment(0, $enrollmentJSON['studentNumber'], $enrollmentJSON['firstName'],
                $enrollmentJSON['surname'], $enrollmentJSON['subject'], $enrollmentJSON['unitCode'],
                $enrollmentJSON['sessionCode'], $enrollmentJSON['classSection'], $enrollmentJSON['expiryDate'],
                $enrollmentJSON['unitStatus']);

            $enrollmentDatabaseHelper->insertUniqueEnrollment($enrollment);
            $success = true;
        }
        return $success;
    }

    /**
     * @param string $unitCode
     * @return bool
     */
    function addCourseData(string $unitCode)
    {
        $data = self::getVirtusCourseJSON($unitCode);
        return self::parseEnrollmentJSON($data);
    }

}