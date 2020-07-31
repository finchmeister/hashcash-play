<?php declare(strict_types=1);

namespace HashCash\LambdaInvoker;


use Aws\Lambda\LambdaClient;
use HashCash\Work\Work;
use HashCash\Work\WorkResult;

class AwsLambdaInvoker implements LambdaInvokerInterface
{
    private LambdaClient $lambdaClient;

    public function __construct(
    ) {
        $this->lambdaClient = new LambdaClient([
            'region' => 'eu-west-2',
            'version' => '2015-03-31',
        ]);
    }

    public function invoke(Work $work): WorkResult
    {
        $result = $this->lambdaClient->invoke([
            'FunctionName' => 'app-dev-function',
            'Payload' => json_encode($work->toArray()),
        ]);

        $decodedResponse = json_decode(json_decode($result->get('Payload')->__toString(), true), true);
        return WorkResult::fromArray($decodedResponse);
    }
}
