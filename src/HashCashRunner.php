<?php declare(strict_types=1);

namespace HashCash;

class HashCashRunner
{
    private Hasher $hasher;

    public function __construct(
        Hasher $hasher
    ) {
        $this->hasher = $hasher;
    }

    public function run(
        string $challengeString,
        int $cost,
        int $concurrency
    ) {
        // add X works to queue

        // Once null response comes back add another to queue

        // Once non null response comes back, clear queue and exit
    }
}
