<?php
declare(strict_types=1);

class MinHeap {
    private array $heap = [];

    public function insert(int $value): void {
        $this->heap[] = $value; 
        $this->siftUp(count($this->heap) - 1); 
    }

    public function peekMin(): int {
        if (empty($this->heap)) {
            throw new Exception("Heap is empty");
        }
        return $this->heap[0];
    }

    public function extractMin(): int {
        if (empty($this->heap)) {
            throw new Exception("Heap is empty");
        }

        $min = $this->heap[0];
        $lastVal = array_pop($this->heap); 

        if (!empty($this->heap)) {
            $this->heap[0] = $lastVal;
            $this->siftDown(0); 
        }

        return $min;
    }

// Shift up
    private function siftUp(int $index): void {
        while ($index > 0) {
            $parentIndex = (int)floor(($index - 1) / 2);
            if ($this->heap[$index] < $this->heap[$parentIndex]) {
                $this->swap($index, $parentIndex);
                $index = $parentIndex; 
            } else {
                break; 
            }
        }
    }

     // sift down - これは子ノードの中で最小のものと比較して、小さい方に入れ替えるメソッドです
    private function siftDown(int $index): void {
        $size = count($this->heap);

        while (true) {
            $leftChild = 2 * $index + 1;
            $rightChild = 2 * $index + 2;
            $smallest = $index; 

            if ($leftChild < $size && $this->heap[$leftChild] < $this->heap[$smallest]) {
                $smallest = $leftChild;
            }

            if ($rightChild < $size && $this->heap[$rightChild] < $this->heap[$smallest]) {
                $smallest = $rightChild;
            }

            if ($smallest === $index) {
                break;
            }

            $this->swap($index, $smallest);
            $index = $smallest; 
        }
    }

    private function swap(int $i, int $j): void {
        $temp = $this->heap[$i];
        $this->heap[$i] = $this->heap[$j];
        $this->heap[$j] = $temp;
    }
}

// ==========================================
// Testing
// ==========================================
$heap = new MinHeap();

$values = [15, 3, 8, 10, 1, 7, 20];
foreach ($values as $val) {
    $heap->insert($val);
}

while (true) {
    try {
        echo $heap->extractMin() . " ";
    } catch (Exception $e) {
        break;
    }
}
echo "\n";