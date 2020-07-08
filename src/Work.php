<?php declare(strict_types=1);

namespace HashCash;

use Assert\Assertion;
use Webmozart\Assert\Assert;

class Work {
    private string $challengeString;
    private int $cost;
    private int $concurrency;
    private int $concurrencyOffset;
    private int $start;
    private ?int $iterations;

    public function __construct(
        string $challengeString,
        int $cost,
        int $concurrency,
        int $concurrencyOffset,
        int $start = 0,
        ?int $iterations = null
    ) {
        $this->challengeString = $challengeString;

        Assert::greaterThan($cost, 0);
        $this->cost = $cost;

        Assert::greaterThan($concurrency, 0);
        $this->concurrency = $concurrency;

        Assert::greaterThanEq($concurrencyOffset, 0);
        Assert::lessThan($concurrencyOffset, $concurrency);
        $this->concurrencyOffset = $concurrencyOffset;
        $this->start = $start;
        $this->iterations = $iterations;
    }

    public function getChallengeString(): string
    {
        return $this->challengeString;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function getConcurrency(): int
    {
        return $this->concurrency;
    }

    public function getConcurrencyOffset(): int
    {
        return $this->concurrencyOffset;
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function getIterations(): ?int
    {
        return $this->iterations;
    }
}