# PHP Object-Oriented Programming (OOP) Tasks 3

This module focuses on **Utility Classes**, **Static Methods**, and **Algorithm Optimization** based on integer manipulation and number theory.

## Task List

### Exercise 1: Advanced Integer Analytics

**Requirement:**
📌 _Instead of writing separate scripts for basic digit operations, build a robust `NumberProcessor` class that encapsulates all digit-based logic for a positive integer $n$._

**OOP Implementation Details:**

- **Class:** `NumberProcessor`
- **Properties:** `$number` (private)
- **Methods:** \* `__construct($n)`: Must validate that $n$ is a positive integer.
  - `getAnalytics()`: Returns an associative array containing:
    - Sum, count, and product of all digits.
    - The first digit and the reversed version of the number (e.g., $123 \to 321$).
    - Max and min digits, including the frequency of their occurrence.
  - `isSymmetric()`: Returns `true` if the number is a palindrome (e.g., $121$, $88$).
  - `isOrdered()`: Returns `1` if digits are strictly increasing, `-1` if strictly decreasing, and `0` otherwise.
- **UI:** A single input field for $n$. The output should be a clean HTML table displaying all the analytics above.

---

### Exercise 2: The "Largest K" Series Solver

**Requirement:**
📌 _Implement the logic for finding the largest integer $k$ such that the triangular sum $S(k) = 1 + 2 + 3 + \dots + k < n$._

**OOP Implementation Details:**

- **Class:** `SeriesSolver`
- **Methods:** \* `findMaxK($n)`: Use a loop to find $k$, but also provide a **bonus** method using the quadratic formula for $O(1)$ efficiency.
- **Formula Reference:** \* The sum is defined as: $S(k) = \frac{k(k + 1)}{2}$.
  - To find $k$ instantly, solve the inequality $\frac{k^2 + k}{2} < n$ using the quadratic formula.
- **UI:** Input $n$, output the value of $k$ and the resulting sum $S(k)$ to verify the result is less than $n$.

---

### Exercise 3: Math Utility (Static Methods)

**Requirement:**
📌 _Create a utility class for common mathematical operations. Since these methods do not require an object "state," implement them as **static methods**._

**OOP Implementation Details:**

- **Class:** `MathUtil`
- **Static Methods:**
  - `gcd($a, $b)`: Find the Greatest Common Divisor using the Euclidean Algorithm (use the modulo operator `%`).
  - `lcm($a, $b)`: Find the Least Common Multiple using the formula: $LCM(a, b) = \frac{|a \cdot b|}{GCD(a, b)}$.
  - `isAllOdd($n)`: Returns `true` if every digit in the number is odd, `false` otherwise.
- **UI:** Input two numbers $a$ and $b$ to find GCD/LCM, and a separate input to check the "All Odd" property of a number.

---

## ✅ Notes

- **Encapsulation:** Keep properties private and use getters if needed.
- **Static vs. Instance:** Notice Exercise 1 uses an object instance (`new NumberProcessor`), while Exercise 3 uses static calls (`MathUtil::gcd`). Understand that static methods are for tools, while instances are for objects with data.
- **Performance:** For GCD, do not use a simple loop from $1$ to $n$. The Euclidean algorithm is significantly more professional.
- **Type Hinting:** Practice using PHP 8+ type hinting (e.g., `public function gcd(int $a, int $b): int`).
- **Validation:** Always sanitize HTML form inputs and ensure numbers are positive where required.
