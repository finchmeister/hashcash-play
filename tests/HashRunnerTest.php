<?php declare(strict_types=1);

namespace HashCash\Tests;

use HashCash\Hasher;
use HashCash\HashRunner;
use HashCash\Work;
use PHPUnit\Framework\TestCase;

class HashRunnerTest extends TestCase
{
    private HashRunner $hashRunner;

    protected function setUp(): void
    {
        $this->hashRunner = new HashRunner(new Hasher());
    }

    /**
     * @dataProvider data_provider_it_can_get_nonce
     */
    public function test_it_can_get_nonce(?int $nonce, Work $work)
    {
        self::assertSame(
            $nonce,
            $this->hashRunner->hashRunner($work)
        );
    }

    public function data_provider_it_can_get_nonce()
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
