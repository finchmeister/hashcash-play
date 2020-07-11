<?php declare(strict_types=1);

namespace HashCash;

use Exception;

class Hasher
{
    public function getNonceFromWork(Work $work): ?int
    {
        $i = 1;
        $nonce = $work->getStart();
        while (
            false === $this->hashSatisfiesCost($work->getChallengeString(), $nonce, $work->getCost())
            && ($work->getIterations() === null || $i < $work->getIterations())
        ) {
            $i++;
            $nonce = ($work->getConcurrency() * $i) + $work->getConcurrencyOffset() + $work->getStart();
        }

        if ($this->hashSatisfiesCost($work->getChallengeString(), $nonce, $work->getCost())) {
            return $nonce;
        }

        return null;
    }

    public function getNonce(string $challengeString, int $cost, int $threads = 1, int $offset = 0)
    {
        $i = $nonce = 0;
        while (Util::startsWithZeros(Util::hex2Binary(sha1($challengeString.$nonce)), $cost) === false) {
            $i++;
            $nonce = ($threads * $i) + $offset;
//            printf('Nonce %d, offset %d'.PHP_EOL, $nonce, $offset);
        }

        return $nonce;

//        var_dump('Time ' . (hrtime(true) - $start)/1e+9);
//        var_dump($nonce);
//        var_dump($i);
//        var_dump(sha1($challengeString.$nonce));
//        var_dump($this->hex2Binary(sha1($challengeString.$nonce)));
    }

    public function hashSatisfiesCost(string $challengeString, int $nonce, int $cost)
    {
        return Util::startsWithZeros(
            Util::hex2Binary(
                sha1($this->createSubject($challengeString, $nonce))
            ),
            $cost
        );
    }

    private function createSubject(string $challengeString, int $nonce): string
    {
        return $challengeString . $nonce;
    }
}
