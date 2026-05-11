# Algorithms Tasks 1 (1 Week)

This file contains a **1-week plan**. Focus on writing correct implementations, then improving them with better complexity, then practicing problem solving.

## Big-O (Quick Explanation)

- **What Big-O means**: Big‑O describes how runtime (or memory) grows as input size \(n\) grows. It focuses on growth rate, not exact seconds.
- **Drop constants**: \(O(2n)\) becomes \(O(n)\), \(O(n + 100)\) becomes \(O(n)\).
- **Keep the dominant term**: \(O(n^2 + n)\) becomes \(O(n^2)\).
- **Typical patterns**:
  - One loop over \(n\) items → \(O(n)\)
  - Two nested loops over \(n\) items → \(O(n^2)\)
  - Divide-and-conquer (halving the search space) → \(O(\log n)\) (e.g., binary search)
  - Sort then scan → \(O(n \log n) + O(n)\) → \(O(n \log n)\)
- **Space complexity**: extra memory used besides the input (e.g., merge sort uses extra arrays, recursion uses call stack).

## Task List

**Exercise 1: Loops vs Recursion (Fibonacci)**

- To show the difference between loops and recursion, implement solutions to find Fibonacci numbers in three different ways in `task_1/ex_1.php`:
  1. An implementation of Fibonacci using a `for` loop.
  2. An implementation of Fibonacci using recursion.
  3. Finding the \(n\)-th Fibonacci number using recursion.
- Then analyze those functions in `task_1/notes.md`:
  - Time complexity and space complexity for each implementation.
  - What happens when \(n\) becomes large (and why).

**Exercise 2: Quadratic Sorts (Bubble / Selection / Insertion)**

- In `task_1/ex_2.php`, implement from scratch:
  - Bubble sort
  - Selection sort
  - Insertion sort
- For each, record in `task_1/notes.md`:
  - Worst-case time, best-case time, space

---

**Exercise 3: Sort Behavior Experiments**

- In `task_1/ex_3.php`, generate arrays:
  - already sorted, reverse sorted, random, many duplicates, nearly sorted
- Measure runtime roughly using `microtime(true)` and compare behaviors.
- Summarize findings in `task_1/notes.md` (no need for perfect benchmarking).

**Exercise 4: Merge Sort Implementation**

- In `task_1/ex_4.php`, implement merge sort:
  - `mergeSort(array $arr): array`
  - `merge(array $left, array $right): array`

---

**Exercise 5: Quick Sort Implementation**

- In `task_1/ex_5.php`, implement quicksort.
- Requirement:
  - Choose a pivot strategy (first/last/middle/random) and describe it in `notes.md`.
  - Avoid worst-case on already-sorted input if possible (random/middle pivot is recommended).

**Exercise 6: Practical Sorting Tasks**

- In `task_1/ex_6.php`, solve:
  1. Sort an array of integers ascending and descending (use your merge sort, then reverse for desc).
  2. Sort an array of associative arrays by a numeric key (e.g., `score` as shown below `$students = [
  ['name' => 'A', 'score' => 70],
  ['name' => 'B', 'score' => 95],
  ['name' => 'C', 'score' => 70],
];`) **without using built-in sort**.
  3. Stable sorting check: keep original order for equal keys (e.g. `['name' => 'A', 'score' => 70], ['name' => 'C', 'score' => 70]` should remain in that order).

---

**Exercise 7: Linear Search**

- In `task_1/ex_7.php`, implement:
  - `linearSearch(array $arr, int $target): int` returning index, or `-1` if not found
  - Extend to return **all indices** where `target` appears

**Exercise 8: Binary Search + Bounds**

- In `task_1/ex_8.php`, implement iterative binary search:
  - `binarySearch(array $sortedArr, int $target): int`
- Handle duplicates by also implementing:
  - `lowerBound(...)` (first index where value >= target)
  - `upperBound(...)` (first index where value > target)

---

**Exercise 9: Search Practice Set**

- Solve in `task_1/ex_9.php`:
  - Given an array and a value, output how many times it appears.
  - Given an array, output the first index of the max value.
  - Given an array, check if it is sorted ascending.
- For each, write complexity analysis in `task_1/notes.md`.

**Exercise 10: Binary Search Practice**

- In `task_1/ex_10.php`, solve:
  1. Find first and last position of `target` in a sorted array (use bounds).
  2. Count occurrences of `target` in a sorted array (use bounds).
  3. Given a sorted array, find the smallest element >= `x` (ceil) and largest <= `x` (floor).
  4. Given a monotonic function implemented as PHP code, find the smallest `k` such that `f(k) >= x` (binary search on answer).

**Exercise 11: Partition Thinking**

- In `task_1/ex_11.php`, implement:
  1. Partition array into `< pivot`, `= pivot`, `> pivot` (three-way partition).
  2. Use it to solve: find the k-th smallest element (Quickselect-style idea).
- Note complexity expectations and edge cases.

**Exercise 12: Mixed Practice Set**

- In `task_1/ex_12.php`, solve:
  1. Merge two sorted arrays into one sorted array.
  2. Given an array, find the number of inversions (bonus: try \(O(n \log n)\) via merge sort idea).
  3. Given a rotated sorted array (no duplicates), find the minimum element (binary search).

## Notes

- Keep your code readable and consistent (function naming, input parsing, output formatting).
- The goal is not only “working code”, but also correct complexity reasoning and test coverage.
