# Data Structures Tasks 1 (1 Week)

This file contains a **1-week plan**. Focus on correct ADT implementations first, then complexity analysis, then applying structures to small problems.

## ADT vs Implementation (Quick Explanation)

- **ADT (Abstract Data Type)**: _what_ operations exist and their meaning (e.g., Stack: `push`, `pop`, `peek` — LIFO).
- **Implementation**: _how_ it is stored in memory (array backing, linked nodes, hash buckets, etc.).
- **PHP `array` note**: PHP arrays are ordered hash maps. They are convenient storage, but this module trains you to implement **explicit** structures and reason about cost (random access vs insert-at-head, etc.).
- **Typical complexities** (average case unless stated):

| Structure          | Access     | Search   | Insert (end)    | Insert (head) | Delete           |
| ------------------ | ---------- | -------- | --------------- | ------------- | ---------------- |
| Dynamic array      | O(1)       | O(n)     | O(1)\*          | O(n)          | O(n)             |
| Singly linked list | O(n)       | O(n)     | O(1)            | O(1)          | O(n)             |
| Stack (array)      | top O(1)   | —        | push O(1)\*     | —             | pop O(1)\*       |
| Queue (circular)   | front O(1) | —        | enqueue O(1)\*  | —             | dequeue O(1)\*   |
| Hash table         | —          | O(1)\*   | O(1)\*          | —             | O(1)\*           |
| BST (balanced)     | —          | O(log n) | O(log n)        | —             | O(log n)         |
| Binary heap        | min O(1)   | —        | insert O(log n) | —             | extract O(log n) |

\* Amortized or depends on resizing / load factor / balancing.

---

## Task List

**Exercise 1: Dynamic Array (ArrayList)**

- In `task_1/ex_1.php`, implement a `DynamicArray` class backed by a PHP array with manual capacity growth:
  - `size(): int` — number of elements in use
  - `get(int $index): mixed`
  - `set(int $index, mixed $value): void`
  - `append(mixed $value): void`
  - `insertAt(int $index, mixed $value): void`
  - `removeAt(int $index): mixed` (return removed value)
  - `pop(): mixed` (remove last element; throw or print a clear error if empty)
- **Storage model:** keep private `$capacity` (allocated slots) and `$size` (logical length). Only indices `0 .. size-1` hold valid data. Start with **capacity 8**, **size 0**.
- When `size == capacity` before an `append` or `insertAt`, **resize** (copy elements into a new backing array with **double** capacity).
- **Out of range:** for `get`, `set`, `insertAt`, `removeAt` — if index `< 0` or `> size` (or `>= size` for `get`/`set`/`removeAt`), throw `\OutOfRangeException` or exit with a clear CLI message (pick one and be consistent).
- **CLI demo:** append a few values, `insertAt` in the middle, `removeAt`, print `size` and elements via a helper or loop.
- Document amortized `append` cost in `task_1/notes.md`.

**Exercise 2: Singly Linked List**

- In `task_1/ex_2.php`, implement `ListNode` (`value`, `next`) and `SinglyLinkedList`:
  - `append(mixed $value): void`
  - `prepend(mixed $value): void`
  - `insertAt(int $index, mixed $value): void` — valid index `0 .. size` (insert at `size` appends)
  - `deleteAt(int $index): void` — valid index `0 .. size-1`
  - `indexOf(mixed $value): int` — return **first** index, or **`-1`** if not found
  - `reverse(): void` — **in-place** (reuse nodes, rewire `next` pointers)
  - `toArray(): array` — values from head to tail
  - `size(): int`
- **Empty list:** `toArray()` → `[]`, `indexOf` → `-1`, `deleteAt` on empty → error (same style as Ex 1).
- **CLI demo:** build a list, print `toArray`, `reverse`, print again.
- In `notes.md`: compare random access vs `DynamicArray` from Exercise 1.

**Exercise 3: Doubly Linked List**

- In `task_1/ex_3.php`, implement `DoublyListNode` (`value`, `prev`, `next`) and `DoublyLinkedList`:
  - `append(mixed $value): void`
  - `prepend(mixed $value): void`
  - `search(mixed $value): ?DoublyListNode` — return the **first** node with that value, or `null`
  - `deleteAt(int $index): void` — remove by index (`0 .. size-1`); **required** (do not require callers to hold node references)
  - `toArray(): array`, `size(): int`
- **Deleting a node** once you have its reference is **O(1)** (rewire `prev`/`next`). **Finding** by index is **O(n)** — document this in `notes.md`.
- **Bonus (optional):** `deleteNode(DoublyListNode $node): void` for O(1) removal when you already have the node (e.g. from `search`).
- **CLI demo:** append/prepend, `search` + `deleteAt`, print `toArray`.

---

**Exercise 4: Stack ADT**

- In `task_1/ex_4.php`:
  1. Implement `ArrayStack` with `push`, `pop`, `peek`, `isEmpty`, `size` (use your `DynamicArray` from Ex 1 **or** a fixed backing array + size index).
  2. Implement `LinkedStack` with the same methods (push/pop at **head**; you may reuse `ListNode` from Ex 2).
- Apply stacks (either implementation is fine per function):
  - `isValidParentheses(string $s): bool` — support `()`, `[]`, `{}` only; ignore other characters or treat them as invalid (document your choice).
  - `evalPostfix(string $expr): int` — input is **space-separated** tokens, e.g. `"3 4 + 2 *"`; operators: `+`, `-`, `*`, `/` on integers; `/` is **integer division** toward zero (PHP `/` cast to int is fine). Assume valid RPN (no error handling required beyond optional notes).
- **CLI demo:** run both functions on at least two sample inputs each.
- Record time/space for each stack operation in `notes.md`.

**Exercise 5: Queue ADT**

- In `task_1/ex_5.php`:
  1. **`CircularArrayQueue`** (fixed capacity **8** for this exercise):
     - Fields: backing array, `front` index, `size` (or `rear` + `size` — document in `notes.md`).
     - `enqueue(mixed $item): void` — error if **full** (`size == capacity`).
     - `dequeue(): mixed` — error if **empty**.
     - `peek(): mixed`, `isEmpty(): bool`, `size(): int`
     - Advance indices with **modulo** `capacity`; **do not** shift the whole array on dequeue.
     - **Empty:** `size == 0`. **Full:** `size == capacity`.
  2. **`LinkedQueue`:** maintain **`head` and `tail`** pointers so `enqueue` is O(1) at tail and `dequeue` is O(1) at head.
- **CLI demo (task queue):** hard-code or read a short list of job names; enqueue all, then dequeue until empty and print each name (FIFO). Example output shape:
  ```
  Enqueued: A, B, C
  Dequeued: A
  Dequeued: B
  Dequeued: C
  ```
- In `notes.md`: why circular array avoids O(n) shift on dequeue.

**Exercise 6: Deque (Optional Extension)**

- In `task_1/ex_6.php`, implement a `Deque` (double-ended queue) using a **circular array** or doubly linked list:
  - `addFirst`, `addLast`, `removeFirst`, `removeLast`, `peekFirst`, `peekLast`
- Use it to check if a string is a palindrome (ignore spaces/case optional).

---

**Exercise 7: Hash Table (Separate Chaining)**

- In `task_1/ex_7.php`, implement `HashTable`:
  - `put(string|int $key, mixed $value): void` — if key exists, **update** the value (do not duplicate entries in the bucket).
  - `get(string|int $key): mixed|null` — return `null` if missing.
  - `remove(string|int $key): bool` — return `true` if removed, `false` if key was not present.
  - `keys(): array` — all keys currently stored; **any order** is fine.
- Requirements:
  - Fixed bucket count (**16**) with **separate chaining**: each bucket is a PHP array (or small list) of `[key, value]` pairs.
  - Private `hash(string|int $key): int` — e.g. for strings: sum of `ord()` of characters mod 16 (or a better mix — document choice).
  - **CLI:** at least **3** `put` calls that land in the **same bucket** (show bucket index in comments or output) to prove collision handling works.
- In `notes.md`: average O(1) assumptions and when degradation happens (many keys in one bucket).

**Exercise 8: Hash Table Practice**

- In `task_1/ex_8.php`, implement these functions. Use your **`HashTable` from Ex 7** where it makes sense; a plain PHP array used as a map is acceptable only if you document why in `notes.md`.
  1. `twoSum(array $nums, int $target): array` — return **`[i, j]`** with `i < j` such that `$nums[i] + $nums[j] == $target`. Assume **exactly one** solution exists. One-pass with a map of `value → index`.
  2. `firstNonRepeating(string $s): int` — return the **index** of the first character that appears once, or **`-1`** if none. One pass to count, one pass to find (or document a single-pass approach).
  3. `groupAnagrams(array $words): array` — return an array of groups, each group an array of words that are anagrams. Example: `['eat','tea','tan','ate','nat','bat']` → `[['eat','tea','ate'], ['tan','nat'], ['bat']]` (order within/between groups may vary).
- **CLI demo:** one sample input per function with printed output.
- Write time/space complexity for each in `notes.md`.

---

**Exercise 9: Binary Search Tree**

- In `task_1/ex_9.php`, implement `TreeNode` (`value`, `left`, `right`) and `BinarySearchTree`.

**BST invariant (write in `notes.md`):** for every node, every value in the **left** subtree is **less than** the node, and every value in the **right** subtree is **greater than** the node.

- **Duplicates:** choose one rule (e.g. “equal goes left”) and use it for both `insert` and `search`.

**Required methods:**

| Method                     | Behavior                                                                                                            |
| -------------------------- | ------------------------------------------------------------------------------------------------------------------- |
| `insert(int $value): void` | Start at root; go **left** if smaller, **right** if larger; attach a new leaf when you hit `null`.                  |
| `search(int $value): bool` | Same comparisons as `insert`; return `false` if you reach `null`.                                                   |
| `inorder(): array`         | Visit **left → node → right**. On a correct BST, the result is **sorted ascending** — use this to verify your tree. |
| `preorder(): array`        | **node → left → right** (useful for debugging).                                                                     |
| `postorder(): array`       | **left → right → node** (useful for debugging).                                                                     |
| `delete(int $value): void` | See the three cases below.                                                                                          |

**Delete — use the inorder-successor strategy (document all three cases in `notes.md`):**

1. **0 children (leaf):** remove the node (set parent’s pointer to `null`).
2. **1 child:** replace the node with its only child (bypass the node).
3. **2 children:** find the **inorder successor** (smallest value in the **right** subtree), copy that value into the node to delete, then delete the successor node (the successor has **at most one child**, so case 1 or 2 applies).

**CLI demo (`ex_9.php`):**

- Insert a fixed list (e.g. `[8, 3, 10, 1, 6, 14, 4, 7, 13]`) and print `inorder` (should be sorted).
- `search` for a value that exists and one that does not.
- `delete` three times on purpose: a **leaf**, a node with **one child**, and a node with **two children** — print `inorder` after each delete.

**Edge cases to handle:** empty tree, delete from empty tree, search/delete missing value (no-op or clear message).

**Implementation note:** parent pointers are **not** required; use recursion or track the parent only inside `delete`.

**Exercise 10: BST Practice**

- In `task_1/ex_10.php`, add methods on your `BinarySearchTree` from Ex 9 (or thin wrappers):
  1. `min(): int` / `max(): int` — leftmost / rightmost value; error or exception if tree is empty.
  2. `height(): int` — number of **edges** on the longest path; **empty tree → `0`**, single node → `0`.
  3. `isValidBST(): bool` — verify the **BST invariant** on the tree you built in Ex 9 (walk nodes and check left `< node < right). Do **not** parse level-order input for this exercise.
  4. `kthSmallest(int $k): int` — **`k` is 1-based** (`k = 1` is smallest); use inorder; error if `k` is out of range.
- **CLI demo:** insert a fixed set of values, call all four methods, print results.
- In `notes.md`: worst-case O(n) when the tree is skewed; mention balancing (no AVL/red-black implementation).

**Exercise 11: Min-Heap (Basics)**

- In `task_1/ex_11.php`, implement `MinHeap` with a PHP array (document in `notes.md` whether index `0` is unused or the root is at `0`, and the parent/child index formulas).
  - `insert(int $value): void` — append, then sift **up**
  - `peekMin(): int` — return the root without removing; **error if empty**
  - `extractMin(): int` — swap root with last element, remove last, sift **down**; **error if empty**
  - On sift **down**, compare with the **smaller** child when two children exist.
- CLI demo: insert several integers, then repeatedly `extractMin` and print — output should be **ascending**.
- In `notes.md`: time complexity of `insert` and `extractMin` (O(log n)) and why.

**Exercise 12: Graph (Adjacency List) + BFS & DFS**

- In `task_1/ex_12.php`, implement an **undirected** `Graph` with an adjacency list (`array` mapping vertex id → list of neighbor ids):
  - `addVertex(string|int $id): void`
  - `addEdge(string|int $a, string|int $b): void` — store the edge in **both** adjacency lists
  - `getNeighbors(string|int $id): array`
  - `bfs(string|int $start): array` — return vertex ids in **visit order** from `$start` only
  - `dfs(string|int $start): array` — same, using iterative **or** recursive DFS (state which in `notes.md`)
- Use a **`visited`** set (array keys or separate list) in both traversals so each vertex is processed once per call.
- **One application** (pick one; name the function clearly):
  - `countComponents(): int` — loop over **all** vertices; each time you find an unvisited vertex, run BFS or DFS from it and increment the count, **or**
  - `shortestPathLength(string|int $start, string|int $target): int` — BFS with distance map; return **`-1`** if `$target` is unreachable
- **CLI demo:** build a graph with 5–8 vertices (include at least two components if you chose `countComponents`), print BFS order, DFS order, and your application result.
- In `notes.md`: a short BFS vs DFS comparison (when you would use each). Directed graphs and cycle detection are **not** required here.

---

## Notes

- Keep code readable: one class per file is fine, or group related classes in the same exercise file if small.
- The goal is not only working code, but also **correct complexity reasoning** and **tests for edge cases** (empty input, single node, duplicates, full queue, hash collisions).
- If you finish early, optional stretch (not required): `heapify` / k-largest (Ex 11), directed graph or cycle detection (Ex 12), or sketch **LRU cache** design (hash map + doubly linked list) in `notes.md` without full implementation.
