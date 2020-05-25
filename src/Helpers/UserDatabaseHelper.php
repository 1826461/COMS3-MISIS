<?php


namespace Helpers;

use Objects\User;

class UserDatabaseHelper
{

    public static function getUser($username) {
        $databaseHelper = new DatabaseHelper();
        $databaseHelper->query("SELECT * FROM users WHERE userID = ? LIMIT 0,1");
        $databaseHelper->bind(1, $username);
        $user = $databaseHelper->single();
        if ($databaseHelper->rowCount() === 0) {
            return 0;
        }
        return new User($user['userID'], $user['password'], $user['role']);
    }
}