<?php declare(strict_types=1);

namespace HashCash\LambdaFunction;

use HashCash\Hasher;
use HashCash\Work\Work;
use Amp\Parallel\Worker;
use Amp\Promise;
use HashCash\Work\WorkResult;

class LambdaHasherParallel implements LambdaHasherInterface
{
    private Hasher $hasher;

    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    public function execute(array $event): string
    {
        $providedWork = Work::fromArray($event);

        $lambdaConcurrency = $event['lambdaConcurrency'] ?? 1;

        $promises = [];
        foreach (range(0, $lambdaConcurrency - 1) as $lambdaConcurrencyOffset) {
            $concurrency = $event['concurrency'] * $lambdaConcurrency;
            $concurrencyOffset = $event['concurrencyOffset'] + ($lambdaConcurrencyOffset * $event['concurrency']);
//            printf(
//                "Lambda Concurrency Offset: %s\nConcurrency: %s\nConcurrency offset: %s\n",
//                $lambdaConcurrencyOffset,
//                $concurrency,
//                $concurrencyOffset
//            );

            $work = new Work(
                $event['challengeString'],
                $event['cost'],
                $concurrency,
                $concurrencyOffset,
                $event['start'],
                $event['timeout'],
            );
            $promises[$concurrencyOffset] = Worker\enqueueCallable(
                [$this->hasher, 'doWork'], $work
            );
        }

        /** @var WorkResult[] $workResults */
        $workResults = Promise\wait(Promise\all($promises));

        $finalisedWorkResult = null;
        $lastNonce = PHP_INT_MAX;
        $iterations = 0;
        $timeTaken = 0;
        $results = [];
        foreach ($workResults as $concurrencyOffset => $workResult) {
            $iterations += $workResult->getIterations();

            if ($workResult->getLastNonce() < $lastNonce) {
                $lastNonce = $workResult->getLastNonce();
            }

            if ($workResult->getTimeTaken() > $timeTaken) {
                $timeTaken = $workResult->getTimeTaken();
            }

            $results[$workResult->getLastNonce()] = $workResult->getHash();
        }

        ksort($results);

        foreach ($results as $nonce => $hash) {
            if ($hash !== null) {
                $finalisedWorkResult = WorkResult::successful(
                    $providedWork,
                    $lastNonce,
                    $iterations,
                    $timeTaken,
                    $hash
                );
                break;
            }
        }

        if ($finalisedWorkResult === null) {
            $finalisedWorkResult = WorkResult::unSuccessful(
                $providedWork,
                $lastNonce,
                $iterations,
                $timeTaken
            );
        }

        return json_encode($finalisedWorkResult->toArray());
    }
}
