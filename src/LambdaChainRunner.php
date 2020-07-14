<?php declare(strict_types=1);

namespace HashCash;

class LambdaChainRunner
{
    private LambdaInvokerInterface $lambdaInvoker;
    /**
     * @var WorkGenerator
     */
    private WorkGenerator $workGenerator;

    public function __construct(
        LambdaInvokerInterface $lambdaInvoker,
        WorkGenerator $workGenerator
    ) {
        $this->lambdaInvoker = $lambdaInvoker;
        $this->workGenerator = $workGenerator;
    }

    public function run(Work $work): WorkResult
    {
        do {
            $workResult = $this->lambdaInvoker->invoke($work);
            $work = $this->workGenerator->getNext($workResult);
        } while ($workResult->isSuccess() === false);

        return $workResult;
    }
}
