<?php

require_once 'ex_4.php';

$students = [
    ['name' => 'A', 'score' => 70],
    ['name' => 'B', 'score' => 95],
    ['name' => 'C', 'score' => 70],
];

function mergeSortScore(array $arr): array {
    if (count($arr) <= 1) return $arr;

    $mid = (int)(count($arr) / 2);
    $left = array_slice($arr, 0, $mid);
    $right = array_slice($arr, $mid);

    $left = mergeSortScore($left);
    $right = mergeSortScore($right);
    return merge($left, $right);
}

function merge(array $left, array $right): array {
    $result = [];
    while (count($left) > 0 && count($right) > 0) {
        if ($left[0]['score'] <= $right[0]['score']) {
            $result[] = array_shift($left);
        } else {
            $result[] = array_shift($right);
        }
    }

    return array_merge($result, $left, $right);
}

// Test
$students = [
    ['name' => 'A', 'score' => 70],
    ['name' => 'B', 'score' => 95],
    ['name' => 'C', 'score' => 70],
];

$sortedStudents = mergeSortScore($students);
echo "Sorted Students: \n";
foreach ($sortedStudents as $student) {
    echo "Name: {$student['name']}, Score: {$student['score']}\n";
}