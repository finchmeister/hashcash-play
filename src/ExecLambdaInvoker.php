<?php declare(strict_types=1);

namespace HashCash;


class ExecLambdaInvoker implements LambdaInvokerInterface
{
    public function invoke(Work $work): WorkResult
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'lambda');
        $cmd = sprintf(
            'aws lambda invoke --function-name app-dev-function --payload \'%s\' --cli-binary-format raw-in-base64-out %s',
            json_encode($work->toArray()),
            $tempFile
        );

        exec($cmd);

        $result = file_get_contents($tempFile);

        $decodedResponse = json_decode(json_decode($result, true), true);
        return WorkResult::fromArray($decodedResponse);
    }
}
