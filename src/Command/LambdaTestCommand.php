<?php declare(strict_types=1);

namespace HashCash\Command;

use HashCash\LambdaInvoker\ExecLambdaInvoker;
use HashCash\Work\Work;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LambdaTestCommand extends Command
{
    protected static $defaultName = 'hc:test:lambda';

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $lambdaInvoker = new ExecLambdaInvoker();

        $payload = [
            'challengeString' => 'challenge',
            'cost' => 15,
            'concurrency' => 1,
            'concurrencyOffset' => 0,
            'start' => 0,
            'timeout' => 60,
        ];

        $workResult = $lambdaInvoker->invoke(Work::fromArray($payload));

        var_dump($workResult->toArray());

        return Command::SUCCESS;
    }
}
