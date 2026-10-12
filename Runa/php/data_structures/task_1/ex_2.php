<?php
declare(strict_types=1);

class ListNode {
    public int $value;
    public ?ListNode $next;

    public function __construct(mixed $value) {
        $this->value = $value;
        $this->next = null;
    }
}

class SinglyLinkedList {
    private ?ListNode $head = null;
    private int $size = 0;

    public function size(): int {
        return $this->size;
    }

    public function append(mixed $value): void {
        $newNode = new ListNode($value);
        if ($this->head == null) {
            $this->head = $newNode;
        } else {
            $current = $this->head;
            while ($current->next != null) {
                $current = $current->next;
            }
            $current->next = $newNode;
        }
        $this->size++;
    }

    public function prepend(mixed $value): void {
        $newNode = new ListNode($value);
        $newNode->next = $this->head;
        $this->head = $newNode;
        $this->size++;
    }

    public function insertAt(int $index, mixed $value): void {
        if ($index < 0 || $index > $this->size) {
            throw new \OutOfRangeException("Index out of range: {$index}");
        }
        if ($index === 0) {
            $this->prepend($value);
            return;
        }
        if ($index === $this->size) {
            $this->append($value);
            return;
        }
        $prev = $this->head;
        for ($i = 0; $i < $index-1; $i++) {
            $prev = $prev->next;
        }

        $newNode = new ListNode($value);
        $newNode->next = $prev->next;
        $prev->next = $newNode;
        $this->size++;
    }

    public function deleteAt(int $index): void {
        if ($index < 0 || $index >= $this->size) {
            throw new \OutOfRangeException("Index out of range: {$index}");
        }
        if ($index === 0) {
            $this->head = $this->head->next;
            $this->size--;
            return;
        }
        $prev = $this->head;
        for ($i = 0; $i < $index-1; $i++) {
            $prev = $prev->next;
        }

        $prev->next = $prev->next->next;
        $this->size--;
    }

    public function indexOf(mixed $value): int {
        $current = $this->head;
        $index = 0;
        while ($current != null) {
            if ($current->value == $value) {
                return $index;
            }
            $current = $current->next;
            $index++;
        }
        return -1;
        }

    public function reverse(): void {
        $current = $this->head;
        $prev = null;
        $next = null;

        while ($current != null) {
            $next = $current->next;
            $current->next = $prev;
            $prev = $current;
            $current = $next;
        }
        $this->head = $prev;
    }

    public function toArray(): array {
        $array = [];
        $current = $this->head;
        while ($current != null) {
            $array[] = $current->value;
            $current = $current->next;
        }
        return $array;
    }

}

// ===========================
// TESTING
// ===========================

$singlyLinkedList = new SinglyLinkedList();
$singlyLinkedList->append(1);
$singlyLinkedList->append(2);
$singlyLinkedList->append(3);

$singlyLinkedList->prepend(0);
$singlyLinkedList->insertAt(1, 4);
$singlyLinkedList->deleteAt(2);

echo implode(', ', $singlyLinkedList->toArray())."\n";
$singlyLinkedList->reverse();
echo implode(', ', $singlyLinkedList->toArray())."\n";
echo $singlyLinkedList->indexOf(2)."\n";
echo $singlyLinkedList->size()."\n";