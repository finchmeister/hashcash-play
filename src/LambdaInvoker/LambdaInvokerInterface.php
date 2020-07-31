<?php declare(strict_types=1);

namespace HashCash\LambdaInvoker;

use HashCash\Work\Work;
use HashCash\Work\WorkResult;

interface LambdaInvokerInterface
{
    public function invoke(Work $work): WorkResult;
}
