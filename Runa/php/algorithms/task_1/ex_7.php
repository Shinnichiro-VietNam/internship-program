<?php

function validateSearchInputs(array $arr): void {
    foreach ($arr as $v) {
        if (!is_int($v) && !is_float($v)) {
            throw new InvalidArgumentException("All elements in the array must be numeric.");
        }
    }
}

function linearSearch(array $arr, int $target): int {
    validateSearchInputs($arr);
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i] === $target) {
            return $i;
        }
    }
    return -1;
}

function linearSearchAll(array $arr, int $target): array {
    validateSearchInputs($arr);
    $result = [];
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i] === $target) {
            $result[] = $i;
        }
    }
    return $result;
}

// Test
$arr = [1, 5, 3, 5, 5, 6];
$target = 5;
$result = linearSearchAll($arr, $target);
echo "Result: " . implode(', ', $result) . "\n";

