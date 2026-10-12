<?php
declare(strict_types=1);

class TreeNode {
    public int $value;
    public ?TreeNode $left = null;
    public ?TreeNode $right = null;

    public function __construct(int $value) {
        $this->value = $value;
    }
}

class BinarySearchTree {
    private ?TreeNode $root = null;

    public function insert(int $value): void {
        $this->root = $this->doInsert($this->root, $value);
    }

    private function doInsert(?TreeNode $node, int $value): ?TreeNode {
        if ($node === null) {
            return new TreeNode($value);
        }
        if ($value <= $node->value) {
            $node->left = $this->doInsert($node->left, $value);
        } else {
            $node->right = $this->doInsert($node->right, $value);
        }
        return $node;
    }

    public function inorder(): array {
        $result = [];
        $this->collectInorder($this->root, $result);
        return $result;
    }

    private function collectInorder(?TreeNode $node, array &$result): void {
        if ($node !== null) {
            $this->collectInorder($node->left, $result);
            $result[] = $node->value;
            $this->collectInorder($node->right, $result);
        }
    }

    public function min(): int {
        if ($this->root === null) {
            throw new Exception("木が空っぽなので最小値はありません");
        }
        $current = $this->root;
        while ($current->left !== null) {
            $current = $current->left;
        }
        return $current->value;
    }

    public function max(): int {
        if ($this->root === null) {
            throw new Exception("木が空っぽなので最大値はありません");
        }
        $current = $this->root;
        while ($current->right !== null) {
            $current = $current->right;
        }
        return $current->value;
    }

    public function height(): int {
        if ($this->root === null) {
            return 0;
        }
        return $this->calcHeight($this->root);
    }

    private function calcHeight(?TreeNode $node): int {
        if ($node === null) {
            return -1;
        }
        $left = $this->calcHeight($node->left);
        $right = $this->calcHeight($node->right);
        return max($left, $right) + 1;
    }


    public function isValidBST(): bool {
        $arr = $this->inorder();
        if (count($arr) <= 1) {
            return true;
        }
        for ($i = 0; $i < count($arr) - 1; $i++) {
            if ($arr[$i] > $arr[$i + 1]) {
                return false;
            }
        }
        return true;
    }

    public function kthSmallest(int $k): int {
        $arr = $this->inorder();
        if ($k < 1 || $k > count($arr)) {
            throw new Exception("指定されたk番目（" . $k . "）は範囲外です");
        }
        return $arr[$k - 1];
    }
}

// ==========================================
// Testing
// ==========================================
$bst = new BinarySearchTree();
$items = [8, 3, 10, 1, 6, 14, 4, 7, 13];

echo "Insert data into the tree\n";
foreach ($items as $item) {
    $bst->insert($item);
}

echo "Results\n";
echo "最小値: " . $bst->min() . " (期待値: 1)\n";
echo "Max: " . $bst->max() . " (Expected: 14)\n";
echo "Height: " . $bst->height() . "\n";
echo "Is Valid BST: " . ($bst->isValidBST() ? "No problem" : "Problem") . "\n";
echo "3rd smallest value: " . $bst->kthSmallest(3) . " (Expected: 4)\n";