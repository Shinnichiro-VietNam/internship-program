<?php

require_once 'ex_2.php';

function quickSort(array $arr): array {
    if (count($arr) <= 1) return $arr;

    // $pivot = $arr[0]; // First Pivot Strategy
    // $pivot = $arr[count($arr) - 1]; // Last Pivot Strategy
    // $pivot = $arr[rand(0, count($arr) - 1)]; // Random Pivot Strategy

    // Middle Pivot Strategy
    $pivotIndex = (int)(count($arr) / 2);
    $pivot = $arr[$pivotIndex];

    $left = [];
    $right = [];

    for ($i = 0; $i < count($arr); $i++) {
        if ($i === $pivotIndex) {
            continue;
        }

        if ($arr[$i] < $pivot) {
            $left[] = $arr[$i];
        } else {
            $right[] = $arr[$i];
        }
    }

    return [...quickSort($left), $pivot, ...quickSort($right)];
}

// Test
$arr = [2,3,6,1,5,4,45,69,23,12,45,67,89,100,123,456,789,1000];
$sorted = quickSort($arr);
echo "Result: ".implode(', ', $sorted )."\n";

