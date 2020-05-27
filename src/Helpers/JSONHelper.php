<?php


namespace Helpers;

use Objects\Enrollment;
include("EnrollmentDatabaseHelper.php");

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

    /*function getVirtusCourseJSON(string $unitCode) {
        $url = 'http://wims-service-user:w!im5-5erv1s-u5er@virtus.wits.ac.za:8180/wits-wims-services/wims/student/unitStudents/';
        $url = $url . $unitCode .'/';
        return json_decode(file_get_contents($url), true);
    }

    //refresh details of course
    //TODO Virtus system not responding to URL
    function updateCourseData(string $unitCode) {
        //$enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        //$data = self::getVirtusCourseJSON($unitCode);
        //$enrollmentDatabaseHelper->deleteAllCourseEnrollments($unitCode);
        //return self::parseEnrollmentJSON($data);
    }

    //edit details of course
    //TODO TEST WHEN GIVEN ACCESS
    function editCourseData(string $unitCode,string $oldUnitCode) {
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $enrollmentDatabaseHelper->updateEnrollmentWhenCourseChange($unitCode,$oldUnitCode);

        //TODO Virtus system not responding to URL
        //$data = self::getVirtusCourseJSON($unitCode);
        //return self::parseEnrollmentJSON($data);
    }

    //enter new courses
    function addCourseData(string $unitCode) {
        //TODO Virtus system not responding to URL
        //$data = self::getVirtusCourseJSON($unitCode);
        //return self::parseEnrollmentJSON($data);
    }*/

}