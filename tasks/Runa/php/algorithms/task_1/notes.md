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
