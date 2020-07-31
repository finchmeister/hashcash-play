<?php

require_once __DIR__ . '/vendor/autoload.php';

$lambdaInvoker = new \HashCash\LambdaInvoker\ExecLambdaInvoker();

$payload = [
    'challengeString' => 'challenge',
    'cost' => 10,
    'concurrency' => 1,
    'concurrencyOffset' => 0,
    'start' => 0,
    'timeout' => 60,
];

$workResult = $lambdaInvoker->invoke(\HashCash\Work\Work::fromArray($payload));

var_dump($workResult);