<?php declare(strict_types=1);

namespace HashCash;

interface LambdaInvokerInterface
{
    public function invoke(Work $work): WorkResult;
}
