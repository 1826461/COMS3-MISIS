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

    static function setSyncFrequency($frequency)
    {
        if ($frequency == 0) {
            return "off";
        }
        else if ($frequency == 1) {
            return "hourly";
        }
        else if ($frequency == 2) {
            return "daily";
        }
        else if ($frequency == 3) {
            return "weekly";
        }
        else if ($frequency == 4) {
            return "monthly";
        }
        else if ($frequency == 5) {
            return "yearly";
        } else {
            return "none";
        }

    }

    static function setDeleteActive($deleteActive)
    {
        switch ($deleteActive) {
            case 0:
                return "off";
            case 1:
                return "on";
        }
        return "none";
    }
}