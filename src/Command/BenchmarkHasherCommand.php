<?php declare(strict_types=1);

namespace HashCash\Command;

use HashCash\Hasher;
use HashCash\Work\Work;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BenchmarkHasherCommand extends Command
{
    protected static $defaultName = 'hc:bench:hasher';

    private Hasher $hasher;

    public function __construct(Hasher $hasher)
    {
        parent::__construct();
        $this->hasher = $hasher;
    }

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cost = 16;
        //TODO
        $challengeString = 'random challenge';

        $work = new Work(
            $challengeString,
            $cost,
            1,
            0,
            0,
            10
        );

        var_dump($this->hasher->doWork($work)->toArray());

        return Command::SUCCESS;
    }
}