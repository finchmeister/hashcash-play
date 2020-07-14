<?php declare(strict_types=1);

namespace HashCash;

class WorkResult
{
    private Work $work;
    private bool $success;
    private int $lastNonce;
    private int $iterations;
    private float $timeTaken;
    private ?string $hash;

    public function __construct(
        Work $work,
        bool $success,
        int $lastNonce,
        int $iterations,
        float $timeTaken,
        ?string $hash
    )
    {
        $this->work = $work;
        $this->success = $success;
        $this->lastNonce = $lastNonce;
        $this->iterations = $iterations;
        $this->timeTaken = $timeTaken;
        $this->hash = $hash;
    }

    public static function successful(
        Work $work,
        int $nonce,
        int $iterations,
        float $timeTaken,
        string $hash
    ): self {
        return new self(
            $work,
            true,
            $nonce,
            $iterations,
            $timeTaken,
            $hash
        );
    }

    public static function unSuccessful(
        Work $work,
        int $lastNonce,
        int $iterations,
        float $timeTaken
    ): self {
        return new self(
            $work,
            false,
            $lastNonce,
            $iterations,
            $timeTaken,
            null
        );
    }

    public function getWork(): Work
    {
        return $this->work;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getLastNonce(): int
    {
        return $this->lastNonce;
    }

    public function getIterations(): int
    {
        return $this->iterations;
    }

    public function getTimeTaken(): float
    {
        return $this->timeTaken;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'work' => $this->work->toArray(),
            'lastNonce' => $this->lastNonce,
            'iterations' => $this->iterations,
            'timeTaken' => $this->timeTaken,
            'hash' => $this->hash,
        ];
    }

    public static function fromArray(array $workResult): self
    {
        return new self(
            Work::fromArray($workResult['work']),
            $workResult['success'],
            $workResult['lastNonce'],
            $workResult['iterations'],
            $workResult['timeTaken'],
            $workResult['hash'],
        );
    }
}
