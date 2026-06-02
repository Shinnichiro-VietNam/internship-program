<?php
declare(strict_types=1);

class CircularArrayDeque {
    private array $storage;
    private int $capacity = 8;
    private int $front = 0;
    private int $size = 0;

    public function __construct() {
        $this->storage = array_fill(0, $this->capacity, null);
    }

    public function isEmpty(): bool {
        return $this->size === 0;
    }

    public function isFull(): bool {
        return $this->size === $this->capacity;
    }

    public function addFirst(mixed $item): void {
        if ($this->isFull()) {
            throw new Exception("Deque is full");
        }
        $this->front = ($this->front - 1 + $this->capacity) % $this->capacity;
        $this->storage[$this->front] = $item;
        $this->size++;
    }

    public function addLast(mixed $item): void {
        if ($this->isFull()) {
            throw new Exception("Deque is full");
        }
        $rear = ($this->front + $this->size) % $this->capacity;
        $this->storage[$rear] = $item;
        $this->size++;
    }

    public function removeFirst(): mixed {
        if ($this->isEmpty()) {
            throw new Exception("Deque is empty");
        }
        $item = $this->storage[$this->front];
        $this->front = ($this->front + 1) % $this->capacity;
        $this->size--;
        return $item;
    }

    public function removeLast(): mixed {
        if ($this->isEmpty()) {
            throw new Exception("Deque is empty");
        }
        $rear = ($this->front + $this->size - 1) % $this->capacity;
        $item = $this->storage[$rear];
        $this->size--;
        return $item;
    }

    public function peekFirst(): mixed {
        if ($this->isEmpty()) {
            throw new Exception("Deque is empty");
        }
        return $this->storage[$this->front];
    }

    public function peekLast(): mixed {
        if ($this->isEmpty()) {
            throw new Exception("Deque is empty");
        }
        $rear = ($this->front + $this->size - 1) % $this->capacity;
        return $this->storage[$rear];
    }

    public function size(): int {
        return $this->size;
    }
}

function isPalindrome(string $s): bool {
    $deque = new CircularArrayDeque();

    foreach (str_split($s) as $char) {
        $deque->addLast($char);
    }

    while ($deque->size() > 1) {
        if ($deque->removeFirst() !== $deque->removeLast()) {
            return false;
        }
    }
    return true;
}

// ================================
// Testing
// ================================
echo "isPalindrome: \n";
echo isPalindrome("racecar") ? "true" : "false";
echo "\n";
echo isPalindrome("hello") ? "true" : "false";
echo "\n";

