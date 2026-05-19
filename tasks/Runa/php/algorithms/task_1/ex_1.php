<?php

//Loop method
function fibonacciIterative(int $n): int {
    if ($n < 0) {
        throw new InvalidArgumentException("Input value must be a positive integer. Input value: {$n}");
    }
    if ($n === 0) return 0;
    if ($n === 1) return 1;

    $a = 0;
    $b = 1;
    $result = 0;

    for ($i = 2; $i <= $n; $i++) {
        $result = $a + $b;
        $a = $b;
        $b = $result;
    }

    return $result;
}


//Recursive method
function fibonacciRecursive(int $n): int {
    if ($n < 0){
        throw new InvalidArgumentException("Input value must be a positive integer. Input value: {$n}");
    };
    if ($n === 0) return 0;
    if ($n === 1) return 1;
    return fibonacciRecursive($n - 1) + fibonacciRecursive($n - 2);
}

echo "10番目: " . fibonacciIterative(10) . "\n";
echo "10番目: " . fibonacciRecursive(10) . "\n";


// Experiment code

$targets = [10, 20, 30, 35];

echo "n | Iterative (Time) | Recursive (Time)\n";
echo "------------------------------------------\n";

foreach ($targets as $n) {
    $start1 = microtime(true);
    fibonacciIterative($n);
    $end1 = microtime(true);
    $timeIterative = $end1 - $start1;

    $start2 = microtime(true);
    fibonacciRecursive($n);
    $end2 = microtime(true);
    $timeRecursive = $end2 - $start2;

    printf("%d | %f sec | %f sec\n", $n, $timeIterative, $timeRecursive);
}