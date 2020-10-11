<?php

use Objects\LogEntry;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class LogEntryTest extends TestCase
{
    private static LogEntry $logEntry;

    public function testLogEntryConstructor() {
        self::$logEntry = new LogEntry("admin", "Test Message");
        assertEquals("admin", self::$logEntry->user, "created user equals expected value");
        assertEquals("Test Message", self::$logEntry->message, "created message equals expected value");
    }

    public function testGetUser()
    {
        assertEquals("admin", self::$logEntry->getUser(),
            "user equals expected value");

    }
    public function testSetUser()
    {
        self::$logEntry->setUser("admin2");
        assertEquals("admin2", self::$logEntry->getUser(),
            "new user equals expected value");

    }
    public function testGetMessage()
    {
        assertEquals("Test Message", self::$logEntry->getMessage(),
            "message equals expected value");

    }
    public function testSetMessage()
    {
        self::$logEntry->setMessage("Test Message 2");
        assertEquals("Test Message 2", self::$logEntry->getMessage(),
            "new message equals expected value");

    }

    public function testGetId()
    {
        assertEquals(0, self::$logEntry->getId(),
            "id equals expected value");

    }

    public function testSetId()
    {
        self::$logEntry->setId(100);
        assertEquals(100, self::$logEntry->getId(),
            "new id equals expected value");

    }

    public function testSetCreatedAt()
    {
        self::$logEntry->setCreatedAt("some time");
        assertEquals("some time", self::$logEntry->getCreatedAt(),
            "created at equals expected value");

    }
}
