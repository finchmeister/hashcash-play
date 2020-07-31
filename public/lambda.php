<?php

use HashCash\Hasher;
use HashCash\LambdaFunction\LambdaHasher;

require dirname(__DIR__) . '/vendor/autoload.php';

$hasher = new LambdaHasher(new Hasher());

return function ($event) use ($hasher) {
    return $hasher->execute($event);
};
