<?php

function validateSearchInputs(array $arr): void {
    foreach ($arr as $v) {
        if (!is_int($v) && !is_float($v)) {
            throw new InvalidArgumentException("All elements in the array must be numeric.");
        }
    }
}

function binarySearch(array $sortedArr, int $target): int {
    $left = 0;
    $right = count($sortedArr) - 1;

    while ($left <= $right) {
        $mid = (int)(($left + $right) / 2);

        if ($sortedArr[$mid] === $target) {
            return $mid;
        }

        if ($sortedArr[$mid] < $target) {
            $left = $mid + 1;
        } else {
            $right = $mid - 1;
        }
    }
    return -1;
}

function lowerBound(array $sortedArr, int $target): int {
    $left = 0;
    $right = count($sortedArr);

    while ($left < $right) {
        $mid = (int)(($left + $right) / 2);
        if ($sortedArr[$mid] >= $target) {
            $right = $mid;
        } else {
            $left = $mid + 1;
        }
    }
    return $left;
}

function upperBound(array $sortedArr, int $target): int {
    $left = 0;
    $right = count($sortedArr);

    while ($left < $right) {
        $mid = (int)(($left + $right) / 2);
        if ($sortedArr[$mid] > $target) {
            $right = $mid;
        } else {
            $left = $mid + 1;
        }
    }
    return $left;
}

// Test
try {
    validateSearchInputs([1, 2, 4, 4, 4, 6, 7]);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . "\n";
    exit;
}

$arr = [1, 2, 4, 4, 4, 6, 7];
$target = 4;
try {
    echo "Binary Search: " . binarySearch($arr, $target) . "\n";
    echo "Lower Bound: " . lowerBound($arr, $target) . "\n";
    echo "Upper Bound: " . upperBound($arr, $target) . "\n";
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . "\n";
    exit;
}