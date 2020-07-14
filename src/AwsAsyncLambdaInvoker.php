<?php declare(strict_types=1);

namespace HashCash;

use AsyncAws\Lambda\LambdaClient;

class AwsAsyncLambdaInvoker implements LambdaInvokerInterface
{
    private LambdaClient $lambdaClient;

    public function __construct(
        LambdaClient $lambdaClient
    ) {
        $this->lambdaClient = $lambdaClient;
    }

    public function invoke(Work $work): WorkResult
    {
        $result = $this->lambdaClient->invoke([
            'FunctionName' => 'app-dev-function',
            'Payload' => json_encode($work->toArray()),
        ]);

        $decodedResponse = json_decode(json_decode($result->getPayload(), true), true);
        return WorkResult::fromArray($decodedResponse);
    }
}
