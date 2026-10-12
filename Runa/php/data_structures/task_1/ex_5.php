<?php
declare(strict_types=1);

class ListNode {
    public mixed $value;
    public ?ListNode $next;

    public function __construct(mixed $value) {
        $this->value = $value;
        $this->next = null;
    }
}

class CircularArrayQueue {
    private array $storage;
    private int $capacity = 8;
    private int $front = 0;
    private int $size = 0;

    public function __construct() {
        $this->storage = array_fill(0, $this->capacity, null);
    }

    public function enqueue(mixed $item): void {
        if ($this->size === $this->capacity) {
            throw new Exception("Queue is full");
        }
        $rear = ($this->front + $this->size) % $this->capacity;
        $this->storage[$rear] = $item;
        $this->size++;
    }

    public function dequeue(): mixed {
        if ($this->isEmpty()) {
            throw new Exception("Queue is empty");
        }
        $item = $this->storage[$this->front];
        $this->front = ($this->front + 1) % $this->capacity;
        $this->size--;
        return $item;
    }

    public function peek(): mixed {
        if ($this->isEmpty()) {
            throw new Exception("Queue is empty");
        }
        return $this->storage[$this->front];
    }

    public function isEmpty(): bool {
        return $this->size === 0;
    }

    public function size(): int {
        return $this->size;
    }
}

class LinkedQueue {
    private ?ListNode $head = null;
    private ?ListNode $tail = null;
    private int $size = 0;

    public function enqueue(mixed $item): void {
        $newNode = new ListNode($item);
        if ($this->isEmpty()) {
            $this->head = $newNode;
            $this->tail = $newNode;
        } else {
            $this->tail->next = $newNode;
            $this->tail = $newNode;
        }
        $this->size++;
    }

    public function dequeue(): mixed {
        if ($this->isEmpty()) {
            throw new Exception("Queue is empty");
        }
        $value = $this->head->value;
        $this->head = $this->head->next;
        if ($this->head === null) {
            $this->tail = null;
        }
        $this->size--;
        return $value;
    }

    public function peek(): mixed {
        if ($this->isEmpty()) {
            throw new Exception("Queue is empty");
        }
        return $this->head->value;
    }

    public function isEmpty(): bool {
        return $this->head === null;
    }

    public function size(): int {
        return $this->size;
    }
}

// ================================
// Testing
// ================================
echo "Testing CircularArrayQueue: \n";
$arrayQueue = new CircularArrayQueue();

echo "Enqueued: A, B, C\n";
$arrayQueue->enqueue("A");
$arrayQueue->enqueue("B");
$arrayQueue->enqueue("C");

while (!$arrayQueue->isEmpty()) {
    echo "Dequeued: " . $arrayQueue->dequeue() . "\n";
}

echo "Testing LinkedQueue: \n";
$linkedQueue = new LinkedQueue();

echo "Enqueued: A, B, C\n";
$linkedQueue->enqueue("A");
$linkedQueue->enqueue("B");
$linkedQueue->enqueue("C");

while (!$linkedQueue->isEmpty()) {
    echo "Dequeued: " . $linkedQueue->dequeue() . "\n";
}