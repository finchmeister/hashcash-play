<?php declare(strict_types=1);

namespace HashCash\Work;

use Assert\Assertion;
use Webmozart\Assert\Assert;

class Work {
    private const DEFAULT_START = 0;
    private const DEFAULT_TIMEOUT = 6000000;
    private const DEFAULT_CHAIN_ID = 1;

    private string $challengeString;
    private int $cost;
    private int $concurrency;
    private int $concurrencyOffset;
    private int $start;
    private int $timeout;
    private int $chainId;

    public function __construct(
        string $challengeString,
        int $cost,
        int $concurrency,
        int $concurrencyOffset,
        int $start = self::DEFAULT_START,
        int $timeout = self::DEFAULT_TIMEOUT,
        int $chainId = self::DEFAULT_CHAIN_ID
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
        $this->timeout = $timeout;
        $this->chainId = $chainId;
    }

    public static function fromArray(array $array): self
    {
        return new self(
            $array['challengeString'],
            $array['cost'],
            $array['concurrency'],
            $array['concurrencyOffset'],
            $array['start'] ?? self::DEFAULT_START,
            $array['timeout'] ?? self::DEFAULT_TIMEOUT,
            $array['chainId'] ?? self::DEFAULT_CHAIN_ID,
        );
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

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function getChainId(): int
    {
        return $this->chainId;
    }

    public function toArray(): array
    {
        return [
            'challengeString' => $this->challengeString,
            'cost' => $this->cost,
            'concurrency' => $this->concurrency,
            'concurrencyOffset' => $this->concurrencyOffset,
            'start' => $this->start,
            'timeout' => $this->timeout,
            'chainId' => $this->chainId,
        ];
    }
}