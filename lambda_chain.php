<?php

require_once __DIR__ . '/vendor/autoload.php';

use AsyncAws\Lambda\LambdaClient;

$config = \AsyncAws\Core\Configuration::create([
    'region' => 'eu-west-2',
]);
$lambdaClient = new LambdaClient($config);
$workGenerator = new \HashCash\Work\WorkGenerator();
$lambdaInvoker = new \HashCash\LambdaInvoker\AwsAsyncLambdaInvoker($lambdaClient);
$lambdaChainRunner = new \HashCash\LambdaInvoker\LambdaChainRunner(
    $lambdaInvoker,
    $workGenerator
);
$payload = [
    'challengeString' => 'challenge',
    'cost' => 20,
    'concurrency' => 1,
    'concurrencyOffset' => 0,
    'start' => 0,
    'timeout' => 60,
];

$workResult = $lambdaChainRunner->run(\HashCash\Work\Work::fromArray($payload));

var_dump($workResult);