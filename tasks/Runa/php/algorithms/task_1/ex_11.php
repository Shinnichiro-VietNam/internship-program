<?php

function quickSelect(array $arr, int $k): int {
    if (empty($arr) || $k < 1 || $k > count($arr)) {
        throw new Exception("Invalid input");
    }

    if (count($arr) === 1) {
        return $arr[0];
    }

    $pivot = $arr[(int)(count($arr) / 2)];
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

    if ($k <= count($left)) {
        return quickSelect($left, $k);
    } else if ($k <= count($left) + count($equal)) {
        return $pivot;
    } else {
        return quickSelect($right, $k - count($left) - count($equal));
    }
}

// Test
$arr = [3, 1, 5, 2, 4];
$k = 3;
$result = quickSelect($arr, $k);
echo "Result(quickSelect): $result\n";