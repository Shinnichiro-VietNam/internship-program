# DataStructures task / データ構造課題

## Rules(MarkDownfile) / ルール

- Your time/space complexity analysis for each exercise
- 各演習における時間・空間の計算量分析
- Short notes on when to choose each structure (trade-offs)
- 各構造をいつ選択すべきかについての簡単なメモ（トレードオフ）

# Ex_1: Dynamic Array - Amortized Append Cost Analysis

## 1. Time Complexity

- **Normal Case / 普通の場合:** O(1)
- **Worst Case (Resize) / 悪い場合（リサイズ）:** O(n)
- **Amortized Cost / アモルタイズの場合:** O(1)

---

## 2. Core Explanation

- **Standard Append (O(1)):** When the underlying array has empty slots, inserting an element at the current `$size` index takes constant time.
- **標準的な末尾への追加 (O(1))**: 基となる配列に空きスロットがある場合、現在の $size インデックスに要素を挿入するには定数時間しかかからない。
- **Resizing Append (O(n)):** When `$size == $capacity`, a new array with **double** the capacity is allocated, and all n existing elements are copied via a loop. This requires linear time.
- **リサイズと追加（O(n)）**：$size == $capacity の場合、容量が 2 倍の新しい配列が割り当てられ、ループを通じて既存の n 個の要素すべてがコピーされる。これには線形時間が必要。

---

## 3. Why Amortized Cost is O(1) / なぜアモルタイズがO(1)なのか？

By **doubling** the capacity on each resize, the expensive O(n) operations happen less frequently as the array grows.

リサイズを行うたびに**容量**を2倍にすることで、配列が大きくなるにつれて、計算コストの高いO(n)の操作が行われる頻度が少なくなる。

こうしたリサイズの総コストを、n回の追加操作からなる長いシーケンス全体に分散すると、1回の追加操作あたりの数学的な平均作業量は定数以下に抑えられる。そして、アモルタイズ時間計算量は**O(1)**となる。

When distributing the total cost of these rare resizes across a long sequence of n append operations, the mathematical average work per single append is bounded by a constant. Therefore, the amortized time complexity is **O(1)**.

---

# Exercise 2 - Random Access Comparison

| Operation / 操作       | DynamicArray (Exercise 1)                       | SinglyLinkedList (Exercise 2)                                        |
| :--------------------- | :---------------------------------------------- | :------------------------------------------------------------------- |
| **Random Access Cost** | **O(1)** (Constant time)                        | **O(n)** (Linear time)                                               |
| **Memory Layout**      | Contiguous blocks of memory. 連続したメモリ領域 | Dispersed nodes linked by pointers. ポインタで連結された分散ノード。 |

### Explanation / 実験

- **DynamicArray (Exercise 1):** Elements are stored next to each other in a single contiguous block of memory. Because of this layout, the computer can instantly calculate the exact memory address of any given index. This allows **O(1)** instant random access via `get($index)`.

- **DynamicArray（演習1）**：要素は、メモリ上の単一の連続したブロック内に隣接して格納される。この配置により、コンピュータは任意のインデックスに対応する正確なメモリアドレスを瞬時に計算できる。これにより、`get($index)` を通じて **O(1)** の瞬時のランダムアクセスが可能になる。

- **SinglyLinkedList (Exercise 2):** Nodes are scattered across completely different locations in memory. To access the i-th element, the program cannot jump directly to it; it must start from the `head` and follow each node's `next` pointer one by one. Therefore, random access requires traversing the list, resulting in an **O(n)** time complexity.

- **単方向連結リスト（演習2）**：ノードはメモリ上のまったく異なる場所に分散して配置されている。i番目の要素にアクセスする場合、プログラムはその要素に直接ジャンプすることはできず、`先頭` から開始し、各ノードの`next` ポインタを一つずつたどる必要がある。そして、ランダムアクセスを行うにはリストを走査する必要があり、その結果、時間計算量は**O(n)**となる。

---

# Exercise 3 - Doubly Linked List Performance / 双方向連結リストの性能

### Time Complexity Evaluation / 計算量の評価

- **Finding a node by index (`deleteAt`):** **O(n)**
  To delete a node at a specific index, the program must start from the `head` and traverse the list linearly one by one until it reaches the targeted position. This operation requires linear time because we do not have direct access to middle elements.

- **インデックスによるノードの探索 (`deleteAt`)：** **O(n)**
  特定のインデックスにあるノードを削除する場合、プログラムは `head（先頭）` から開始し、目的の位置に達するまでリストを1つずつ線形に走査する必要がある。中央の要素に直接アクセスする手段がないため、この操作には線形時間（要素数に比例した時間）がかかる。

- **Deleting a node with a direct reference (`deleteNode`):** **O(1)**
  Once you already have a direct reference to a node (for example, a node object returned from the `search()` method), the actual deletion takes constant time. Because each node in a doubly linked list inherently holds pointers to both its `prev` and `next` neighbors, we can immediately rewire the surrounding pointers to bypass the target node without any traversal loops.

- **直接の参照によるノードの削除 (`deleteNode`)：** **O(1)**
  （`search()` メソッドなどから返された）ノードへの直接の参照をすでに持っている場合、実際の削除処理は定数時間で完了する。双方向連結リストの各ノードは、自身の `prev（前）` と `next（次）` の両方の隣接ノードへのポインタを本質的に保持しているため、走査ループを行うことなく、周囲のポインタを即座につなぎ替えて対象ノードをスキップさせることができる。

---

# Exercise 4: Stack ADT / スタック抽象データ型

### 1. Complexity for Stack Operations / 各スタック操作の計算量

| Operation / 操作 | ArrayStack (Time / Space)     | LinkedStack (Time / Space) |
| :--------------- | :---------------------------- | :------------------------- |
| **push()**       | **O(1)** amortized / **O(1)** | **O(1)** / **O(1)**        |
| **pop()**        | **O(1)** / **O(1)**           | **O(1)** / **O(1)**        |
| **peek()**       | **O(1)** / **O(1)**           | **O(1)** / **O(1)**        |
| **isEmpty()**    | **O(1)** / **O(1)**           | **O(1)** / **O(1)**        |
| **size()**       | **O(1)** / **O(1)**           | **O(1)** / **O(1)**        |

- **ArrayStack:** `push()` takes **O(1)** on average, but can occasionally take **O(n)** time due to dynamic array resizing in PHP. Total space complexity is **O(n)**.
- **ArrayStack：** `push()` は平均 **O(1)** だけど、PHP内部の動的配列のリサイズにより一時的に **O(n)** になることがある。全体の空間計算量は **O(n)**
- **LinkedStack:** All operations strictly guarantee **O(1)** time because elements are manipulated directly at the `head` node without any data shifting.
- **LinkedStack：** データのシフトが発生せず、常に `head`で要素を操作するため、すべての操作で厳密に **O(1)** 時間を保証する。

---

### 2. Algorithm Specification: `isValidParentheses` / アルゴリズムの仕様

- **Handling of Non-Parentheses Characters:**
    - **Choice:** **IGNORE**
    - **Description:** Any characters other than `()`, `[]`, and `{}` are explicitly ignored. This approach allows the function to seamlessly validate the logical nesting of brackets within text or mathematical expressions.

- **かっこ以外の文字の扱い：**
    - **選択：** **無視 (IGNORE)**
    - **説明：** `()`, `[]`, `{}` 以外の文字はすべて明示的に無視する。これにより、数式や文章の中に含まれるかっこであっても、その論理的な入れ子構造だけを正確に検証できる。

---

# Exercise 5: Queue ADT / キュー抽象データ型

### Why Circular Array Avoids O(n) Shifts on Dequeue

- **The Problem with Standard Arrays:** In a standard array-based queue, removing an element from the front (`dequeue`) leaves an empty slot at index 0. To fix this, all remaining elements must be shifted forward by one position, which takes **O(n)** time.
- **The Circular Array Solution:** A circular array conceptualizes the fixed-size array as a ring. Instead of shifting data physically, we simply advance the `front` index using the modulo operator `front = (front + 1) % capacity`. This allows the data to stay in place, turning the operation into a strict **O(1)** time complexity.

### なぜ循環配列は dequeue 時の O(n) シフトを回避できるのか

- **通常の配列の問題点：** 通常の配列で先頭から要素を取り出す（`dequeue`）と、インデックス0番目の要素が空になる。これを詰めるために後ろにあるすべてのデータを1つずつ前にズラす必要があり、**O(n)** の時間がかかってしまう。
- **循環配列による解決策：** 固定配列の先頭と末尾を円状につなぎます。データを物理的にずらすのではなく、`front`を指すインデックス番号のほうを `(front + 1) % capacity` という数式で1つ進めるだけで処理を完結させる。これにより、データを一切移動させることなく、常に高速な **O(1)** で取り出すことができる。

---

# Exercise 6: Deque (Double-Ended Queue) / 両端キュー

### 1. Complexity / 各操作の計算量

- **Time Complexity (時間計算量):** 全操作 **O(1)**
- **Space Complexity (空間計算量):** 全操作 **O(1)**

- **Note:** Utilizing a circular array avoids O(n) data shifting at both ends.
- **補足：** 循環配列を使うことで、両端での追加・削除において配列内のデータシフトを完全に回避し、すべて O(1) で処理できる。

---

### 2. Palindrome Verification / 回文判定の仕様

- **Algorithm:**
    1. Lowercase and remove spaces from the string.
    2. Insert all characters into the Deque using `addLast()`.
    3. Compare characters from both ends simultaneously using `removeFirst()` and `removeLast()` in a `while` loop.
    4. Return `false` on any mismatch, or `true` if the loop finishes successfully.

- **アルゴリズム：**
    1. 文字列を小文字化し、スペースを除去。
    2. 全文字を `addLast()` で Deque の末尾に投入。
    3. `while` ループ内で `removeFirst()` と `removeLast()` を使い、両端から同時に1文字ずつ取り出して比較。
    4. 不一致があれば即座に `false`、すべて一致してループを抜ければ `true` と判定。

---

## Exercise 7: Hash Table (Separate Chaining) / ハッシュテーブル

### 1. Complexity & Degradation / 計算量と性能低下について

- **Average Time Complexity (平均時間計算量):** **O(1)**
- **Worst-Case Time Complexity (最悪時間計算量):** **O(n)**

#### Assumptions for O(1) / O(1) になる前提条件

- **Uniform Distribution:** Keys must be evenly distributed across all buckets by a good hash function, keeping the chain in each bucket as short as possible.
- **均一分散:** 優れたハッシュ関数によって、キーがすべてのバケツに均等に分散され、各バケツの中身が常に短く保たれている必要がある。

#### When Degradation Happens / 性能が低下する原因

- **Hash Collision:** If many keys hash to the exact same bucket, the chain becomes long. Searching inside that bucket turns into a sequential search, degrading the time complexity towards **O(n)**.
- **ハッシュ衝突:** 多くのキーが同じバケツに集中すると、バケツの中の配列が長くなります。そのバケツ内を走査するために結局ループを回す必要があるため、最悪の場合 **O(n)** まで遅くなってしまう。

---

## Exercise 8: Hash Table Practice / ハッシュテーブルの実践

### 1. Complexity of Functions / 各関数の計算量

| Function / 関数         | Time Complexity / 時間計算量 | Space Complexity / 空間計算量 |
| :---------------------- | :--------------------------- | :---------------------------- |
| **twoSum()**            | **O(n)**                     | **O(n)**                      |
| **firstNonRepeating()** | **O(n)**                     | **O(1)**                      |
| **groupAnagrams()**     | **O(n \* m log m)**          | **O(n \* m)**                 |

### 2. Brief Descriptions / 理由の解説

- **twoSum:** Single-pass loop checking the hash table for the complement. Average table lookup takes O(1), resulting in **O(n)** total time.
- **firstNonRepeating:** Two independent passes over the string. Characters are bound to standard ASCII/extended sets, keeping table space at **O(1)**.
- **groupAnagrams:** Iterates through `n` words, sorting each word of length `m` which takes O(m \log m) time. Groups are aggregated efficiently using the hash table.

- **twoSum:** 配列を1周する間にハッシュテーブルから相方を平均 O(1) で探すため、全体で **O(n)**。
- **firstNonRepeating:** 文字列を2周（独立したループ）走査。文字の種類は高々256種のため、空間計算量は最大でも定数の **O(1)**。
- **groupAnagrams:** `n` 個の単語を走査し、長さ `m` の単語をソートするのに O(m \log m) かかるため、全体で **O(n \* m \log m)**。

---

# Exercise 9: Binary Search Tree (BST) / 二分探索木

### 1. BST Invariant & Duplicate Rules / BSTの不変条件と重複ルール

- **BST Invariant (不変条件):** For every node, all values in its left subtree are less than or equal to the node's value, and all values in its right subtree are greater than the node's value.
- **不変条件の補足:** すべてのノードにおいて、「左側のすべての子孫ノードの値 \le 自分の値 < 右側のすべての子孫ノードの値」という配置ルールが常に保たれる。
- **Duplicate Rule (重複の扱い):** "Equal goes left" (等しい値はすべて左側の枝へ挿入・検索する).

---

### 2. Deletion Strategy (3 Cases) / 削除の3つのケース

- **Case 0 (Leaf node):** Remove the node immediately by setting its parent's pointer to `null`.
    - **子ノードが0個:** 対象のノードをそのまま削除し、親からのポインタを `null` にする。
- **Case 1 (1 child):** Replace the node with its only child, bypassing the deleted node entirely.
    - **子ノードが1個:** 対象のノードをスキップし、その唯一の子ノードを親に直接つなぎ替える。
- **Case 2 (2 children):** Find the _inorder successor_ (the smallest value in the right subtree), copy its value into the target node, and then recursively delete that successor node.
    - **子ノードが2個:** 右側の枝の中で「一番小さい値」を探してきて自分の値を上書きし、右側の枝からそのコピー元の古いノードを再帰的に削除する。

---

## Exercise 10: BST Practice / 二分探索木の応用

### 1. Skewed Tree and Worst-Case O(n) / 偏った木と最悪計算量

- **Worst-Case Complexity:** **O(n)** for search, insert, and delete operations.
- **Why it happens:** If data is inserted in an already sorted order, the BST transforms into a straight line resembling a Linked List. It loses its branching advantage, meaning we must traverse all $n$ nodes sequentially.
- **最悪計算量 O(n):** 探索・挿入・削除のすべてが最悪の場合 **O(n)** になる。
- **原因:** すでにソートされたデータ（例: `[1, 2, 3, 4, 5]`）をそのまま順番に挿入すると、木が左右に枝分かれせず一直線に伸びてしまい、実質的に連結リストと同じ構造になってしまう.

---

### 2. Tree Balancing / 木の平衡（バランス）について

- **Solution for O(log n):** To guarantee an optimal **O(log n)** time complexity, the tree must be kept "balanced" (the left and right subtrees maintain nearly equal heights).
- **Self-Balancing Trees:** Advanced data structures like **AVL Trees** or **Red-Black Trees** automatically rotate and re-balance themselves during insertion or deletion to prevent skewing.
- **解決策:** 常に高速な **O(log n)** を維持するためには、左右の枝の高さが均等になるよう木を平衡に保つ必要がある。
- **平衡二分探索木:** データの追加や削除のたびに、木が自動的に回転してバランスを整える **AVL木** や **赤黒木（Red-Black Tree）** といった発展的なデータ構造が存在する。

---

# Exercise 11: Min-Heap (Basics) / 最小ヒープの基本

### 1. Array-Based Representation / 配列による表現ルール

- **Root Location / 根の位置:** Index `0` (0番目をルートとして使う)
- **Parent Index / 親のインデックス:** `(int)floor(($i - 1) / 2)`
- **Left Child / 左の子:** `2 * $i + 1`
- **Right Child / 右の子:** `2 * $i + 2`

---

### 2. Time Complexity / 計算量

| Method / メソッド                 | Time Complexity / 時間計算量 |
| :-------------------------------- | :--------------------------- |
| **insert()** (挿入)               | **O(log n)**                 |
| **extractMin()** (最小値取り出し) | **O(log n)**                 |

#### Why? / なぜ O(log n) か？

- **Tree Height / 木の高さ:**
  A Min-Heap is always a _Complete Binary Tree_, so its height is at most $\log_2 n$.
  (ヒープは隙間なく詰まった完全二分木なので、木の高さは $\log_2 n$ に収まる)

- **insert():**
  Appends to the bottom and moves up (`siftUp`).
  Worst case takes steps equal to the tree height ➔ **O(log n)**.
  (一番下に追加して上へ入れ替えていくので、最悪でも木の高さ分しか動かない)

- **extractMin():**
  Moves the last element to the root and sinks down (`siftDown`).
  Worst case also takes steps equal to the tree height ➔ **O(log n)**.
  (ルート削除後に末尾要素を上へ持ってきて下へ沈めるので、こちらも最悪で木の高さ分だけ動く)

---

## Exercise 12: Graph (Adjacency List) + BFS & DFS

### 1. Graph Implementation Details

- **DFS Approach:** Recursive DFS is implemented (`dfsRec`).
- **無向グラフの表現:** 隣接リストを使用。辺の追加時（`addEdge`）に、双方のリストへお互いのIDを登録する。

---

### 2. BFS vs DFS Comparison

| Feature            | BFS (Breadth-First Search)             | DFS (Depth-First Search)                 |
| :----------------- | :------------------------------------- | :--------------------------------------- |
| **Data Structure** | Queue (FIFO)                           | Stack / Recursion (LIFO)                 |
| **Search Style**   | 近い順に輪を広げるように探索           | 行ける底まで突き進んでから戻る           |
| **Best Used For**  | 最短経路（最短ステップ）のバウンド探索 | 全経路の網羅、迷路の解法、依存関係の解決 |

#### 💡 When to use which? / どっちをいつ使うか？

- **BFSを使うべきケース:** ネットワーク上の一番近いターゲットや、最小の手数を確実に知りたいとき。エッジの数が最小のルートが最初に見つかる保証がある。
- **When to use BFS:** When you need to reliably find the nearest target in a network or the path with the fewest steps (the shortest path). It guarantees that the route with the fewest edges will be found first.
- **DFSを使うべきケース:** グラフの奥深くまで探索したいときや、すべてのルートを網羅してチェックしたいとき。行き止まりまで進んで戻る挙動（バックトラック）が必要なパズルや迷路の解決に向いている。
- **When to use DFS:** When you want to explore deep into a graph or check all possible paths. It is well-suited for solving puzzles and mazes that require backtracking—that is, moving forward until reaching a dead end and then returning.
