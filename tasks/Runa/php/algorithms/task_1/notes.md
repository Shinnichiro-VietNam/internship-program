# Exercise 1 分析メモ / Memo

## Complexity

### Iterative

- Time Complexity: **O(n)**
- Space Complexity: **O(1)**

### Recursive

- Time Complexity: **O(2^n)**
- Space Complexity: **O(n)**

### n=10

- どちらも一瞬。
- Both happen in the blink of an eye.

### n=30

- ループ版は相変わらず一瞬だが、再帰版は少し待ち時間が発生した。
- The loop version is still instantaneous, but the recursive version took a little longer to run.

### n=35

- 再帰版はさらに数倍の時間がかかった。
- The recursive version took several times longer.

## 考察

- 再帰版は n が 1 増えるごとに計算量が倍々で増えていく（O(2^n)）ため、大きな n に対しては実用的ではない。
- 一方でループ版は n に比例して増えるだけ（O(n)）なので非常に高速である。
- The recursive version doubles in computational complexity with every increase of n by 1 (O(2^n)), so it is not practical for large values of n.
- In contrast, the loop version only increases in complexity proportionally to n (O(n)), making it very fast.

## What happens when $n$ becomes large?

- As n increases, the recursive approach becomes impractically slow.
- $n$ が大きくなると、Recursiveは実用不可能なほど遅くなる。
    - This is because the number of duplicate calculations increases exponentially in the recursive version.
    - 再帰版では同じ計算の重複が爆発的に増えるから。

# Exercise 2 分析メモ / Memo

### Complexity Table

| Algorithm      | Worst-case Time | Best-case Time | Space Complexity |
| -------------- | --------------- | -------------- | ---------------- |
| Bubble Sort    | O(n^2)          | O(n^2)         | O(1)             |
| Selection Sort | O(n^2)          | O(n^2)         | O(1)             |
| Insertion Sort | O(n^2)          | O(n)           | O(1)             |

# Exercise 2: Sorting Algorithm Complexity Analysis

## Complexity Table

| Algorithm      | Worst-case Time | Best-case Time | Space Complexity |
| -------------- | --------------- | -------------- | ---------------- |
| Bubble Sort    | $O(n^2)$        | $O(n^2)$       | $O(1)$           |
| Selection Sort | $O(n^2)$        | $O(n^2)$       | $O(1)$           |
| Insertion Sort | $O(n^2)$        | $O(n)$         | $O(1)$           |

---

## Analysis of Sorting Algorithms

### 1. Bubble Sort

- **Worst-case (O(n^2)):**
  入力が逆順の場合、すべての隣接要素を比較・交換する必要がある。
  If the input is in reverse order, you must compare and swap all adjacent elements.

- **Best-case (O(n^2)):**
  現在の実装では、すでに整列済みであってもループを最後まで回すため、最悪時と同じ計算量になる。
  In the current implementation, the loop runs to the end even if the data is already sorted, so the computational complexity is the same as in the worst-case scenario.

- **Space (O(1)):**
  追加の配列を作成せず、元の配列内で入れ替えを行うため、メモリ消費は一定。
  Since the swap is performed in-place within the original array without creating an additional array, memory usage remains constant.

---

### 2. Selection Sort

- **Worst-case (O(n^2)):**
  常に未ソート部分から最小値を探すスキャンが必要。
  A scan is required to find the minimum value from the unsorted portion.

- **Best-case (O(n^2)):**
  データの並び順に関わらず「最小値を探す」という動作を繰り返すため、計算量は変わらない
  Since the operation of "finding the minimum value" is repeated regardless of the order of the data, the computational complexity remains the same.

- **Space (O(1)):**
  入れ替え用の変数のみを使用するため、非常に効率的。
  It is highly efficient because it uses only replacement variables.

---

### 3. Insertion Sort

- **Worst-case (O(n^2)):**
  入力が逆順の場合、各要素を挿入するたびに既存の全要素をずらす必要がある。
  If the input is in reverse order, all existing elements must be shifted whenever a new element is inserted.

- **Best-case (O(n)):**
  すでに整列されている場合、左隣と比較してすぐに次の要素へ移れるため、1回のスキャンで完量する。
  If the elements are already sorted, the algorithm can immediately move on to the next element by comparing it with the one to its left, allowing the entire list to be processed in a single pass.

- **Space (O(1)):**
  配列内での移動のみであり、追加のメモリを必要としない。
  It only involves moving within the array and does not require additional memory.
