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
        $this->root = $this->insertRec($this->root, $value);
    }

    private function insertRec(?TreeNode $node, int $value): ?TreeNode {
        if ($node === null) {
            return new TreeNode($value);
        }

        if ($value <= $node->value) {
            $node->left = $this->insertRec($node->left, $value);
        } else {
            $node->right = $this->insertRec($node->right, $value);
        }
        return $node;
    }

    public function search(int $value): bool {
        return $this->searchRec($this->root, $value);
    }

    private function searchRec(?TreeNode $node, int $value): bool {
        if ($node === null) {
            return false;
        }
        if ($node->value === $value) {
            return true;
        }

        if ($value <= $node->value) {
            return $this->searchRec($node->left, $value);
        } else {
            return $this->searchRec($node->right, $value);
        }
    }

    public function inorder(): array {
        $result = [];
        $this->inorderRec($this->root, $result);
        return $result;
    }

    private function inorderRec(?TreeNode $node, array &$result): void {
        if ($node !== null) {
            $this->inorderRec($node->left, $result);
            $result[] = $node->value;
            $this->inorderRec($node->right, $result);
        }
    }

    public function preorder(): array {
        $result = [];
        $this->preorderRec($this->root, $result);
        return $result;
    }

    private function preorderRec(?TreeNode $node, array &$result): void {
        if ($node !== null) {
            $result[] = $node->value;
            $this->preorderRec($node->left, $result);
            $this->preorderRec($node->right, $result);
        }
    }

    public function postorder(): array {
        $result = [];
        $this->postorderRec($this->root, $result);
        return $result;
    }

    private function postorderRec(?TreeNode $node, array &$result): void {
        if ($node !== null) {
            $this->postorderRec($node->left, $result);
            $this->postorderRec($node->right, $result);
            $result[] = $node->value;
        }
    }

    public function delete(int $value): void {
        if ($this->root === null) {
            echo "(Notice: Cannot delete from an empty tree)\n";
            return;
        }
        if (!$this->search($value)) {
            echo "(Notice: Value {$value} not found in tree. No-op.)\n";
            return;
        }

        $this->root = $this->deleteRec($this->root, $value);
    }

    private function deleteRec(?TreeNode $node, int $value): ?TreeNode {
        if ($node === null) {
            return null;
        }

        if ($value < $node->value) {
            $node->left = $this->deleteRec($node->left, $value);
        } else if ($value > $node->value) {
            $node->right = $this->deleteRec($node->right, $value);
        } else {

            if ($node->left === null) {
                return $node->right; 
            } else if ($node->right === null) {
                return $node->left;  
            }

            $successorValue = $this->minValue($node->right);
            $node->value = $successorValue;
            $node->right = $this->deleteRec($node->right, $successorValue);
        }
        return $node;
    }

    private function minValue(TreeNode $node): int {
        $current = $node;
        while ($current->left !== null) {
            $current = $current->left;
        }
        return $current->value;
    }
}

// ==========================================
// Testing
// ==========================================
$bst = new BinarySearchTree();
$items = [8, 3, 10, 1, 6, 14, 4, 7, 13];
foreach ($items as $item) {
    $bst->insert($item);
}

// Tree Traversal
echo "Inorder (Should be sorted ascending): \n[" . implode(', ', $bst->inorder()) . "]\n";
echo "Preorder (Debug node->L->R): \n[" . implode(', ', $bst->preorder()) . "]\n";
echo "Postorder (Debug L->R->node): \n[" . implode(', ', $bst->postorder()) . "]\n\n";

// Search
echo "Search 6 (Exists): " . ($bst->search(6) ? "Found (OK)" : "Not Found") . "\n";
echo "Search 99 (Missing): " . ($bst->search(99) ? "Found" : "Not Found (OK)") . "\n\n";


// Node with 1 child
echo "Delete 14 (Node with 1 child):\n";
$bst->delete(14);
echo "Result Inorder: [" . implode(', ', $bst->inorder()) . "]\n\n";

echo "Delete 13 (Leaf node):\n";
$bst->delete(13);
echo "Result Inorder: [" . implode(', ', $bst->inorder()) . "]\n\n";

// Node with 2 children
echo "Delete 3 (Node with 2 children):\n";
$bst->delete(3);
echo "Result Inorder: [" . implode(', ', $bst->inorder()) . "]\n\n";
// Edge Cases
echo "Delete 99 (Missing value):\n";
$bst->delete(99);

$emptyTree = new BinarySearchTree();
echo "Delete from empty tree:\n";
$emptyTree->delete(5);