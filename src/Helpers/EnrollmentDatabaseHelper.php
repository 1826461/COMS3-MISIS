<?php


namespace Helpers;

use Objects\Enrollment;

class EnrollmentDatabaseHelper
{

    public static function insertEnrollment(Enrollment $enrollment) {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->query("INSERT INTO enrollments (studentNo, name, surname, subject, unitCode, session, 
                         classSection, expiryDate, status) VALUES (:studentNo, :name, :surname, :subject, :unitCode, 
                                                                   :session, :classSection, :expiryDate, :status) ");
        $databaseHelper->bind(':studentNo', $enrollment->getStudentNo());
        $databaseHelper->bind(':name', $enrollment->getName());
        $databaseHelper->bind(':surname', $enrollment->getSurname());
        $databaseHelper->bind(':subject', $enrollment->getSubject());
        $databaseHelper->bind(':unitCode', $enrollment->getUnitCode());
        $databaseHelper->bind(':session', $enrollment->getSession());
        $databaseHelper->bind(':classSection', $enrollment->getClassSection());
        $databaseHelper->bind(':expiryDate', $enrollment->getExpiryDate());
        $databaseHelper->bind(':status', $enrollment->getStatus());

        $previousInsertId = $databaseHelper->lastInsertId();
        $databaseHelper->execute();

        if ($previousInsertId == $databaseHelper->lastInsertId()) {
            return 0;
        } else {
            return 1;
        }

    }

    public static function getAllEnrollments() {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->query("SELECT DISTINCT * FROM enrollments ORDER BY unitCode, studentNo");
        $result = $databaseHelper->resultSet();
        if ($databaseHelper->rowCount() == 0) {
            return 0;
        } else {
            return $result;
        }
    }

    public static function getCourseList() {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->query("SELECT DISTINCT unitCode FROM enrollments");
        $result = $databaseHelper->resultSet();
        if ($databaseHelper->rowCount() == 0) {
            return 0;
        } else {
            return $result;
        }
    }

    public static function deleteEnrollment($studentNo, $unitCode) {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->query("DELETE FROM enrollments WHERE studentNo = :studentNo AND unitCode = :unitCode");
        $databaseHelper->bind(':studentNo', $studentNo);
        $databaseHelper->bind(':unitCode', $unitCode);
        $databaseHelper->execute();

    }

    public static function deleteAllCourseEnrollments($unitCode) {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->query("DELETE FROM enrollments WHERE unitCode = :unitCode");
        $databaseHelper->bind(':unitCode', $unitCode);
        $databaseHelper->execute();

    }

    public static function getAllCourseEnrollments($unitCode) {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->query("SELECT * FROM enrollments WHERE unitCode = :unitCode");
        $databaseHelper->bind(':unitCode', $unitCode);
        $enrollments = $databaseHelper->resultSet();
        if ($databaseHelper->rowCount() === 0) {
            return 0;
        }
        return $enrollments;
    }

    public static function getCourseEnrollmentsCount($unitCode) {
        if (self::getAllCourseEnrollments($unitCode) === 0) {
           return 0;
        } else {
            return sizeof(self::getAllCourseEnrollments($unitCode));
        }
    }

    public static function getEnrollment($studentNo, $unitCode) {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->query("SELECT * FROM enrollments WHERE studentNo = :studentNo AND unitCode = :unitCode LIMIT 0,1");
        $databaseHelper->bind(':studentNo', $studentNo);
        $databaseHelper->bind(':unitCode', $unitCode);
        $enrollment = $databaseHelper->single();
        if ($databaseHelper->rowCount() === 0) {
            return 0;
        }
        $enrollmentObject = new Enrollment($enrollment['id'], $enrollment['studentNo'], $enrollment['name'], $enrollment['surname'],
            $enrollment['subject'], $enrollment['unitCode'], $enrollment['session'], $enrollment['classSection'],
            $enrollment['expiryDate'], $enrollment['status']);
        $enrollmentObject->setCourseID($enrollment['courseId']);
        return $enrollmentObject;
    }

    public static function updateEnrollment(Enrollment $enrollment) {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->query("UPDATE enrollments SET studentNo = :studentNo, name = :name, surname = :surname, 
                       subject= :subject, unitCode = :unitCode, session = :session, classSection = :classSection , expiryDate = :expiryDate,
                       status = :status WHERE (id= :id)");
        $databaseHelper->bind(':studentNo', $enrollment->getStudentNo());
        $databaseHelper->bind(':name', $enrollment->getName());
        $databaseHelper->bind(':surname', $enrollment->getSurname());
        $databaseHelper->bind(':subject', $enrollment->getSubject());
        $databaseHelper->bind(':unitCode', $enrollment->getUnitCode());
        $databaseHelper->bind(':session', $enrollment->getSession());
        $databaseHelper->bind(':classSection', $enrollment->getClassSection());
        $databaseHelper->bind(':expiryDate', $enrollment->getExpiryDate());
        $databaseHelper->bind(':status', $enrollment->getStatus());
        $databaseHelper->bind(':id', $enrollment->getId());

        $databaseHelper->execute();
    }

    public static function updateEnrollmentWhenCourseChange(string $unitCode, int $courseID) {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->query("UPDATE enrollments SET courseId = :courseID WHERE (unitCode = :unitCode)");
        $databaseHelper->bind(':unitCode', $unitCode);
        $databaseHelper->bind(':courseID', $courseID);
        $databaseHelper->execute();
    }

}