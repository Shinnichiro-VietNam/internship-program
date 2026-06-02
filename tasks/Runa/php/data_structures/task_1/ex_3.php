<?php
declare(strict_types=1);

// Node class
class DoublyListNode {
    public mixed $value;
    public ?DoublyListNode $prev = null;
    public ?DoublyListNode $next = null;

    public function __construct(mixed $value) {
        $this->value = $value;
    }
}


class DoublyLinkedList {
    private ?DoublyListNode $head = null;
    private ?DoublyListNode $tail = null;
    private int $size = 0;

    public function size(): int {
        return $this->size;
    }


    public function append(mixed $value): void {
        $newNode = new DoublyListNode($value);
        if ($this->head === null) {
            $this->head = $newNode;
            $this->tail = $newNode;
        } else {
            $this->tail->next = $newNode;
            $newNode->prev = $this->tail;
            $this->tail = $newNode;
        }
        $this->size++;
    }

    public function prepend(mixed $value): void {
        $newNode = new DoublyListNode($value);

        if ($this->head === null) {
            $this->head = $newNode;
            $this->tail = $newNode;
        } else {
            $newNode->next = $this->head;
            $this->head->prev = $newNode;
            $this->head = $newNode;
        }
        $this->size++;
    }

    public function search(mixed $value): ?DoublyListNode {
        $current = $this->head;
        while ($current !== null) {
            if ($current->value === $value) {
                return $current;
            }
            $current = $current->next;
        }
        return null;
    }

    public function deleteNode(DoublyListNode $node): void {
        if ($node === $this->head) {
            $this->head = $node->next;
            if ($this->head !== null) {
                $this->head->prev = null;
            } else {
                $this->tail = null;
            }
        } elseif ($node === $this->tail) {
            $this->tail = $node->prev;
            if ($this->tail !== null) {
                $this->tail->next = null;
            } else {
                $this->head = null;
            }
        } else {
            $node->prev->next = $node->next;
            $node->next->prev = $node->prev;
        }
        $this->size--;
    }

    public function deleteAt(int $index): void {
        if ($index < 0 || $index >= $this->size) {
            throw new \OutOfRangeException("Index out of range: {$index}");
        }

        $current = $this->head;
        for ($i = 0; $i < $index; $i++) {
            $current = $current->next;
        }

        $this->deleteNode($current);
    }

    public function toArray(): array {
        $array = [];
        $current = $this->head;
        while ($current !== null) {
            $array[] = $current->value;
            $current = $current->next;
        }
        return $array;
    }
}

// ===========================
// Testing
// ===========================

$doublyLinkedList = new DoublyLinkedList();
$doublyLinkedList->append(1);
$doublyLinkedList->append(2);
$doublyLinkedList->append(3);
$doublyLinkedList->append(4);
$doublyLinkedList->append(5);

echo "Initial: " . implode(', ', $doublyLinkedList->toArray()) . "\n";

$found = $doublyLinkedList->search(3);
if ($found !== null) {
    echo "Searched '3': Found value " . $found->value . "\n";
}

$doublyLinkedList->deleteAt(2);
echo "After deleteAt(2): " . implode(', ', $doublyLinkedList->toArray()) . "\n";
echo "Size: " . $doublyLinkedList->size() . "\n";