<?php
require_once 'ex_2.php';

function measureTime(callable $sortFunction, array $data): float {
    $start = microtime(true);
    $sortFunction($data);
    $end = microtime(true);
    return $end - $start;
}

$randomData = range(1, 10000);
$data = $randomData;

echo "Bubble Sort:".measureTime('bubbleSort', $data)."s\n";
echo "Selection Sort:".measureTime('selectionSort', $data)."s\n";
echo "Insertion Sort:".measureTime('insertionSort', $data)."s\n";


// Test data preparation
$testArray = [64, 34, 25, 12, 22, 11, 90];

echo "\n\n Original Array: " . implode(", ", $testArray) . "\n\n";

echo "Bubble Sort:".measureTime('bubbleSort', $testArray)."s\n";
echo "Selection Sort:".measureTime('selectionSort', $testArray)."s\n";
echo "Insertion Sort:".measureTime('insertionSort', $testArray)."s\n";
?>