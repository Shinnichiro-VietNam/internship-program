# PHP SOLID Principles Assignment for Interns

Welcome! This guide will help you understand the SOLID principles and apply them in PHP through practical coding and refactoring exercises.

**Important Note:**
For the best interest of trainees to gain the most from the internship program.
Using AI tools (e.g., ChatGPT, GitHub Copilot) is strictly limited. Consult your trainer first before using any AI assistance to ensure proper learning and compliance.

---

## Assignments

1. **SOLID Principles Summary**
   - Review and study the provided materials related to SOLID principles.
   - Create a markdown file named `solid_summary.md`.
   - Summarize your understanding of the five principles:
     - Single Responsibility Principle (SRP)
     - Open/Closed Principle (OCP)
     - Liskov Substitution Principle (LSP)
     - Interface Segregation Principle (ISP)
     - Dependency Inversion Principle (DIP)
   - For each principle, include:
     - A short definition in your own words
     - A simple PHP example
     - A short explanation of why the design is better

2. **PHP SOLID Refactoring Assignment**
   - Given five bad-code examples in this folder:
     - `srp.php`
     - `ocp.php`
     - `lsp.php`
     - `isp.php`
     - `dip.php`
   - Each file intentionally violates one SOLID principle.
   - Your task is to review each bad example, identify what is wrong, and refactor it into a better design.
   - For every principle, submit:
     - The original bad example from the provided file, you could change the original code with HTML UI if needed.
     - Your explanation of the problem in markdown, a short note explaining how the refactor improves the design
     - The refactored version
   - The provided bad examples are based on these violations:
     - `SRP`: One class handles multiple responsibilities such as business logic, file storage, and output formatting.
     - `OCP`: A class must be edited every time a new case is added, such as adding a new payment type with more `if/else` or `switch` logic.
     - `LSP`: A subclass changes expected behavior or breaks assumptions made by the parent class.
     - `ISP`: A class is forced to implement methods it does not need.
     - `DIP`: A high-level class directly depends on a low-level concrete class instead of an abstraction.
   - If relevant to your exercise, create a simple HTML User Interface (UI) so users can interact with your PHP code. You may mix PHP and HTML in the same files for this exercise.

3. **Reflection Notes**
   - Add a short markdown file named `solid_reflection.md`.
   - Explain:
     - Which SOLID principles were easiest to apply
     - Which principles were harder to understand
     - What principles improved your code structure the most

4. **Hints**
   - Focus on one principle at a time when refactoring.
   - Use interfaces and abstract classes to help with OCP and DIP.
   - Keep your classes focused on a single responsibility for SRP.
   - Ensure that subclasses can be substituted for their parent classes without breaking functionality for LSP.
   - Avoid forcing classes to implement methods they do not need for ISP.

---

## Working Rule

Do not start by writing a completely new solution from scratch. First, understand the bad example, explain the design problem, and then refactor it step by step into a cleaner structure.

---

## Resources

- [SOLID: Illustration](https://qiita.com/baby-degu/items/d058a62f145235a0f007) - Illustration in Japanese.
- [SOLID Examples](https://zenn.dev/sdb_blog/articles/055279215c0149) - Examples of design patterns and SOLID principles in PHP.
- [SOLID Principles in PHP](https://www.phptutorial.net/php-oop/php-solid/) - Beginner-friendly overview of SOLID in PHP.
- [PHP OOP Documentation](https://www.php.net/manual/en/language.oop5.php) - Official PHP object-oriented programming documentation.

---

## Expected Results

By completing these assignments, you should be able to:

- Explain the purpose of each SOLID principle clearly.
- Identify design problems in basic PHP code.
- Refactor code into smaller, more maintainable parts.
- Use interfaces and abstractions appropriately.
- Build PHP code that is easier to extend, test, and maintain.
