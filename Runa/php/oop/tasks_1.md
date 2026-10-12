# PHP Object-Oriented Programming (OOP) Tasks 1

This file contains tasks to practice Object-Oriented Programming (OOP) in PHP. Remember to include an HTML UI in the same file to interact with your PHP objects as specified in the `README.md`.

## Task List

### Exercise 1: Fraction Operations

**Requirement:**
📌 _Write a program to input two (non-negative) fractions. a. Find the largest fraction and output the result. b. Calculate the sum, difference, product, and quotient between them and output the results._

**OOP Implementation Details:**

- Create a `Fraction` class.
- **Properties:** `$numerator`, `$denominator`.
- **Methods:** `add()`, `subtract()`, `multiply()`, `divide()`, `compare()`, `display()`.
- **UI:** Input two fractions via an HTML form and output the results.

---

### Exercise 2: Next Date Calculation

**Requirement:**
📌 _Write a program to input a date. Find the next date and output the result._

**OOP Implementation Details:**

- Create a `CustomDate` class.
- **Properties:** `$day`, `$month`, `$year`.
- **Methods:** `isValidDate()`, `isLeapYear()`, `getNextDate()`, `display()`.
- **UI:** Input a date via an HTML form and display the next day's date.

---

### Exercise 3: Student Average Score

**Requirement:**
📌 _Write a program to input the full name, math score, and literature score of a student. Calculate the average score and output the result._

**OOP Implementation Details:**

- Create a `Student` class.
- **Properties:** `$fullName`, `$mathScore`, `$literatureScore`.
- **Methods:** `calculateAverage()`, `displayInfo()`.
- **UI:** Input student details via an HTML form and display their average score and info.

---

### Exercise 4: Array Sorting and Point Geometry

**Requirement 4a:**
📌 _Write a program to input an array of n integer elements (entered by the user) and output the array in ascending order._

**OOP Implementation Details 4a:**

- Create an `IntegerArray` class.
- **Properties:** `$elements` (an array).
- **Methods:** `sortAscending()`, `displayArray()`.
- **UI:** Input the array elements via an HTML form (e.g., a comma-separated string) and display the sorted array.

**Requirement 4b:**
📌 _Build a Point structure to represent points in the Oxy plane (coordinates are real numbers). Write a program allowing the user to input n points and output the 2 points with the largest distance among the entered points._

**OOP Implementation Details 4b:**

- Create a `Point` class.
- **Properties:** `$x`, `$y`.
- **Methods:** `calculateDistance(Point $otherPoint)` to find distance to another point.
- Create a `PointCollection` class to manage an array of `Point` objects.
- **Methods:** `addPoint(Point $p)`, `findMaxDistancePoints()` which returns the two points furthest from each other.
- **UI:** Input multiple points via an HTML form and display the coordinates of the two points with the largest distance.

---

## ✅ Notes

- Ensure you apply proper OOP principles like **Encapsulation** (use `private`/`protected` properties and provide getter/setter methods if necessary).
- You are allowed to mix the HTML and PHP logic inside the same file for each exercise.
- Test your classes thoroughly with different edge cases (e.g., fraction denominators cannot be zero, leap years for date logic).
