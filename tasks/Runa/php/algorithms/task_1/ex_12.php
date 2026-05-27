<?php

declare(strict_types=1);

require_once 'ex_2.php';

function mergeSortedArrays(array $arr1, array $arr2): array {
    $merged = [];
    $i = 0;
    $j = 0;
    $count1 = count($arr1);
    $count2 = count($arr2);

    while ($i < $count1 && $j < $count2) {
        if ($arr1[$i] < $arr2[$j]) {
            $merged[] = $arr1[$i];
            $i++;
        } else {
            $merged[] = $arr2[$j];
            $j++;
        }
    }

    while ($i < $count1) {
        $merged[] = $arr1[$i];
        $i++;
    }

    while ($j < $count2) {
        $merged[] = $arr2[$j];
        $j++;
    }

    return $merged;
}

function inversionCount(array &$arr): int {
    $n = count($arr);
    if ($n <= 1) {
        return 0;
    }

    $mid = (int)($n / 2);
    $left = array_slice($arr, 0, $mid);
    $right = array_slice($arr, $mid);

    $count = inversionCount($left) + inversionCount($right);

    $i = 0; $j = 0; $k = 0;
    $countLeft = count($left);
    $countRight = count($right);

    while ($i < $countLeft && $j < $countRight) {
        if ($left[$i] <= $right[$j]) {
            $arr[$k++] = $left[$i++];
        } else {
            $arr[$k++] = $right[$j++];
            $count += ($countLeft - $i);
        }
    }

    while ($i < $countLeft) {
        $arr[$k++] = $left[$i++];
    }
    while ($j < $countRight) {
        $arr[$k++] = $right[$j++];
    }

    return $count;
}

function findMinInRotatedSortedArray(array $arr): int {
    $left = 0;
    $right = count($arr) - 1;
    while ($left < $right) {
        $mid = (int)(($left + $right) / 2);
        if ($arr[$mid] > $arr[$right]) {
            $left = $mid + 1;
        } else {
            $right = $mid;
        }
    }
    return $arr[$left];
}

// Test
$arrMerge1    = [1, 3, 5];
$arrMerge2    = [2, 4, 6];
$arrRotated   = [4, 5, 6, 7, 0, 1, 2];
$arrInversion = [2, 4, 1, 3, 5];

try {
    foreach ([$arrMerge1, $arrMerge2, $arrRotated, $arrInversion] as $a) validateArray($a);

    echo "Result(mergeSortedArrays): [" . implode(', ', mergeSortedArrays($arrMerge1, $arrMerge2)) . "]\n";
    echo "Result(findMinInRotatedSortedArray): " . findMinInRotatedSortedArray($arrRotated) . "\n";
    echo "Result(inversionCount): " . inversionCount($arrInversion) . "\n";

} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . "\n";
    exit;
}