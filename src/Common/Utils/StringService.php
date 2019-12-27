<?php

declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Utils;

class StringService
{
    public static function utf8Encode(string $string): string
    {
        $anEncoding = mb_detect_encoding($string, ['UTF-8', 'CP1252', 'ISO-8859-15', 'ISO-8859-1'], true);
        if ('UTF-8' !== $anEncoding) {
            return iconv('CP1252', 'UTF-8', $string);
        }

        return $string;
    }

    public static function utf8Decode(string $string): string
    {
        if (mb_detect_encoding($string, 'UTF-8', true)) {
            $string = utf8_decode($string);
        }

        return $string;
    }

    public static function classNameOfFunctionNameWithBoundedContextAndModule($string): string
    {
        $path = explode('\\', $string);
        $class =  array_pop($path);
        if ($path[1] === 'Module') {
            return 'auditor_framework'.$path[2].$class;
        } else {
            return 'auditor_framework'.$path[1].$class;
        }
    }

    public static function snakeCaseToCamelCase($string, $capitalizeFirstCharacter = false): string
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }
}
