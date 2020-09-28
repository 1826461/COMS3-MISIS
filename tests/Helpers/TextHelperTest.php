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

    public function testSetDeleteActive0() {
        $textHelper = new TextHelper();
        assertEquals($textHelper->setDeleteActive(0),"off", "returns correct delete active");
    }

    public function testSetDeleteActive1() {
        $textHelper = new TextHelper();
        assertEquals($textHelper->setDeleteActive(1),"on", "returns correct delete active");
    }

    public function testSetDeleteActiveOther() {
        $textHelper = new TextHelper();
        assertEquals($textHelper->setDeleteActive(10),"none", "returns correct delete active");
    }

    public function testSetSyncFrequency0() {
        $textHelper = new TextHelper();
        assertEquals($textHelper->setSyncFrequency(0),"off", "returns correct sync frequency");
    }

    public function testSetSyncFrequency1() {
        $textHelper = new TextHelper();
        assertEquals($textHelper->setSyncFrequency(1),"hourly", "returns correct sync frequency");
    }

    public function testSetSyncFrequency2() {
        $textHelper = new TextHelper();
        assertEquals($textHelper->setSyncFrequency(2),"daily", "returns correct sync frequency");
    }

    public function testSetSyncFrequency3() {
        $textHelper = new TextHelper();
        assertEquals($textHelper->setSyncFrequency(3),"monthly", "returns correct sync frequency");
    }

    public function testSetSyncFrequency4() {
        $textHelper = new TextHelper();
        assertEquals($textHelper->setSyncFrequency(4),"yearly", "returns correct sync frequency");
    }

    public function testSetSyncFrequencyOther() {
        $textHelper = new TextHelper();
        assertEquals($textHelper->setSyncFrequency(10),"none", "returns correct sync frequency");
    }
}
