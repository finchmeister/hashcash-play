<?php declare(strict_types=1);

namespace HashCash\Command;

use Amp\Parallel\Worker;
use Amp\Promise;
use HashCash\LambdaInvoker\LambdaChainRunner;
use HashCash\Work\Work;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParallelLambdaTestCommand extends Command
{
    protected static $defaultName = 'hc:test:lambda-parallel';

    private LambdaChainRunner $lambdaChainRunner;

    public function __construct(LambdaChainRunner $lambdaChainRunner)
    {
        $this->lambdaChainRunner = $lambdaChainRunner;
        parent::__construct(null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $challengeString = 'challenge';
        $cost = 30;
        $concurrency = 32;

        $output->writeln("Benchmark
---------
Cost: {$cost}
Concurrency: {$concurrency}
Challenge String: {$challengeString}
");

        $promises = [];
        foreach (range(0, $concurrency - 1) as $concurrencyOffset) {
            $work = new Work(
                $challengeString,
                $cost,
                $concurrency,
                $concurrencyOffset,
                0,
                60
            );
            $promises[$concurrencyOffset] = Worker\enqueueCallable(
                [$this->lambdaChainRunner, 'run'], $work
            );
        }

        $start = hrtime(true);

        /** @var \HashCash\Work\WorkResult $workResult */
        $workResult = Promise\wait(Promise\first($promises));
        var_dump($workResult->toArray());

        $parallelTime = (hrtime(true) - $start)/1e+9;

        $output->writeln(\printf("Time %s\n", $parallelTime));

        return Command::SUCCESS;
    }
}