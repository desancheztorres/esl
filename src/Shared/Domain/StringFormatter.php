<?php

declare(strict_types=1);

namespace Arcmedia\Shared\Domain;

final class StringFormatter
{
    public static function convertUmlauts(string $attribute)
    {
        $attribute = str_replace("ä", "ae", $attribute);
        $attribute = str_replace("ü", "ue", $attribute);
        $attribute = str_replace("ö", "oe", $attribute);
        $attribute = str_replace("Ä", "Ae", $attribute);
        $attribute = str_replace("Ü", "Ue", $attribute);
        $attribute = str_replace("Ö", "Oe", $attribute);
        $attribute = str_replace("ß", "ss", $attribute);
        $attribute = str_replace("´", "", $attribute);

        return $attribute;
    }
}