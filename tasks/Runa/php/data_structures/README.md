# Data Structures Assignment for Interns

Welcome! This module builds on the **Algorithms** module. You will implement core data structures from scratch in PHP, analyze their complexity, and use them to solve practical problems.

**Important Note:**
For the best interest of trainees to gain the most from the internship program.
Using AI tools (e.g., ChatGPT, GitHub Copilot) is strictly limited. Consult your trainer first before using any AI assistance to ensure proper learning and compliance.

---

## 📂 Assignments

1. **Project Structure**
   - Identify the `README.md` and task documentation files in this folder.
   - For the assignment in `tasks_1.md`, create a folder named `task_1/`.
   - Put your PHP source code inside `task_1/` (e.g., `ex_1.php`, `ex_2.php`, ...).
   - Add a markdown file `task_1/notes.md` containing:
     - Your time/space complexity analysis for each exercise
     - Short notes on **when to choose** each structure (trade-offs)

2. **Rules for Coding**
   - Implement structures **yourself** (classes with methods). Do **not** use SPL types such as `SplStack`, `SplQueue`, or `SplDoublyLinkedList` unless the task explicitly allows it.
   - PHP’s built-in `array` is fine as **internal storage** (backing array, bucket list, adjacency list), but you must still implement the ADT operations (push, pop, hash, traverse, etc.) in your own classes.
   - Do **not** rely on `array_shift` / `array_unshift` for queue or deque core operations in performance-critical paths—use index pointers or linked nodes as described in the tasks.
   - Write reusable classes where appropriate. Use `declare(strict_types=1);` at the top of each file.
   - Validate inputs (empty structure, invalid index, null keys, cycles in linked lists).

3. **How to Run**
   - Prefer CLI execution with small demo scripts in each file:
     - `php ex_1.php`
   - You may add a minimal HTML form UI only when a task asks for user input; keep it simple.

4. **Prerequisites**
   - Complete the **Algorithms** module (sorting, searching, Big-O) before starting this module.
   - Review `tasks/Runa/php/algorithms/tasks_1.md` if you need a refresher on complexity notation.

---

## 📚 Resources

- [Interactive tutorials for Data Structures and Algorithms](https://www.w3schools.com/dsa/index.php)
- [Japanese Data Structures and Algorithms Tutorial](https://www.codereading.com/algo_and_ds/)
- [PHP Manual: Arrays (ordered hash map behavior)](https://www.php.net/manual/en/language.types.array.php)
- [GeeksforGeeks: Data Structures](https://www.geeksforgeeks.org/data-structures/)

---

## ✅ Expected Results

By completing this module, you should be able to:

- Explain the difference between an **abstract data type (ADT)** and a **concrete implementation**.
- Implement and compare linear structures: dynamic array, singly/doubly linked list, stack, and queue.
- Implement a hash table with collision handling and use it in real problems.
- Implement a binary search tree with traversals and common operations.
- Implement a binary heap and use it as a priority queue.
- Represent a graph and run BFS and DFS; apply them to simple problems.
- Document time/space complexity and choose the right structure for a given constraint.
