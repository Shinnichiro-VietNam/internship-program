<?php

require_once 'ex_2.php';

function countOccurrences(array $arr, int $target): int {
    $count = 0;
    foreach($arr as $value) {
        if($value === $target) {
            $count++;
        }
    }
    return $count;
}


function findMaxValue(array $arr): int {
    $maxVal = $arr[0];
    $maxInd = 0;

    for($i = 1; $i < count($arr); $i++) {
        if($arr[$i] > $maxVal) {
            $maxVal = $arr[$i];
            $maxInd = $i;
        }
    }
    return $maxVal;
}

function checkSorted(array $arr): bool {
    for($i = 0; $i < $count - 1; $i++) {
        if($arr[$i] > $arr[$i + 1]) {
            return false;
        }
    }
    return true;
}


// Test
try {
    validateArray([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . "\n";
    exit;
}

$arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$target = 5;
$result = countOccurrences($arr, $target);
echo "Result(countOccurrences): $result\n";

$result = findMaxValue($arr);
echo "Result(findMaxValue): $result\n";