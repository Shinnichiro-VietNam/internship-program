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
