<?php declare(strict_types=1);

namespace HashCash;

class HashRunner
{
    private Hasher $hasher;

    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    public function hashRunner(Work $work): ?int
    {
        $i = 0;
        $nonce = $work->getStart();
        while (
            false === $this->hasher->hashSatisfiesCost($work->getChallengeString(), $nonce, $work->getCost())
            && ($work->getIterations() === null || $i < $work->getIterations())
        ) {
            $i++;
            $nonce = ($work->getConcurrency() * $i) + $work->getConcurrencyOffset() + $work->getStart();
        }

        if ($this->hasher->hashSatisfiesCost($work->getChallengeString(), $nonce, $work->getCost())) {
            return $nonce;
        }

        return null;
    }
}
