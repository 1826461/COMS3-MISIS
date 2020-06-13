<?php


namespace Helpers;


class TextHelper
{
    static function getSpecialChars($text)
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}