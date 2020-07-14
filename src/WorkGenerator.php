<?php declare(strict_types=1);

namespace HashCash;

class WorkGenerator
{
    public function generate(string $challengeString, int $cost, int $concurrency, int $iterationsPerWork)
    {
        $start = 0;
        do {
            for ($concurrencyOffset = 0; $concurrencyOffset < $concurrency; $concurrencyOffset++) {
                yield new Work(
                    $challengeString,
                    $cost,
                    $concurrency,
                    $concurrencyOffset,
                    $start,
                    $iterationsPerWork
                );
            }
            $start = $start + $iterationsPerWork;
        } while (true);
    }

    public function getNext(WorkResult $workResult): Work
    {
        $previousWork = $workResult->getWork();

        return new Work(
            $previousWork->getChallengeString(),
            $previousWork->getCost(),
            $previousWork->getConcurrency(),
            $previousWork->getConcurrencyOffset(),
            $workResult->getLastNonce() + 1,
            $previousWork->getTimeout(),
            $previousWork->getChainId() + 1,
        );
    }
}
