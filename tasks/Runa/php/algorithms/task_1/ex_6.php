<?php

function validateStudentArray(array $arr): void {
    if (empty($arr)) {
        throw new InvalidArgumentException("The input array cannot be empty.");
    }
    foreach ($arr as $student) {
        if (!is_array($student) || !isset($student['name']) || !isset($student['score'])) {
            throw new InvalidArgumentException("Each element must be an array with name and score.");
        }
        if (!is_int($student['score']) && !is_float($student['score'])) {
            throw new InvalidArgumentException("The score must be a numeric value.");
        }
        if ($student['score'] < 0) {
            throw new InvalidArgumentException("The score must be a positive number.");
        }
    }
}

function mergeSortScore(array $students): array {
    validateStudentArray($students);
    if (count($students) <= 1) return $students;

    $mid = (int)(count($students) / 2);
    $left = mergeSortScore(array_slice($students, 0, $mid));
    $right = mergeSortScore(array_slice($students, $mid));

    $result = [];
    $i = $j = 0;
    $lCount = count($left);
    $rCount = count($right);

    while ($i < $lCount || $j < $rCount) {
        if ($j >= $rCount || ($i < $lCount && $left[$i]['score'] <= $right[$j]['score'])) {
            $result[] = $left[$i++];
        } else {
            $result[] = $right[$j++];
        }
    }

    return $result;
}

// Test
$students = [
    ['name' => 'A', 'score' => 70],
    ['name' => 'B', 'score' => 95],
    ['name' => 'C', 'score' => 70],];

$sortedStudents = mergeSortScore($students);
echo "Sorted Students: \n";
foreach ($sortedStudents as $student) {
    echo "Name: {$student['name']}, Score: {$student['score']}\n";
}