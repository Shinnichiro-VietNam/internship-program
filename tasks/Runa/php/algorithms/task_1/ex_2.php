<?php

function validateArray(array $arr): void {
    if (empty($arr)) {
        throw new InvalidArgumentException("Input array cannot be empty.");
    }
    foreach ($arr as $value) {
        if (!is_int($value) && !is_float($value)) {
            $type = gettype($value);
            throw new InvalidArgumentException("All elements in the array must be numeric. Found type: {$type}");
        }
    }
}

// Bubble Sort
function bubbleSort(array $arr): array {
    validateArray($arr);
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
    validateArray($arr);
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
    validateArray($arr);
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

