<?php

use Helpers\DatabaseHelper;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertNull;

class DatabaseHelperTest extends TestCase
{
    private static DatabaseHelper $databaseHelper;

    public function testDatabaseConstructor() {
        self::$databaseHelper = new databaseHelper();
        assertNull(self::$databaseHelper->error, "database connected successfully");
    }

}
