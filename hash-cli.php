<?php

require __DIR__ . '/vendor/autoload.php';

$cost = 16;
$hasher = new \HashCash\Hasher();
$challengeString = 'random challenge';

$work = new \HashCash\Work(
    'test',
    10,
    1,
    0,
    0,
    10
);

var_dump($hasher->doWork($work)->toArray());