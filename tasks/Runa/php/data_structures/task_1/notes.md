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
