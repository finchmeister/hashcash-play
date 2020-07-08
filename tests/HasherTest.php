<?php declare(strict_types=1);

namespace HashCash\Tests;

use HashCash\Hasher;
use PHPUnit\Framework\TestCase;

class HasherTest extends TestCase
{
    private Hasher $hasher;

    protected function setUp(): void
    {
        $this->hasher = new Hasher();
    }

    /**
     * @dataProvider data_provider_hash_satisfies_cost
     */
    public function test_hash_satisfies_cost(
        bool $expected,
        string $challengeString,
        int $nonce,
        int $cost
    ) {
        self::assertSame(
            $expected,
            $this->hasher->hashSatisfiesCost($challengeString, $nonce, $cost)
        );
    }

    public function data_provider_hash_satisfies_cost(): array
    {
        return [
            [true, 'test', 1744, 12],
            [false, 'test', 1745, 12],
            [false, 'test', 1744, 13],
            [false, 'random challenge', 588527, 18],
            [true, 'random challenge', 588528, 18],
            [false, 'random challenge', 588529, 18],
        ];
    }
}
