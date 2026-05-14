<?php

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

$arr = [1, 2, 4, 4, 4, 6, 7];
$target = 4;

echo "Binary Search: " . binarySearch($arr, $target) . "\n";
echo "Lower Bound: " . lowerBound($arr, $target) . "\n";
echo "Upper Bound: " . upperBound($arr, $target) . "\n";