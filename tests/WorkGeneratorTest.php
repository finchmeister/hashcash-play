<?php

namespace HashCash\Tests;


use HashCash\Work;
use HashCash\WorkGenerator;
use PHPUnit\Framework\TestCase;

class WorkGeneratorTest extends TestCase
{
    private WorkGenerator $workGenerator;

    protected function setUp(): void
    {
        $this->workGenerator = new WorkGenerator();
    }

    public function test_it_can_generate_work_for_single_concurrency()
    {
        $expectedWorks = [
            0 => new Work(
                'test',
                10,
                1,
                0,
                0,
                100
            ),
            1 => new Work(
                'test',
                10,
                1,
                0,
                100,
                100
            ),
        ];

        foreach ($this->workGenerator->generate(
            'test',
            10,
            1,
            100
        ) as $i => $work) {
            if (isset($expectedWorks[$i]) === false) {
                break;
            }

            self::assertEquals(
                $expectedWorks[$i],
                $work
            );
        }
    }

    public function test_it_can_generate_work_for_two_concurrency()
    {
        $expectedWorks = [
            0 => new Work(
                'test',
                10,
                2,
                0,
                0,
                100
            ),
            1 => new Work(
                'test',
                10,
                2,
                1,
                0,
                100
            ),
            2 => new Work(
                'test',
                10,
                2,
                0,
                100,
                100
            ),
            3 => new Work(
                'test',
                10,
                2,
                1,
                100,
                100
            ),
        ];

        foreach ($this->workGenerator->generate(
            'test',
            10,
            2,
            100
        ) as $i => $work) {
            if (isset($expectedWorks[$i]) === false) {
                break;
            }

            self::assertEquals(
                $expectedWorks[$i],
                $work
            );
        }
    }
}
