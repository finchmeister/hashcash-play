<?php

require_once __DIR__ . '/vendor/autoload.php';

use Amp\Parallel\Worker;
use Amp\Promise;


$start = hrtime(true);

$cost = 20;
$threads = 8;
$hasher = new \HashCash\Hasher();
$challengeString = 'random challenge';

echo <<<STRING
Benchmark
---------
Cost: $cost
Threads: $threads
Challenge String: $challengeString
STRING;


$promises = [];
foreach (range(0, $threads - 1) as $thread) {
    $promises[$thread] = Worker\enqueueCallable(
        [$hasher, 'hash'], $challengeString, $cost, $threads, $thread
    );
}

echo PHP_EOL;
echo PHP_EOL;
echo 'Not parallel'.PHP_EOL;
echo '------------'.PHP_EOL;
$nonce = $hasher->hash($challengeString, $cost);
$hasher->validate($challengeString, $cost, $nonce);
\printf("Nonce from %d\n", $nonce);
$nonParallelTime = (hrtime(true) - $start)/1e+9;
\printf("Time %s\n", $nonParallelTime);

echo PHP_EOL;
\printf("Parallel with %s threads\n", $threads);
echo '------------'.PHP_EOL;

$start = hrtime(true);

$responses = Promise\wait(Promise\first($promises));

foreach ((array) $responses as $thread => $nonce) {
    \printf("Thread %d , nonce from %d\n", $thread, $nonce);
    $hasher->validate($challengeString, $cost, $nonce);
}
$parallelTime = (hrtime(true) - $start)/1e+9;

\printf("Time %s\n", $parallelTime);
echo PHP_EOL;
printf("Parallel %sx faster \n", round($nonParallelTime/$parallelTime, 4));