<?php declare(strict_types=1);

namespace HashCash\Tests;

use HashCash\Util;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    /**
     * @dataProvider data_provider_starts_with_zeros
     */
    public function test_starts_with_zeros(bool $expected, string $string, int $zeros): void
    {
        self::assertSame($expected, Util::startsWithZeros($string, $zeros));
    }

    public function data_provider_starts_with_zeros(): array
    {
        return [
            [true, '000112101', 1],
            [true, '000112101', 2],
            [true, '000112101', 3],
            [false, '000112101', 4],
            [false, '1000112101', 1],
            [false, '1', 1],
            [true, '0', 1],
            [false, '0', 2],
        ];
    }

    /**
     * @dataProvider data_provider_hex_2_binary
     */
    public function test_hex_2_binary(string $expected, string $hex): void
    {
        self::assertSame($expected, Util::hex2Binary($hex));
    }

    public function data_provider_hex_2_binary(): array
    {
        return [
            ['01011010', '5A'],
            ['0101101001011010', '5A5A'],
            ['1001101010101111', '9aaf'],
            ['00001001', '9'],
        ];
    }
}
