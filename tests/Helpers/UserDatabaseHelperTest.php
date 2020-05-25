<?php

use Helpers\UserDatabaseHelper;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class UserDatabaseHelperTest extends TestCase
{

    public function testGetUser() {
        $userDatabaseHelper = new UserDatabaseHelper();
        assertEquals($userDatabaseHelper->getUser("test")->getUserID(),"test", "returns correct user ID");
        assertEquals($userDatabaseHelper->getUser("test")->getPassword(),"test", "returns correct password");
        assertEquals($userDatabaseHelper->getUser("test")->getRole(),"test", "returns correct role");
    }

}
