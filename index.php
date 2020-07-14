<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$hasher = new \HashCash\LambdaHasher(new \HashCash\Hasher());

return function ($event) use ($hasher) {
    return $hasher->execute($event);
};
