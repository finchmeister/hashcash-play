<?php declare(strict_types=1);

namespace HashCash;

use Webmozart\Assert\Assert;

class Util
{
    public static function hex2Binary(string $hex)
    {
        return implode('', array_map(function ($hex) {
            return sprintf('%08d', decbin(hexdec($hex)));
        }, str_split($hex, 2)));
    }

    public static function startsWithZeros(string $string, int $numberOfZeroes)
    {
        Assert::greaterThan($numberOfZeroes, 0);
        return strpos($string, str_repeat('0', $numberOfZeroes)) === 0;
    }
}
