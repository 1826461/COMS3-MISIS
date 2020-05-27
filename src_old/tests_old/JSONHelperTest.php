<?php

/*use Helpers\DatabaseHelper;
use Helpers\EnrollmentDatabaseHelper;
use Helpers\JSONHelper;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class JSONHelperTest extends TestCase
{
    private static DatabaseHelper $databaseHelper;
    private static JSONHelper $jsonHelper;
    private static string $json;
    public function testParseJSONEnrollment() {
        self::$jsonHelper = new JSONHelper();
        self::$json = '[{"subject":"COMS","surname":"Komape","firstName":"Kabelo","unitStatus":"ENROLLED","unitCode":"COMS3007A","studentNumber":"676400","expiryDate":"2020-06-30 00:00:00","sessionCode":"SM1","classSection":"D"},{"subject":"COMS","surname":"Mkhondo","firstName":"Anastacia","unitStatus":"ENROLLED","unitCode":"COMS3007A","studentNumber":"1624102","expiryDate":"2020-06-30 00:00:00","sessionCode":"SM1","classSection":"D"}]';
        self::$databaseHelper = new databaseHelper();
        self::$jsonHelper->parseEnrollmentJSON(self::$json);

        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $result = $enrollmentDatabaseHelper->getEnrollment(676400, "COMS3007A");
        assertEquals($result->getStudentNo(),676400, "correct student number returned");
        assertEquals($result->getName(),"Kabelo", "correct name returned");
        assertEquals($result->getSurname(),"Komape", "correct surname returned");
        assertEquals($result->getExpiryDate(),"2020-06-30 00:00:00", "correct expiry date returned");
        assertEquals($result->getSession(),"SM1", "correct session returned");
        assertEquals($result->getSubject(),"COMS", "correct subject returned");
        assertEquals($result->getClassSection(),"D", "correct class section returned");
        $result = $enrollmentDatabaseHelper->getEnrollment(1624102, "COMS3007A");
        assertEquals($result->getStudentNo(),1624102, "correct student number returned");
        assertEquals($result->getName(),"Anastacia", "correct name returned");
        assertEquals($result->getSurname(),"Mkhondo", "correct surname returned");
        assertEquals($result->getExpiryDate(),"2020-06-30 00:00:00", "correct expiry date returned");
        assertEquals($result->getSession(),"SM1", "correct session returned");
        assertEquals($result->getSubject(),"COMS", "correct subject returned");
        assertEquals($result->getClassSection(),"D", "correct class section returned");

        $enrollmentDatabaseHelper->deleteEnrollment(676400, "COMS3007A");
        $enrollmentDatabaseHelper->deleteEnrollment(1624102, "COMS3007A");
    }

}
