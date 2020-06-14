<?php


namespace Helpers;


class TextHelper
{
    /**
     * @param $text
     * @return string
     */
    static function getSpecialChars($text)
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}