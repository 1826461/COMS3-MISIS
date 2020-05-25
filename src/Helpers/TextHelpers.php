<?php


namespace Helpers;


class TextHelpers
{
    static function returnSpecialChars($text)
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}