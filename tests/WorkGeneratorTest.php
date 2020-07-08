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

    public function test_it_can_generate_work()
    {
        $work1 = new Work(
            'test',
            10,
            1,
            0,
            0,
            100
        );
        $work2 = new Work(
            'test',
            10,
            1,
            0,
            101,
            100
        );

//        foreach ($this->workGenerator->generate(
//            'test',
//            10,
//            1,
//            100
//        ))


//        self::assertSame();
    }
}
