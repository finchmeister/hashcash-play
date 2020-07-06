<?php declare(strict_types=1);

namespace HashCash;

use Exception;

class Hasher
{
    public function hash(string $challengeString, int $cost, int $threads = 1, int $offset = 0)
    {
        $i = $nonce = 0;
        while ($this->startsWithZeros($this->hex2Binary(sha1($challengeString.$nonce)), $cost) === false) {
            $i++;
            $nonce = ($threads * $i) + $offset;
//            printf('Nonce %d, offset %d'.PHP_EOL, $nonce, $offset);
        }

        return $nonce;

//        var_dump('Time ' . (hrtime(true) - $start)/1e+9);
//        var_dump($nonce);
//        var_dump($i);
//        var_dump(sha1($challengeString.$nonce));
//        var_dump($this->hex2Binary(sha1($challengeString.$nonce)));
    }

    public function validate(string $challengeString, int $cost, int $nonce)
    {
        if ($this->startsWithZeros($this->hex2Binary(sha1($challengeString.$nonce)), $cost) === false) {
            throw new Exception('Invalid nonce');
        };
    }

    public function hex2Binary(string $hex)
    {
        return implode('', array_map(function ($hex) {
            return sprintf('%08d', decbin(hexdec($hex)));
        }, str_split($hex, 2)));
    }

    public function startsWithZeros(string $string, int $numberOfZeroes)
    {
        return strpos($string, str_repeat('0', $numberOfZeroes)) === 0;
    }
}
