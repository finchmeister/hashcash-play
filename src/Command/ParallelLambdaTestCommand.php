<?php declare(strict_types=1);

namespace HashCash\Command;

use Amp\Parallel\Worker;
use Amp\Promise;
use HashCash\LambdaInvoker\LambdaChainRunner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParallelLambdaTestCommand extends Command
{
    protected static $defaultName = 'hc:test:parallel';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $workGenerator = new \HashCash\Work\WorkGenerator();
        $lambdaInvoker = new \HashCash\LambdaInvoker\ExecLambdaInvoker();
        $lambdaChainRunner = new LambdaChainRunner(
            $lambdaInvoker,
            $workGenerator
        );

        $start = hrtime(true);

        $challengeString = 'challenge';
        $cost = 30;
        $concurrency = 25;
        $start = 0;
        $timeout = 60;
        $testSerial = false;

        echo <<<STRING
Benchmark
---------
Cost: {$cost}
Concurrency: {$concurrency}
Challenge String: {$challengeString}
STRING;

        if ($testSerial) {
            echo PHP_EOL;
            echo PHP_EOL;
            echo 'Not parallel'.PHP_EOL;
            echo '------------'.PHP_EOL;
            $workResult = $lambdaChainRunner->run(new \HashCash\Work\Work(
                $challengeString,
                $cost,
                1,
                0
            ));
            \printf("Nonce from %d\n", $workResult->getLastNonce());
            $nonParallelTime = (hrtime(true) - $start)/1e+9;
            \printf("Time %s\n", $nonParallelTime);
        }

        $promises = [];
        foreach (range(0, $concurrency - 1) as $concurrencyOffset) {
            $work = new \HashCash\Work\Work(
                $challengeString,
                $cost,
                $concurrency,
                $concurrencyOffset,
                0,
                60
            );
            $promises[$concurrencyOffset] = Worker\enqueueCallable(
                [$lambdaChainRunner, 'run'], $work
            );
        }

        echo PHP_EOL;
        \printf("Parallel with %s threads\n", $concurrency);
        echo '------------'.PHP_EOL;

        $start = hrtime(true);

        /** @var \HashCash\Work\WorkResult $response */
        $workResult = Promise\wait(Promise\first($promises));
        var_dump($workResult);

//foreach ((array) $responses as $concurrencyOffset => $workResult) {
//    \printf("Thread %d , nonce from %d\n", $concurrencyOffset, $workResult->getLastNonce());
//}
        $parallelTime = (hrtime(true) - $start)/1e+9;

        \printf("Time %s\n", $parallelTime);
        echo PHP_EOL;
//printf("Parallel %sx faster \n", round($nonParallelTime/$parallelTime, 4));

        return Command::SUCCESS;
    }
}