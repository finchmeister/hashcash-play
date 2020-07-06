<?php

$challengeString = 'ranadom2';

$nonce = 0;

$cost = 22;

$start = hrtime(true);
while (starts_with_zeros(hex2Binary(sha1($challengeString.$nonce)), $cost) === false) {
    $nonce++;
}

var_dump('Time ' . (hrtime(true) - $start)/1e+9);
var_dump($nonce);
var_dump(sha1($challengeString.$nonce));
var_dump(hex2Binary(sha1($challengeString.$nonce)));

function hex2Binary(string $hex)
{
    return implode('', array_map(function ($hex) {
        return sprintf('%08d', decbin(hexdec($hex)));
    }, str_split($hex, 2)));
}

function starts_with_zeros(string $string, int $numberOfZeroes)
{
    return strpos($string, str_repeat('0', $numberOfZeroes)) === 0;
}
