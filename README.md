

Benchmark
```
./vendor/bin/phpbench run src/Benchmark/HashBench.php 
```

```
$payload = json_encode([
    'challengeString' => 'challenge',
    'cost' => 24,
    'concurrency' => 1,
    'concurrencyOffset' => 0,
    'start' => 0,
    'timeout' => 60,
]);

class HashCash\WorkResult#24 (6) {
  private HashCash\Work $work =>
  class HashCash\Work#35 (6) {
    private string $challengeString =>
    string(9) "challenge"
    private int $cost =>
    int(24)
    private int $concurrency =>
    int(1)
    private int $concurrencyOffset =>
    int(0)
    private int $start =>
    int(20737785)
    private int $timeout =>
    int(60)
  }
  private bool $success =>
  bool(true)
  private int $lastNonce =>
  int(24353704)
  private int $iterations =>
  int(3615919)
  private float $timeTaken =>
  double(38.348280906677)
  private ?string $hash =>
  string(40) "000000200918f43df9c0c3918ac143a10382f870"
}
```
5th lambda call 2048



```
serverless invoke -f function --data='{"challengeString":"challenge","cost":20,"concurrency":1,"concurrencyOffset":0,"start":0,"iterations":null}'

aws lambda invoke --function-name app-dev-function --payload '{"challengeString":"challenge","cost":10,"concurrency":1,"concurrencyOffset":0,"start":0,"timeout":60,"chainId":1}' --cli-binary-format raw-in-base64-out response.json | cat
```

```
➜  hashcash-play git:(master) ✗ time php parallel_lambda.php
Benchmark
---------
Cost: 30
Concurrency: 25
Challenge String: challenge
Parallel with 25 threads
------------
/Users/jfinch/PersonalProjects/hashcash-play/parallel_lambda.php:79:
class HashCash\WorkResult#106 (6) {
  private HashCash\Work $work =>
  class HashCash\Work#1022 (7) {
    private string $challengeString =>
    string(9) "challenge"
    private int $cost =>
    int(30)
    private int $concurrency =>
    int(25)
    private int $concurrencyOffset =>
    int(0)
    private int $start =>
    int(1706299863)
    private int $timeout =>
    int(60)
    private int $chainId =>
    int(14)
  }
  private bool $success =>
  bool(true)
  private int $lastNonce =>
  int(1727504938)
  private int $iterations =>
  int(848203)
  private float $timeTaken =>
  double(8.972953081131)
  private ?string $hash =>
  string(40) "0000000250534c17158cd8738cbd37852a9a4f4b"
}
Time 763.90770803

php parallel_lambda.php  10.57s user 2.65s system 1% cpu 13:09.45 total

```