<?php


namespace Helpers;

use Objects\Enrollment;
use PHPUnit\Util\Json;

class JSONHelper
{
    //TODO TEST FUNCTIONALITY WITH VM - LOCAL TESTS PASS
    function parseEnrollmentJSON(string $json) {
        $success = false;
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $enrollmentJSONArray = json_decode($json, true);
        foreach ($enrollmentJSONArray as $enrollmentJSON) {
            $enrollment = new Enrollment(0, $enrollmentJSON['studentNumber'], $enrollmentJSON['firstName'],
                $enrollmentJSON['surname'], $enrollmentJSON['subject'], $enrollmentJSON['unitCode'],
                $enrollmentJSON['sessionCode'], $enrollmentJSON['classSection'], $enrollmentJSON['expiryDate'],
                $enrollmentJSON['unitStatus']);

            $enrollmentDatabaseHelper->insertEnrollment($enrollment);
            $success = true;
        }
    return $success;
    }

    function getVirtusCourseJSON(string $unitCode) {

        $url = 'http://wims-service-user:w\!im5-5erv1s-u5er@virtus.wits.ac.za:8180/wits-wims-services/wims/student/unitStudents/';
        $url = $url . $unitCode .'/';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    //TODO WHEN GIVEN ACCESS
    function updateCourseData(string $unitCode) {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $data = self::getVirtusCourseJSON($unitCode);
        $enrollmentDatabaseHelper->deleteAllCourseEnrollments($unitCode);
        return self::parseEnrollmentJSON($data);

    }

}