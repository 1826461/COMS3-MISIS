<?php


namespace Helpers;

use Objects\Enrollment;

class EnrollmentDatabaseHelper
{

    /**
     * @param Enrollment $enrollment
     * @return int
     */
    public static function insertUniqueEnrollment(Enrollment $enrollment)
    {
        $getCurrentEnrollmentStatus = self::getEnrollment($enrollment->getStudentNo(), $enrollment->getUnitCode());
        if ($getCurrentEnrollmentStatus === 0) {
            $databaseHelper = new DatabaseHelper("coms3-misis");
            $databaseHelper->query("INSERT INTO enrollments (studentNo, name, surname, subject, unitCode, session,
                                                                    classSection, expiryDate, status) 
                                        SELECT * FROM (SELECT :studentNo, :name, :surname, :subject
                                                                ,:unitCode,:session,:classSection,:expiryDate,:status) AS tmp
                                        WHERE NOT EXISTS (
                                                        SELECT studentNo, unitCode FROM enrollments WHERE (studentNo = :studentNo AND unitCode = :unitCode)
                                        ) LIMIT 1;");

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
            if ($previousInsertId != $databaseHelper->lastInsertId()) {
                return 1;
            }
        }
        return 0;
    }

    /**
     * @param Enrollment $enrollment
     * @return int
     */
    public static function insertEnrollment(Enrollment $enrollment)
    {
        $getCurrentEnrollmentStatus = self::getEnrollment($enrollment->getStudentNo(), $enrollment->getUnitCode());
        if ($getCurrentEnrollmentStatus === 0) {
            $databaseHelper = new DatabaseHelper("coms3-misis");
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
            if ($previousInsertId != $databaseHelper->lastInsertId()) {
                return 1;
            }
        }
        return 0;
    }

    /**
     * @param Enrollment $enrollment
     * @return int
     */
    public static function insertTempEnrollment(Enrollment $enrollment)
    {
        $getCurrentEnrollmentStatus = self::getTempEnrollment($enrollment->getStudentNo(), $enrollment->getUnitCode());
        if ($getCurrentEnrollmentStatus === 0) {
            $databaseHelper = new DatabaseHelper("coms3-misis");
            $databaseHelper->query("INSERT INTO enrollments_temp (studentNo, name, surname, subject, unitCode, session, 
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
            if ($previousInsertId != $databaseHelper->lastInsertId()) {
                return 1;
            }
        }
        return 0;
    }

    /**
     * @param $unitCode
     */
    public static function deleteAllTempEnrollments()
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("TRUNCATE enrollments_temp");
        $databaseHelper->execute();
        $databaseHelper->query("ALTER TABLE enrollments_temp AUTO_INCREMENT = 1");
        $databaseHelper->execute();
    }

    /**
     * @param $studentNo
     * @param $unitCode
     * @return int|Enrollment
     */
    public static function getEnrollment($studentNo, $unitCode)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
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

    /**
     * @param $studentNo
     * @param $unitCode
     * @return int|Enrollment
     */
    public static function getTempEnrollment($studentNo, $unitCode)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("SELECT * FROM enrollments_temp WHERE studentNo = :studentNo AND unitCode = :unitCode LIMIT 0,1");
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

    /**
     * @return array|int
     */
    public static function getAllEnrollments()
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("SELECT DISTINCT * FROM enrollments ORDER BY unitCode, studentNo");
        $result = $databaseHelper->resultSet();
        if ($databaseHelper->rowCount() != 0) {
            return $result;
        }

        return 0;
    }

    /**
     * @return array|int
     */
    public static function getAllEnrollmentsWhereNotInTemp()
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("SELECT * FROM `coms3-misis`.enrollments AS enrollments WHERE NOT EXISTS (SELECT * FROM `coms3-misis`.enrollments_temp AS enrollments_temp WHERE enrollments.studentNo=enrollments_temp.studentNo AND enrollments.unitCode = enrollments_temp.unitCode);");
        $result = $databaseHelper->resultSet();
        if ($databaseHelper->rowCount() != 0) {
            return $result;
        }
        return 0;
    }

    /**
     * @return array|int
     */
    public static function getAllEnrollmentsWhereInTemp()
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("SELECT * FROM `coms3-misis`.enrollments_temp AS enrollments_temp WHERE NOT EXISTS (SELECT * FROM `coms3-misis`.enrollments AS enrollments WHERE enrollments_temp.studentNo=enrollments.studentNo AND enrollments_temp.unitCode = enrollments.unitCode);");
        $result = $databaseHelper->resultSet();
        if ($databaseHelper->rowCount() != 0) {
            return $result;
        }
        return 0;
    }

    /**
     * @return array|int
     */
    public static function getCourseList()
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("SELECT DISTINCT unitCode FROM enrollments ORDER BY unitCode");
        $result = $databaseHelper->resultSet();
        if ($databaseHelper->rowCount() != 0) {
            return $result;
        }

        return 0;
    }

    /**
     * @param $studentNo
     * @param $unitCode
     */
    public static function deleteEnrollment($studentNo, $unitCode)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("DELETE FROM enrollments WHERE studentNo = :studentNo AND unitCode = :unitCode");
        $databaseHelper->bind(':studentNo', $studentNo);
        $databaseHelper->bind(':unitCode', $unitCode);
        $databaseHelper->execute();
    }

    /**
     * @param $unitCode
     */
    public static function deleteAllCourseEnrollments($unitCode)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("DELETE FROM enrollments WHERE unitCode = :unitCode");
        $databaseHelper->bind(':unitCode', $unitCode);
        $databaseHelper->execute();
    }

    /**
     * @param $ID
     */
    public static function deleteAllCourseEnrollmentsWithID($ID)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("DELETE FROM enrollments WHERE courseID = :ID");
        $databaseHelper->bind(':ID', $ID);
        $databaseHelper->execute();
    }

    /**
     * @param $unitCode
     * @return int
     */
    public static function getCourseEnrollmentsCount($unitCode)
    {
        if (self::getAllCourseEnrollments($unitCode) === 0) {
            return 0;
        } else {
            return sizeof(self::getAllCourseEnrollments($unitCode));
        }
    }

    /**
     * @param $unitCode
     * @return array|int
     */
    public static function getAllCourseEnrollments($unitCode)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("SELECT * FROM enrollments WHERE unitCode = :unitCode");
        $databaseHelper->bind(':unitCode', $unitCode);
        $enrollments = $databaseHelper->resultSet();
        if ($databaseHelper->rowCount() !== 0) {
            return $enrollments;
        }

        return 0;
    }

    /**
     * @param Enrollment $enrollment
     */
    public static function updateEnrollment(Enrollment $enrollment)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
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

    /**
     * @param string $unitCode
     * @param int $courseID
     */
    public static function updateEnrollmentWhenCourseChange(string $unitCode, int $courseID)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("UPDATE enrollments SET courseId = :courseID WHERE (unitCode = :unitCode)");
        $databaseHelper->bind(':unitCode', $unitCode);
        $databaseHelper->bind(':courseID', $courseID);
        $databaseHelper->execute();
    }

    /**
     * @param string $unitCode
     * @param int $courseID
     */
    public static function updateEnrollmentWhenCourseChangeTemp(string $unitCode, int $courseID)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("UPDATE enrollments_temp SET courseId = :courseID WHERE (unitCode = :unitCode)");
        $databaseHelper->bind(':unitCode', $unitCode);
        $databaseHelper->bind(':courseID', $courseID);
        $databaseHelper->execute();
    }
}