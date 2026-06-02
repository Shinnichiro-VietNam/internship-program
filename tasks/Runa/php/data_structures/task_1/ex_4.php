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

class ArrayStack {
    private array $storage = [];

    public function push(mixed $value): void {
        $this->storage[] = $value;
    }

    public function pop(): mixed {
        return array_pop($this->storage);
    }

    public function peek(): mixed {
        return end($this->storage);
    }

    public function isEmpty(): bool {
        return empty($this->storage);
    }

    public function size(): int {
        return count($this->storage);
    }
}

class LinkedStack {
    private ?ListNode $head = null;
    private int $size = 0;

    public function push(mixed $value): void {
        $newNode = new ListNode($value);
        $newNode->next = $this->head;
        $this->head = $newNode;
        $this->size++;
    }

    public function pop(): mixed {
        if ($this->isEmpty()) {
            throw new Exception("Stack is empty");
        }
        $value = $this->head->value;
        $this->head = $this->head->next;
        $this->size--;
        return $value;
    }

    public function peek(): mixed {
        if ($this->isEmpty()) {
            throw new Exception("Stack is empty");
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

function isValidParentheses(string $s): bool {
    $stack = new ArrayStack();
    $length = strlen($s);
    for ($i = 0; $i < $length; $i++) {
        $char = $s[$i];
        if ($char === '(' || $char === '[' || $char === '{') {
            $stack->push($char);
        }
        else if ($char === ')' || $char === ']' || $char === '}') {
            if ($stack->isEmpty()) {
                return false;
            }
            $top = $stack->pop();
            if ($char === ')' && $top !== '(') return false;
            if ($char === ']' && $top !== '[') return false;
            if ($char === '}' && $top !== '{') return false;
        }
    }
    return $stack->isEmpty();
}

function evalPostfix(string $expr): int {
    $stack = new ArrayStack();
    $tokens = explode(' ', trim($expr));
    foreach ($tokens as $token) {
        if ($token === '') continue;
        if ($token === '+' || $token === '-' || $token === '*' || $token === '/') {
            $b = (int)$stack->pop();
            $a = (int)$stack->pop();
            if ($token === '+') $stack->push($a + $b);
            if ($token === '-') $stack->push($a - $b);
            if ($token === '*') $stack->push($a * $b);
            if ($token === '/') $stack->push((int)($a / $b));
        }
        else {
            $stack->push((int)$token);
        }
    }
    return (int)$stack->pop();
}

// ================================
// Testing
// ================================
echo "isValidParentheses: \n";
echo isValidParentheses("()") ? "true" : "false";
echo "\n";
echo isValidParentheses("([])") ? "true" : "false";
echo "\n";
echo isValidParentheses("([)") ? "true" : "false";
echo "\n";
echo isValidParentheses("([})") ? "true" : "false";
echo "\n";
echo isValidParentheses("([{]})") ? "true" : "false";
echo "\n";

echo "evalPostfix: \n";
echo "3 4 + 2 * => " . evalPostfix("3 4 + 2 *") . "\n";
echo "10 3 / => " . evalPostfix("10 3 /") . "\n";
echo "4 13 5 / + => " . evalPostfix("4 13 5 / +") . "\n";