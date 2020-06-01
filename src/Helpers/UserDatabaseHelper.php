<?php


namespace Helpers;

use Objects\User;
use PDOException;

class UserDatabaseHelper
{

    public static function getUser($username) {
        $databaseHelper = new DatabaseHelper();

        try {
            $databaseHelper->query("SELECT * FROM users WHERE userID = ? LIMIT 0,1");
            $databaseHelper->bind(1, $username);
            $user = $databaseHelper->single();
            if ($databaseHelper->rowCount() === 0) {
                return 0;
            }
        } catch (PDOException $e) {
            $databaseHelper->error = $e->getMessage();
        }
        return new User($user['userID'], $user['password'], $user['role']);
    }
}