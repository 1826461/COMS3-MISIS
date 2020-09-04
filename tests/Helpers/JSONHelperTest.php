<?php

use Helpers\JSONHelper;
use Helpers\EnrollmentDatabaseHelper;

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertTrue;

class JSONHelperTest extends TestCase
{
    public function testAddCourseData() {
        $JSONHelper = new JSONHelper();
        $work = $JSONHelper->addCourseData("COMS1017");
        assertTrue($work, "connected to Virtus API and updated entries");
    }

    public function testUpdateCourseData() {
        $JSONHelper = new JSONHelper();
        $JSONHelper->updateCourseData("COMS1017");
        $work = $JSONHelper->updateCourseData("COMS1017");
        assertTrue($work, "connected to Virtus API and updated entries");
        $enrollmentDatabaseHelper = new EnrollmentDatabaseHelper();
        $enrollmentDatabaseHelper->deleteAllCourseEnrollments("COMS1017");
    }


}
