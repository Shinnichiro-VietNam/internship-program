<?php

// Bubble Sort
function bubbleSort(array $arr): array {
    $n = count($arr);
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if ($arr[$j] > $arr[$j + 1]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j + 1];
                $arr[$j + 1] = $temp;
            }
        }
    }
    return $arr;
}

// Selection Sort

function selectionSort(array $arr): array {
    $n = count($arr);
    for ($i = 0; $i < $n - 1; $i++) {
        $minIndex = $i;
        for ($j = $i + 1; $j < $n; $j++) {
            if ($arr[$j] < $arr[$minIndex]) {
                $minIndex = $j;
            }
        }
        if ($minIndex !== $i) {
            $temp = $arr[$i];
            $arr[$i] = $arr[$minIndex];
            $arr[$minIndex] = $temp;
        }
    }
    return $arr;
}

// Insertion Sort

function insertionSort(array $arr): array {
    $n = count($arr);
    for ($i = 1; $i < $n; $i++) {
        $key = $arr[$i];
        $j = $i - 1;
        while ($j >= 0 && $arr[$j] > $key) {
            $arr[$j + 1] = $arr[$j];
            $j--;
        }
        $arr[$j + 1] = $key;
    }
    return $arr;
}

// Test data preparation
$testArray = [64, 34, 25, 12, 22, 11, 90];

echo "Original Array: " . implode(", ", $testArray) . "\n\n";

// --- Bubble Sort ---
$arr1 = $testArray;
$start = microtime(true);
$result1 = bubbleSort($arr1);
$end = microtime(true);
echo "Bubble Sort: " . implode(", ", $result1) . " (Time: " . sprintf("f", $end - $start) . "s)\n";

// --- Selection Sort ---
$arr2 = $testArray;
$start = microtime(true);
$result2 = selectionSort($arr2);
$end = microtime(true);
echo "Selection Sort: " . implode(", ", $result2) . " (Time: " . sprintf("%f", $end - $start) . "s)\n";

// --- Insertion Sort ---
$arr3 = $testArray;
$start = microtime(true);
$result3 = insertionSort($arr3);
$end = microtime(true);
echo "Insertion Sort: " . implode(", ", $result3) . " (Time: " . sprintf("%f", $end - $start) . "s)\n";