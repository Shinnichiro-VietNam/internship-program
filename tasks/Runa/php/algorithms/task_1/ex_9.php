<?php

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
    if(empty($arr)) {
        return -1;
    }

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
    $count = count($arr);
    for($i = 0; $i < $count - 1; $i++) {
        if($arr[$i] > $arr[$i + 1]) {
            return false;
        }
    }
    return true;
}


// Test
$arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$target = 5;
$result = countOccurrences($arr, $target);
echo "Result(countOccurrences): $result\n";

$result = findMaxValue($arr);
echo "Result(findMaxValue): $result\n";

$result = checkSorted($arr);
echo "Result(checkSorted): $result\n";