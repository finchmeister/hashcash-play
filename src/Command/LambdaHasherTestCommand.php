<?php declare(strict_types=1);

namespace HashCash\Command;

use HashCash\LambdaFunction\LambdaHasher;
use HashCash\LambdaFunction\LambdaHasherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LambdaHasherTestCommand extends Command
{
    protected static $defaultName = 'hc:test:lambda-hasher';
    /**
     * @var LambdaHasher
     */
    private LambdaHasherInterface $lambdaHasher;

    public function __construct(LambdaHasher $lambdaHasher)
    {
        $this->lambdaHasher = $lambdaHasher;
        parent::__construct();
    }

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->lambdaHasher->execute([
            'challengeString' => 'challenge',
            'cost' => 25,
            'concurrency' => 1,
            'concurrencyOffset' => 0,
            'start' => 0,
            'timeout' => 15,
            'lambdaConcurrency' => 6,
        ]);

        $output->writeln($response);

        return Command::SUCCESS;
    }
}
