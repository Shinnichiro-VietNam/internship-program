<?php


require_once 'ex_2.php';

function mergeSort(array $arr): array {
    if (count($arr) <= 1) return $arr;

    $mid = (int)(count($arr) / 2);
    $left = mergeSort(array_slice($arr, 0, $mid));
    $right = mergeSort(array_slice($arr, $mid));

    $result = [];
    $i = $j = 0;
    $lCount = count($left);
    $rCount = count($right);

    while ($i < $lCount || $j < $rCount) {
        if ($j >= $rCount || ($i < $lCount && $left[$i] <= $right[$j])) {
            $result[] = $left[$i++];
        } else {
            $result[] = $right[$j++];
        }
    }

    return $result;
}

// Test
$arr = [2, 3, 6, 1, 5, 4, 45, 69, 23, 12, 45, 67, 89, 100, 123, 456, 789, 1000];

try {
    validateArray($arr);
    echo "Result: " . implode(', ', mergeSort($arr)) . "\n";
} catch (InvalidArgumentException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}