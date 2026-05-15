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
- The recursive version doubles in computational complexity with every increase of n by 1 (O(2^n)), so it is not practical for large values of n.
- 一方でループ版は n に比例して増えるだけ（O(n)）なので非常に高速である。
- In contrast, the loop version only increases in complexity proportionally to n (O(n)), making it very fast.

## What happens when $n$ becomes large?

- As n increases, the recursive approach becomes impractically slow.
- $n$ が大きくなると、Recursiveは実用不可能なほど遅くなる。
    - This is because the number of duplicate calculations increases exponentially in the recursive version.
    - 再帰版では同じ計算の重複が爆発的に増えるから。

---

# Exercise 2 分析メモ / Memo

### Complexity Table

| Algorithm      | Worst-case Time | Best-case Time | Space Complexity |
| -------------- | --------------- | -------------- | ---------------- |
| Bubble Sort    | O(n^2)          | O(n^2)         | O(1)             |
| Selection Sort | O(n^2)          | O(n^2)         | O(1)             |
| Insertion Sort | O(n^2)          | O(n)           | O(1)             |

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

---

# Exercise 3 分析メモ / Memo

### Execution time / 実行時間

| DataType                   | Bubble Sort       | Selection Sort    | Insertion Sort       |
| -------------------------- | ----------------- | ----------------- | -------------------- |
| Random (ランダム)          | 0.59063696861267s | 0.30870795249939s | 0.22142815589905s    |
| Already Sorted（整列済み） | 0.34134197235107s | 0.29096698760986s | 0.00028300285339355s |
| Reverse Sorted （逆順）    | 0.70332789421082s | 0.33289098739624s | 0.46356105804443s    |
| Many duplicates（重複多）  | 0.56826114654541s | 0.30158686637878s | 0.20118808746338s    |
| Nearly sorted （ほぼ整列） | 0.33410882949829s | 0.30074286460876s | 0.00029802322387695s |

### 考察 / Inspection

- **Bubble Sort**
    - 逆説のときに一番時間がかかった。
    - The paradox took the longest to figure out.
    - 整列済みでも他のと比べてすごい早くなるわけではないとわかった。
    - I realized that even when the data is sorted, it doesn’t make things that much faster compared to other methods.

- **Selection Sort**
    - データの並び順に関わらず、実行時間がほとんど変わらなかった。
    - The execution time remained virtually unchanged regardless of the order of the data.
    - 理由：どんな並びでも、常に最小値を探すために配列を最後まで見に行くから。
    - Reason: Because it always checks the entire array to find the minimum value, regardless of the order.

- **Insertion Sort**
    - **Already Sorted** や　**Nearly Sorted** が圧倒的に早かった。
    - **Already Sorted** and **Nearly Sorted** were by far the fastest.
    - 理由：すでに並んでいる場合は、値を動かす必要がなく、比較だけで済むから。
    - Reason: If the values are already in order, there is no need to reorder them; a simple comparison is sufficient.

### まとめ / Summary

- データが1000件を超えると、O(n^2)のアルゴリズムでも数秒の差が出ることがわかった。特に挿入ソートは、元々ある程度並んでいるデータに対しては非常に効率的だが、逆順のデータには弱いという特性を数値で確認できた。
- We found that when the dataset exceeds 1,000 records, even O(n²) algorithms can result in a difference of several seconds. In particular, we were able to confirm through numerical analysis that while insertion sort is highly efficient for data that is already somewhat sorted, it performs poorly on data that is in reverse order.

---

# exercise 5 分析メモ / Memo

### Pivot Strategy

- Middle（真ん中）
    - 理由：入力配列がすでに整列されていたり、ほぼ整列されていたりする場合でも、O(n \log n)のパフォーマンスを維持するため。最初の要素や最後の要素を選択すると、そのようなケースでは計算量が O(n^2)に悪化してしまう。
    - Reason: This is to maintain O(n \log n) performance even when the input array is already sorted or nearly sorted. Selecting the first or last element would cause the time complexity to degrade to O(n^2) in such cases.

---

# Exercise 9 分析メモ / Memo

## 値の出現回数のカウント / count value

- 計算量/Complexity: **O(n)**
- 理由/Reason:
    - 配列の要素数に対して、最初から最後まで全ての要素を1回ずつ確認する必要があるため。
    - This is because you need to check every element exactly once, from the beginning to the end, for the entire array.

## 最大値の最初のIndex取得 / find max index

- 計算量/Complexity: **O(n)**
- 理由/Reason:
    - 配列内の最大値を特定するためには、必ず配列の全要素を一度は比較しなければならないため。
    - This is because, in order to identify the maximum value in an array, you must compare every element in the array at least once.

## 昇順ソートのチェック / is sorted

- 計算量/Complexity: **O(n)**（最悪のケース/Worst-case scenario）
- 理由/Reason:
    - 最悪のケース/Worst-case scenario
        - 配列が完全に昇順である場合、最後まで比較を繰り返す必要がある。
        - If the array is completely in ascending order, the comparison must be repeated until the end.
    - 最良のケース/Best-case scenario
        - 配列の冒頭で順序が崩れている場合は O(1) で終了できるが、アルゴリズムとしては最悪ケースの O(n) となる。
        - If the order is already disrupted at the beginning of the array, the operation can be completed in O(1) time, but the algorithm has a worst-case time complexity of O(n).
