<?php
declare(strict_types=1);

// ex_7.php
class HashTable {
    private array $buckets;
    private int $numBuckets = 16;

    public function __construct() {
        $this->buckets = array_fill(0, $this->numBuckets, []);
    }

    private function hash(string|int $key): int {
        $keyStr = (string)$key;
        $sum = 0;
        for ($i = 0; $i < strlen($keyStr); $i++) {
            $sum += ord($keyStr[$i]);
    }
        return $sum % $this->numBuckets;
    }

    public function put(string|int $key, mixed $value): void {
        $index = $this->hash($key);
        foreach ($this->buckets[$index] as $i => $pair) {
            if ($pair[0] === $key) {
                $this->buckets[$index][$i][1] = $value;
                return;
            }
        }
        $this->buckets[$index][] = [$key, $value];
    }


    public function get(string|int $key): mixed {
        $index = $this->hash($key);
        foreach ($this->buckets[$index] as $pair) {
            if ($pair[0] === $key) {
                return $pair[1];
            }
        }
        return null;
    }

    public function remove(string|int $key): bool {
        $index = $this->hash($key);
        foreach ($this->buckets[$index] as $i => $pair) {
            if ($pair[0] === $key) {
                unset($this->buckets[$index][$i]);
                return true;
            }
        }
        return false;
    }

    public function keys(): array {
        $allKeys = [];
        foreach ($this->buckets as $bucket) {
            foreach ($bucket as $pair) {
                $allKeys[] = $pair[0];
            }
        }
        return $allKeys;
    }
}

// ex_8.php

function twoSum(array $nums, int $target): array {
    $hashTable = new HashTable();

    foreach ($nums as $index => $num) {
        $complement = $target - $num;
        $targetIndex = $hashTable->get($complement);

        if ($targetIndex !== null) {
            return [$targetIndex, $index];
        }
        $hashTable->put($num, $index);
    }
    return [];
}

function firstNonRepeating(string $s): int {
    $hashTable = new HashTable();
    $length = strlen($s);

    for ($i = 0; $i < $length; $i++) {
        $char = $s[$i];
        $currentCount = $hashTable->get($char);
        if ($currentCount === null) {
            $hashTable->put($char, 1);
        } else {
            $hashTable->put($char, $currentCount + 1);
        }
    }

    for ($i = 0; $i < $length; $i++) {
        $char = $s[$i];
        $currentCount = $hashTable->get($char);
        if ($currentCount === 1) {
            return $i;
        }
    }

    return -1;
}

function groupAnagrams(array $words): array {
    $hashTable = new HashTable();
    $result = [];

    foreach ($words as $word) {
        $sortedWord = str_split($word);
        sort($sortedWord);
        $sortedWord = implode('', $sortedWord);
    }

    return $result;
}

// ==========================================
// Testing
// ==========================================
$nums = [2, 7, 11, 15];
$target = 9;
echo "Two Sum: " . implode(', ', twoSum($nums, $target)) . "\n";

$s = "leetcode";
echo "First Non Repeating: " . firstNonRepeating($s) . "\n";

$words = ["eat", "tea", "tan", "ate", "nat", "bat"];
print_r(groupAnagrams($words));