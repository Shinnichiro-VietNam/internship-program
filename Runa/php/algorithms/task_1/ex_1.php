<?php

//Recursive approach
function fibonacciRecursive(int $n): int{
    if ($n <= 1) return $n;

    return fibonacciRecursive($n - 1) + fibonacciRecursive($n - 2);
}


//Memoization approach
function fibonacciMemoization(int $n, array $memo = []): int{
    if ($n <= 1) return $n;

    if (isset($memo[$n])) {
        return $memo[$n];
    }

    $memo[$n] = fibonacciMemoization($n - 1, $memo) + fibonacciMemoization($n - 2, $memo);
    return $memo[$n];
}

//Bottom-up approach(Tabulation Approach)
function fibonacciBottomUp(int $n): int{
    if ($n <= 1) return $n;

    $dp = [];
    $dp[0] = 0;
    $dp[1] = 1;

    for ($i = 2; $i <= $n; $i++) {
        $dp[$i] = $dp[$i - 1] + $dp[$i - 2];
    }
    return $dp[$n];
}


//Bottom-up approach(Space Optimized Approach)
function fibonacciBottomUp2(int $n): int{
    if ($n <= 1) return $n;

    $curr = 0;

    $prev1 = 1;
    $prev2 = 0;

    for ($i = 2; $i <= $n; $i++) {
        $curr = $prev1 + $prev2;
        $prev2 = $prev1;
        $prev1 = $curr;
    }
    return $curr;
}


//Using Matrix Exponentiation
function multiply(array &$mat1, array $mat2): void{
    $x = $mat1[0][0] * $mat2[0][0] + $mat1[0][1] * $mat2[1][0];
    $y = $mat1[0][0] * $mat2[0][1] + $mat1[0][1] * $mat2[1][1];
    $z = $mat1[1][0] * $mat2[0][0] + $mat1[1][1] * $mat2[1][0];
    $w = $mat1[1][0] * $mat2[0][1] + $mat1[1][1] * $mat2[1][1];

    $mat1[0][0] = $x;
    $mat1[0][1] = $y;
    $mat1[1][0] = $z;
    $mat1[1][1] = $w;
}


function matrixPower(array &$mat1, int $n): void {
    if ($n == 0 || $n == 1) return;

    $mat2 = [[1, 1], [1, 0]];
    matrixPower($mat1, (int)($n / 2));
    multiply($mat1, $mat1);
    if ($n % 2 != 0) multiply($mat1, $mat2);
}

function nthFibonacci(int $n): int {
    if ($n <= 1) return $n;

    $mat1 = [[1, 1], [1, 0]];

    matrixPower($mat1, $n - 1);

    return $mat1[0][0];
}

//Using Golden Ratio
function nthFibonacciGoldenRatio(int $n): int {
    if ($n <= 1) return $n;

    $phi = (1 + sqrt(5)) / 2;
    $psi = (1 - sqrt(5)) / 2;

    return round((pow($phi, $n) - pow($psi, $n)) / sqrt(5));
}

// Test
$n = 5;
echo "Fibonacci number at position $n:\n";
echo "Recursive: " . fibonacciRecursive($n) . "\n";
echo "Memoization: " . fibonacciMemoization($n) . "\n";
echo "Bottom-up: " . fibonacciBottomUp($n) . "\n";
echo "Bottom-up2: " . fibonacciBottomUp2($n) . "\n";
echo "Matrix Exponentiation: " . nthFibonacci($n) . "\n";
echo "Golden Ratio: " . nthFibonacciGoldenRatio($n) . "\n";