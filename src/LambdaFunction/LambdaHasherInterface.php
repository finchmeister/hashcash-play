<?php declare(strict_types=1);

namespace HashCash\LambdaFunction;

interface LambdaHasherInterface
{
    public function execute(array $event): string;
}
