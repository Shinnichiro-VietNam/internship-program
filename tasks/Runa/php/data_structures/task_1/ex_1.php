<?php
declare(strict_types=1);

class DynamicArray {
    private array $elements;
    private int $capacity;
    private int $size;

    public function __construct() {
        $this->capacity = 8;
        $this->size = 0;
        $this->elements = array_fill(0, $this->capacity, null);
    }

    public function size(): int {
        return $this->size;
    }

    public function get(int $index): mixed {
        if ($index < 0 || $index >= $this->size) {
            throw new \OutOfRangeException("Index out of range: {$index}");
        }
        return $this->elements[$index];
    }

    public function set(int $index, mixed $value): void {
        if ($index < 0 || $index >= $this->size) {
            throw new \OutOfRangeException("Index out of range: {$index}");
        }
        $this->elements[$index] = $value;
    }

    public function append(mixed $value): void {
        if ($this->size == $this->capacity) {
            $this->resize();
        }
        $this->elements[$this->size] = $value;
        $this->size++;
    }

    public function insertAt(int $index, mixed $value): void {
        if ($index < 0 || $index > $this->size) {
            throw new \OutOfRangeException("Index out of range: {$index}");
        }
        if ($this->size == $this->capacity) {
            $this->resize();
        }
        for ($i = $this->size; $i > $index; $i--) {
            $this->elements[$i] = $this->elements[$i - 1];
        }
        $this->elements[$index] = $value;
        $this->size++;
    }

    public function removeAt(int $index): mixed {
        if ($index < 0 || $index >= $this->size) {
            throw new \OutOfRangeException("Index out of range: {$index}");
        }
        $value = $this->elements[$index];
        for ($i = $index; $i < $this->size - 1; $i++) {
            $this->elements[$i] = $this->elements[$i + 1];
        }
        $this->elements[$this->size - 1] = null;
        $this->size--;
        return $value;
    }

    public function pop(): mixed {
        if ($this->size == 0) {
            throw new \UnderflowException("Array is empty");
        }
        return $this->removeAt($this->size - 1);
    }

    public function resize(): void {
        $this->capacity *= 2;
        $newElements = array_fill(0, $this->capacity, null);
        for ($i = 0; $i < $this->size; $i++) {
            $newElements[$i] = $this->elements[$i];
        }
        $this->elements = $newElements;
    }

    public function dump(): void {
        echo "Size: {$this->size}, Capacity: {$this->capacity} | Elements: [";
        for ($i = 0; $i < $this->size; $i++) {
            echo $this->get($i);
            if ($i < $this->size - 1) echo ", ";
        }
        echo "]\n";
    }
}

// ===========================
// TESTING
// ===========================

$dynamicArray = new DynamicArray();
$dynamicArray->append(1);
$dynamicArray->append(2);
$dynamicArray->append(3);
$dynamicArray->dump();

$dynamicArray->insertAt(1, 4);
$dynamicArray->dump();

$dynamicArray->removeAt(2);
$dynamicArray->dump();

$dynamicArray->pop();
$dynamicArray->dump();

$dynamicArray->dump();

$dynamicArray->set(0, 10);
$dynamicArray->dump();


?>