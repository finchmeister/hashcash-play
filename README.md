# Hashcash Play

```
serverless deploy
```


Local testing disable extensions
```
php -n bin/console hc:test:hash
```

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

### Optimum Lambda Size
```
[
     'challengeString' => 'challenge',
     'cost' => 15,
     'concurrency' => 1,
     'concurrencyOffset' => 0,
     'start' => 0,
     'timeout' => 60,
];
```

| H/s   | Lambda Memory |
|----   |----|
| 512   | 26476.29 | 
| 1024  | 52665.6 | 
| 1536  | 78818.7 | 
| 1536  | 83483.01 | 
| 1792  | 91882.6 | 
| 1984  | 92778.15 | 
| 2048  | 92505.3 | 
| 2560  | 92495.69 | 
| 3008  | 93105.08 | 


50 concurrency although only 32 seemed to be running at a time
```
➜  hashcash-play git:(master) ✗ php -n bin/console hc:test:lambda-parallel
Benchmark
---------
Cost: 30
Concurrency: 50
Challenge String: challenge

array(7) {
  ["success"]=>
  bool(true)
  ["work"]=>
  array(7) {
    ["challengeString"]=>
    string(9) "challenge"
    ["cost"]=>
    int(30)
    ["concurrency"]=>
    int(50)
    ["concurrencyOffset"]=>
    int(26)
    ["start"]=>
    int(1537960012)
    ["timeout"]=>
    int(60)
    ["chainId"]=>
    int(7)
  }
  ["lastNonce"]=>
  int(1727504938)
  ["iterations"]=>
  int(3790898)
  ["timeTaken"]=>
  float(40.62677192688)
  ["hash"]=>
  string(40) "0000000250534c17158cd8738cbd37852a9a4f4b"
  ["iterationsPerSec"]=>
  float(93310.34)
}
Time 438.677689258
```