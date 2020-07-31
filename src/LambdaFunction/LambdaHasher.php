<?php declare(strict_types=1);

namespace HashCash\LambdaFunction;

use HashCash\Hasher;
use HashCash\Work\Work;

class LambdaHasher
{
    private Hasher $hasher;

    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    public function execute(array $event): string
    {
        $work = Work::fromArray($event);
        $workResult = $this->hasher->doWork($work);
        return json_encode($workResult->toArray());
    }

}
