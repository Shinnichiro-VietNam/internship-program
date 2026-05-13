# Exercise 1 分析メモ / Memo

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

- 再帰版は $n$ が 1 増えるごとに計算量が倍々で増えていく（O(2^n)）ため、大きな n に対しては実用的ではない。
- 一方でループ版は n に比例して増えるだけ（O(n)）なので非常に高速である。
- The recursive version doubles in computational complexity with every increase of n by 1 (O(2^n)), so it is not practical for large values of n.
- In contrast, the loop version only increases in complexity proportionally to n (O(n)), making it very fast.
