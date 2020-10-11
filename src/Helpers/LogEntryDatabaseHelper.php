<?php


namespace Helpers;

use Objects\LogEntry;

class LogEntryDatabaseHelper
{

    /**
     * @param LogEntry $logEntry
     */
    public static function insertLogEntry(LogEntry $logEntry)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("INSERT INTO log (user, message) VALUES (:user, :message) ");
        $databaseHelper->bind(':user', $logEntry->getUser());
        $databaseHelper->bind(':message', $logEntry->getMessage());
        $databaseHelper->execute();
    }

    /**
     * @return array|int
     */
    public static function getAllLogEntries()
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("SELECT DISTINCT * FROM log ORDER BY id DESC");
        $result = $databaseHelper->resultSet();
        if ($databaseHelper->rowCount() == 0) {
            return 0;
        } else {
            return $result;
        }
    }

    /**
     * @param $id
     * @return LogEntry|int
     */
    public static function getLogEntry($id)
    {
        $databaseHelper = new DatabaseHelper("coms3-misis");
        $databaseHelper->query("SELECT * FROM log WHERE id = :id LIMIT 0,1");
        $databaseHelper->bind(':id', $id);
        $course = $databaseHelper->single();
        if ($databaseHelper->rowCount() === 0) {
            return 0;
        }
        $logEntry = new LogEntry($course['user'], $course['message'], $course['id']);
        $logEntry->setCreatedAt($course['created_at']);
        return $logEntry;
    }

}