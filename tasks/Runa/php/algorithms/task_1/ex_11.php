<?php

function validateQuickSelectInputs(array $arr, int $k): void {
    if (empty($arr)) {
        throw new InvalidArgumentException("The input array cannot be empty.");
    }
    if ($k < 1 || $k > count($arr)) {
        throw new InvalidArgumentException("k is out of range.");
    }
    foreach ($arr as $v) {
        if (!is_int($v) && !is_float($v)) {
            throw new InvalidArgumentException("All elements in the array must be numeric.");
        }
    }
}

function quickSelect(array $arr, int $k): int {
    if (count($arr) === 1) {
        return $arr[0];
    }
    $pivot = $arr[(int)(count($arr) / 2)];
    [$left, $equal, $right] = partition($arr, $pivot);

    if ($k <= count($left)) {
        return quickSelect($left, $k);
    } else if ($k <= count($left) + count($equal)) {
        return $pivot;
    } else {
        return quickSelect($right, $k - count($left) - count($equal));
    }
}

function partition(array $arr, int $pivot): array {
    $left = [];
    $right = [];
    $equal = [];

    foreach ($arr as $value) {
        if ($value < $pivot) {
            $left[] = $value;
        } else if ($value > $pivot) {
            $right[] = $value;
        } else {
            $equal[] = $value;
        }
    }


    return [$left, $equal, $right];
}

// Test
try {
    validateQuickSelectInputs([3, 1, 5, 2, 4], 3);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . "\n";
    exit;
}

$arr = [3, 1, 5, 2, 4];
$k = 3;
$result = quickSelect($arr, $k);
echo "Result: $result\n";