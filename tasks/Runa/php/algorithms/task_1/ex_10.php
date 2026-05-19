<?php

require_once 'ex_2.php';
require_once 'ex_8.php';

function findFirstAndLast(array $arr, int $target): array {
    $first = lowerBound($arr, $target);

    if($first === count($arr) || $arr[$first] !== $target) {
        return [-1, -1];
    }

    $last = upperBound($arr, $target) - 1;
    return [$first, $last];
}

function countOccurrences(array $arr, int $target): int {
    return upperBound($arr, $target) - lowerBound($arr, $target);
}

function findCeilAndFloor(array $arr, int $x): array {
    $ceilIndex = lowerBound($arr, $x);
    $ceil = ($ceilIndex < count($arr)) ? $arr[$ceilIndex] : null;

    $floorIndex = upperBound($arr, $x) - 1;
    $floor = ($floorIndex >= 0) ? $arr[$floorIndex] : null;

    return [$ceil, $floor];
}

function f(int $k): int {
    return $k * 2;
}

function findSmallestK(int $x): int {
    $low = 0;
    $high = 100;

    while($low < $high) {
        $mid = (int)(($low + $high) / 2);
        if(f($mid) >= $x) {
            $high = $mid;
        } else {
            $low = $mid + 1;
        }
    }
    return $low;
}

// --- Test ---

try {
    validateArray([1, 2, 4, 4, 4, 6, 7]);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . "\n";
    exit;
}

$arr = [1, 2, 4, 4, 4, 6, 7];
$target = 4;
$result1 = findFirstAndLast($arr, $target);
echo "Result(findFirstAndLast): [" . implode(', ', $result1) . "]\n";

$result2 = countOccurrences($arr, $target);
echo "Result(countOccurrences): $result2\n";

$result3 = findCeilAndFloor($arr, 3);
echo "Result(findCeilAndFloor for 3): Ceil=" . ($result3[0] ?? 'null') . ", Floor=" . ($result3[1] ?? 'null') . "\n";

$result4 = findSmallestK(15);
echo "Result(findSmallestK for 15): $result4\n";