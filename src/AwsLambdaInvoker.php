<?php declare(strict_types=1);

namespace HashCash;


use Aws\Lambda\LambdaClient;

class AwsLambdaInvoker implements LambdaInvokerInterface
{
    private LambdaClient $lambdaClient;

    public function __construct(
    ) {
        $this->lambdaClient = $client = new LambdaClient([
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
