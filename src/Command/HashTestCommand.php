<?php declare(strict_types=1);

namespace HashCash\Command;

use HashCash\Hasher;
use HashCash\Work\Work;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HashTestCommand extends Command
{
    protected static $defaultName = 'hc:test:hash';

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
        $cost = 15;
        $challengeString = 'challenge';

        $work = new Work(
            $challengeString,
            $cost,
            1,
            0,
            0,
            60
        );

        var_dump($this->hasher->doWork($work)->toArray());

        return Command::SUCCESS;
    }
}