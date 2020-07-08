<?php

require __DIR__ . '/vendor/autoload.php';

$cost = 16;
$hasher = new \HashCash\Hasher();
$challengeString = 'random challenge';

$hashRunner = new \HashCash\HashRunner($hasher);

$work = new \HashCash\Work(
    'test',
    10,
    1,
    0,
    1963,
    null
);

var_dump($hashRunner->hashRunner($work));