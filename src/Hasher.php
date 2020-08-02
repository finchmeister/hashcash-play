<?php declare(strict_types=1);

namespace HashCash;

use HashCash\Work\Work;
use HashCash\Work\WorkResult;

class Hasher
{
    public const TIMEOUT_BUFFER = 5;

    /**
     * @deprecated
     */
    public function getNonceFromWork(Work $work): ?int
    {
        $i = 1;
        $nonce = $work->getStart();
        while (
            false === $this->hashSatisfiesCost($work->getChallengeString(), $nonce, $work->getCost())
            && ($work->getTimeout() === null || $i < $work->getTimeout())
        ) {
            $i++;
            $nonce = ($work->getConcurrency() * $i) + $work->getConcurrencyOffset() + $work->getStart();
        }

        if ($this->hashSatisfiesCost($work->getChallengeString(), $nonce, $work->getCost())) {
            return $nonce;
        }

        return null;
    }

    public function doWork(Work $work): WorkResult
    {
        $startTime = microtime(true);
        $i = 1;
        $nonce = $work->getStart();
        while (
            false === $this->hashSatisfiesCost($work->getChallengeString(), $nonce, $work->getCost())
            && ((microtime(true) + self::TIMEOUT_BUFFER - $startTime) < $work->getTimeout())
        ) {
            $i++;
            $nonce = ($work->getConcurrency() * $i) + $work->getConcurrencyOffset() + $work->getStart();
        }

        if ($this->hashSatisfiesCost($work->getChallengeString(), $nonce, $work->getCost())) {

            return WorkResult::successful(
                $work,
                $nonce,
                $i,
                (microtime(true) - $startTime),
                $this->getHash($work->getChallengeString(), $nonce)
            );
        }

        return WorkResult::unSuccessful($work, $nonce, $i, (microtime(true) - $startTime));
    }

    public function getNonce(string $challengeString, int $cost, int $threads = 1, int $offset = 0)
    {
        $i = $nonce = 0;
        while (Util::startsWithZeros(Util::hex2Binary($this->getHash($challengeString, $nonce)), $cost) === false) {
            $i++;
            $nonce = ($threads * $i) + $offset;
        }

        return $nonce;
    }

    public function getHash(string $challengeString, int $nonce): string
    {
        return sha1($this->createSubject($challengeString, $nonce));
    }

    public function hashSatisfiesCost(string $challengeString, int $nonce, int $cost): bool
    {
        return Util::startsWithZeros(
            Util::hex2Binary(
                $this->getHash($challengeString, $nonce)
            ),
            $cost
        );
    }

    private function createSubject(string $challengeString, int $nonce): string
    {
        return $challengeString . $nonce;
    }
}
