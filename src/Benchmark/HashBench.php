<?php

namespace HashCash\Benchmark;

use HashCash\Hasher;
use HashCash\LambdaFunction\LambdaHasher;

/**
 * @Iterations(5)
 * @BeforeMethods({"init"})
 */
class HashBench
{
    private LambdaHasher $lambdaHasher;

    public function init()
    {
        $this->lambdaHasher = new LambdaHasher(new Hasher());
    }

    public function benchHash()
    {
        $this->lambdaHasher->execute([
            'challengeString' => 'challenge',
            'cost' => 15,
            'concurrency' => 1,
            'concurrencyOffset' => 0,
            'start' => 0,
            'timeout' => 60,
        ]);
    }
}