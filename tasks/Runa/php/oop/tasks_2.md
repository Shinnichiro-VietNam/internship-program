# PHP Object-Oriented Programming (OOP) Tasks 2

This file contains advanced tasks to practice Object-Oriented Programming (OOP) in PHP, focusing on complex numbers, object collections, and geometric transformations.

## Task List

### Exercise 1: Complex Number Operations

**Requirement:**
📌 _Build a class to represent Complex Numbers with two data components: real and imaginary. Implement methods for input, output, setting values, and performing addition, subtraction, multiplication, and division between two complex numbers._

**OOP Implementation Details:**

- **Class:** `ComplexNumber`
- **Properties:** `$real`, `$imaginary` (private)
- **Methods:** \* `__construct($real, $imaginary)`
  - `add(ComplexNumber $other)`, `subtract()`, `multiply()`, `divide()`
  - `display()`: Format the output as $a + bi$
- **Formula Reference:**
  - **Addition:** $(a_1 + b_1, a_2 + b_2)$
  - **Subtraction:** $(a_1 - b_1, a_2 - b_2)$
  - **Multiplication:** $(a_1b_1 - a_2b_2, a_1b_2 + a_2b_1)$
  - **Division:** $(\frac{a_1b_1 + a_2b_2}{b_1^2 + b_2^2}, \frac{b_1a_2 - a_1b_2}{b_1^2 + b_2^2})$
- **UI:** Input real and imaginary parts for two numbers via an HTML form and display the results of all four operations

---

### Exercise 2: Candidate Management

**Requirement:**
📌 _Create a Candidate class to store student information. Build a TestCandidate class to handle input for $n$ candidates and print information for those whose total score (Math + Literature + English) is greater than 15._

**OOP Implementation Details:**

- **Class:** `Candidate`
- **Properties:** `$id`, `$name`, `$dob`, `$math`, `$literature`, `$english`
- **Methods:** \* `calculateTotalScore()`: Returns the sum of the three subjects
  - `displayInfo()`: Returns a formatted string of the candidate's details
- **Class:** `TestCandidate`
- **Methods:** \* `handleInput($n)`: Logic to process multiple candidate objects
  - `filterPassingCandidates()`: Logic to identify candidates with a total score $> 15$
- **UI:** Allow the user to specify $n$, input details for $n$ candidates, and display the filtered list

---

### Exercise 3: Point Transformations

**Requirement:**
📌 _Establish a class representing a point in a 2D plane with abscissa ($x$) and ordinate ($y$). Implement constructors and methods to change point content, retrieve coordinates, and perform translation and rotation transformations._

**OOP Implementation Details:**

- **Class:** `Point`
- **Properties:** `$x`, `$y` (private)
- **Methods:**
  - `setX($x)`, `setY($y)`, `getX()`, `getY()` (Getters and Setters)
  - `translate($dx, $dy)`: Adjusts the point by a given offset
  - `rotate($angle)`: Rotates the point around the origin $(0,0)$
  - `display()`: Output the current coordinates
- **Rotation Formula:** \* $x_{new} = x \cdot \cos(\alpha) - y \cdot \sin(\alpha)$
  - $y_{new} = x \cdot \sin(\alpha) + y \cdot \cos(\alpha)$
- **UI:** Input initial point coordinates and transformation parameters (offsets or angles) via an HTML form to see the resulting coordinates

---

## ✅ Notes

- **Encapsulation:** Ensure all class properties are `private` or `protected`, using public methods for data access and modification
- **Validation:** For Exercise 1, include logic to prevent division by zero
- **Trigonometry:** In PHP, `sin()` and `cos()` use radians; ensure you convert user-input degrees using `deg2rad()` for Exercise 3
