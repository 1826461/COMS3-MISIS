<?php

use Objects\User;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class UserTest extends TestCase
{
    private static User $user;

    public function testUserConstructor() {
        self::$user = new User(1, "admin", "admin");
        assertEquals(1, self::$user->userID, "created userID equals expected value");
        assertEquals("admin", self::$user->password, "created password equals expected value");
        assertEquals("admin", self::$user->role, "created role equals expected value");
    }

    public function testGetUserID()
    {
        self::$user = new User(1, "admin", "admin");
        assertEquals(1, self::$user->getUserID(),
            "userID equals expected value");

    }
    public function testSetUserID()
    {
        self::$user->setUserID(2);
        assertEquals(2, self::$user->getUserID(),
            "new userID equals expected value");

    }
    public function testGetPassword()
    {
        self::$user = new User(1, "admin", "admin");
        assertEquals("admin", self::$user->getPassword(),
            "password equals expected value");

    }
    public function testSetPassword()
    {
        self::$user->setPassword("adminChanged");
        assertEquals("adminChanged", self::$user->getPassword(),
            "new password equals expected value");

    }

    public function testGetRole()
    {
        self::$user = new User(1, "admin", "admin");
        assertEquals("admin", self::$user->getRole(),
            "role equals expected value");

    }
    public function testSetRole()
    {
        self::$user->setRole("user");
        assertEquals("user", self::$user->getRole(),
            "new role equals expected value");

    }

}
