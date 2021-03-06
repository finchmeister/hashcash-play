<?php declare(strict_types=1);

namespace HashCash\Command;

use Amp\Parallel\Worker;
use Amp\Promise;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParallelTestCommand extends Command
{
    protected static $defaultName = 'hc:test:parallel';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $start = hrtime(true);

        $cost = 15;
        $threads = 8;
        $hasher = new \HashCash\Hasher();
        $challengeString = 'challenge';

        echo <<<STRING
Benchmark
---------
Cost: $cost
Threads: $threads
Challenge String: $challengeString
STRING;


        $promises = [];
        foreach (range(0, $threads - 1) as $thread) {
            $promises[$thread] = Worker\enqueueCallable(
                [$hasher, 'getNonce'], $challengeString, $cost, $threads, $thread
            );
        }

        echo PHP_EOL;
        echo PHP_EOL;
        echo 'Not parallel'.PHP_EOL;
        echo '------------'.PHP_EOL;
        $nonce = $hasher->getNonce($challengeString, $cost);
        \printf("Nonce from %d\n", $nonce);
        $nonParallelTime = (hrtime(true) - $start)/1e+9;
        \printf("Time %s\n", $nonParallelTime);

        echo PHP_EOL;
        \printf("Parallel with %s threads\n", $threads);
        echo '------------'.PHP_EOL;

        $start = hrtime(true);

        $responses = Promise\wait(Promise\first($promises));

        foreach ((array) $responses as $thread => $nonce) {
            \printf("Thread %d , nonce from %d\n", $thread, $nonce);
        }
        $parallelTime = (hrtime(true) - $start)/1e+9;

        \printf("Time %s\n", $parallelTime);
        echo PHP_EOL;
        printf("Parallel %sx faster \n", round($nonParallelTime/$parallelTime, 4));
        return Command::SUCCESS;
    }
}