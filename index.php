<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$cost = 15;
$hasher = new \HashCash\Hasher();
$challengeString = 'random challenge';

return function ($event) use ($hasher, $challengeString, $cost) {
    return $hasher->getNonce(
        $event['challengeString'] ?? $challengeString,
        $event['cost'] ?? $cost,
        $event['threads'] ?? 1,
        $event['offset'] ?? 0,
    );
};
