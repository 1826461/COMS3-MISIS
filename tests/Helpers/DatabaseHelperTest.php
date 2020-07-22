<?php

use Helpers\DatabaseHelper;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertNotNull;

class DatabaseHelperTest extends TestCase
{
    private static DatabaseHelper $databaseHelper;

    public function testDatabaseConstructor() {
        self::$databaseHelper = new DatabaseHelper("coms3-misis");
        assertNull(self::$databaseHelper->error, "database connected successfully");
    }

}
