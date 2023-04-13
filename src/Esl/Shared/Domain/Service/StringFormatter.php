<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Shared\Domain\Service;

final class StringFormatter
{
    public static function convertUmlauts(string $name)
    {
        $name = str_replace("ä", "ae", $name);
        $name = str_replace("ü", "ue", $name);
        $name = str_replace("ö", "oe", $name);
        $name = str_replace("Ä", "Ae", $name);
        $name = str_replace("Ü", "Ue", $name);
        $name = str_replace("Ö", "Oe", $name);
        $name = str_replace("ß", "ss", $name);
        $name = str_replace("´", "", $name);

        return $name;
    }
}