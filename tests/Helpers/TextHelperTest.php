<?php

use Helpers\TextHelper;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class TextHelperTest extends TestCase
{
    public function testGetSpecialChars() {
        $textHelper = new TextHelper();
        assertEquals($textHelper->getSpecialChars("&"),"&amp;", "returns correct special characters");
        assertEquals($textHelper->getSpecialChars("test&"),"test&amp;", "returns correct special characters");
    }
}
