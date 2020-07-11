<?php declare(strict_types=1);

namespace HashCash\Tests;

use HashCash\Hasher;
use HashCash\Work;
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


    /**
     * @dataProvider data_provider_it_can_get_nonce_from_work
     */
    public function test_it_can_get_nonce_from_work(?int $nonce, Work $work)
    {
        self::assertSame(
            $nonce,
            $this->hasher->getNonceFromWork($work)
        );
    }

    public function data_provider_it_can_get_nonce_from_work()
    {
        yield [
            1744,
            $work = new Work(
                'test',
                10,
                1,
                0,
                0,
                null
            )
        ];

        yield [
            1744,
            $work = new Work(
                'test',
                10,
                2,
                0,
                0,
                null
            )
        ];

        yield [
            1744,
            $work = new Work(
                'test',
                10,
                1,
                0,
                1744,
                null
            )
        ];

        yield [
            1962,
            $work = new Work(
                'test',
                10,
                1,
                0,
                1745,
                null
            )
        ];

        yield [
            2195,
            $work = new Work(
                'test',
                10,
                2,
                1,
                0,
                null
            )
        ];

        yield [
            1744,
            $work = new Work(
                'test',
                10,
                1,
                0,
                0,
                1744
            )
        ];

        yield [
            null,
            $work = new Work(
                'test',
                10,
                1,
                0,
                0,
                1743
            )
        ];

        yield [
            4,
            $work = new Work(
                'test174',
                10,
                1,
                0,
                0,
                null
            )
        ];
    }
}
