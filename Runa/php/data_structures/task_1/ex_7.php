<?php
declare(strict_types=1);

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

// ==========================================
// Testing
// ==========================================
$hashTable = new HashTable();
$hashTable->put("A", "Apple");
$hashTable->put("Q", "Orange");
$hashTable->put("a0", "Banana");

echo "Get A: ". $hashTable->get("A");
echo "\n";
echo "Get Q: ". $hashTable->get("Q");
echo "\n";
echo "Get a0: ". $hashTable->get("a0");
echo "\n";

$hashTable->put("A", "Updated Apple");
echo "Get 'A': ". $hashTable->get("A");
echo "\n";

$hashTable->remove("Q");
echo "After removing 'Q':\n";
echo "Get 'Q': ". $hashTable->get("Q");