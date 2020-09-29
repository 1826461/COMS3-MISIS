<?php

use Helpers\LogEntryDatabaseHelper;
use Helpers\DatabaseHelper;
use Objects\LogEntry;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertGreaterThan;

class LogEntryDatabaseHelperTest extends TestCase
{

    public function testGetAllLogEntriesEmpty() {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("TRUNCATE TABLE log");
        $databaseHelper->execute();
        $databaseHelper->query("ALTER table log auto_increment = 0");
        $databaseHelper->execute();
        $logEntryDatabaseHelper = new LogEntryDatabaseHelper();
        assertEquals($logEntryDatabaseHelper->getAllLogEntries(), 0, "returns correct log count");
    }

    public function testInsertLogEntry() {
        $logEntryDatabaseHelper = new LogEntryDatabaseHelper();
        $logEntry = new LogEntry("admin", "Test Message");
        $logEntryDatabaseHelper->insertLogEntry($logEntry);
        assertEquals($logEntryDatabaseHelper->getLogEntry(1)->getId(),1, "returns correct ID");
        assertEquals($logEntryDatabaseHelper->getLogEntry(1)->getUser(),"admin", "returns correct user");
        assertEquals($logEntryDatabaseHelper->getLogEntry(1)->getMessage(),"Test Message", "returns correct message");
    }

    public function testGetLogEntry() {
        $logEntryDatabaseHelper = new LogEntryDatabaseHelper();
        assertEquals($logEntryDatabaseHelper->getLogEntry(1)->getId(),1, "returns correct ID");
        assertEquals($logEntryDatabaseHelper->getLogEntry(1)->getUser(),"admin", "returns correct user");
        assertEquals($logEntryDatabaseHelper->getLogEntry(1)->getMessage(),"Test Message", "returns correct message");

    }

    public function testGetLogEntryNotExist()
    {
        $logEntryDatabaseHelper = new LogEntryDatabaseHelper();
        assertEquals($logEntryDatabaseHelper->getLogEntry(2), 0, "returns 0");
    }

    public function testGetAllLogEntries() {
        $logEntryDatabaseHelper = new LogEntryDatabaseHelper();
        assertEquals(sizeof($logEntryDatabaseHelper->getAllLogEntries()), 1, "returns correct log count");
    }

}
