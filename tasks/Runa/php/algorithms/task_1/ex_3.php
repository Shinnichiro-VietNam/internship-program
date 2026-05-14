<?php
require_once 'ex_2.php';

function measureTime(callable $sortFunction, array $data): float {
    $start = microtime(true);
    $sortFunction($data);
    $end = microtime(true);
    return $end - $start;
}

$size = 5000;

// Random Data
$randomData = range(1, $size);
shuffle($randomData);

// Already Sorted Data
$alreadySortedData = range(1, $size);

// Reverse Sorted Data
$reverseSortedData = range($size, 1);

// Many Duplicates Data
$manyDuplicatesData = [];
for($i=0; $i<$size; $i++) {
    $manyDuplicatesData[] = rand(1, 10);
}

// Nearly Sorted Data
$nearlySortedData = range(1, $size);
shuffle($nearlySortedData);
sort($nearlySortedData);

[$nearlySortedData[0], $nearlySortedData[1]] = [$nearlySortedData[1], $nearlySortedData[0]];

echo "------Bubble Sort------\n";
echo "Random Data: ".measureTime('bubbleSort', $randomData)."s\n";
echo "Already Sorted Data: ".measureTime('bubbleSort', $alreadySortedData)."s\n";
echo "Reverse Sorted Data: ".measureTime('bubbleSort', $reverseSortedData)."s\n";
echo "Many Duplicates Data: ".measureTime('bubbleSort', $manyDuplicatesData)."s\n";
echo "Nearly Sorted Data: ".measureTime('bubbleSort', $nearlySortedData)."s\n";

echo "------Selection Sort------\n";
echo "Random Data: ".measureTime('selectionSort', $randomData)."s\n";
echo "Already Sorted Data: ".measureTime('selectionSort', $alreadySortedData)."s\n";
echo "Reverse Sorted Data: ".measureTime('selectionSort', $reverseSortedData)."s\n";
echo "Many Duplicates Data: ".measureTime('selectionSort', $manyDuplicatesData)."s\n";
echo "Nearly Sorted Data: ".measureTime('selectionSort', $nearlySortedData)."s\n";

echo "------Insertion Sort------\n";
echo "Random Data: ".measureTime('insertionSort', $randomData)."s\n";
echo "Already Sorted Data: ".measureTime('insertionSort', $alreadySortedData)."s\n";
echo "Reverse Sorted Data: ".measureTime('insertionSort', $reverseSortedData)."s\n";
echo "Many Duplicates Data: ".measureTime('insertionSort', $manyDuplicatesData)."s\n";
echo "Nearly Sorted Data: ".measureTime('insertionSort', $nearlySortedData)."s\n";
?>