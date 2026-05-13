# 振り返りと考察 / Self-Reflection

## 1. Which SOLID principles were easiest to apply?（どの原則を適用するのが最も簡単でしたか？）

- SRP (Single Responsibility Principle) が最も直感的で理解しやすかったです。
- The Single Responsibility Principle (SRP) was the most intuitive and easy to understand.

- 一つのクラスが計算、保存、表示、など複数の役割を持っていた「悪い例」を、それぞれの機能ごとにクラスを分けるだけで、コードの見通しが劇的に良くなりました。シンプルに**1クラス＝1機能**というルールを守るだけで効果が出るため、一番最初に取り組むべき重要な原則だと感じました。
- In a "bad example" where one class had multiple roles such as calculation, saving, and display, simply separating each function into its own class dramatically improved the code's readability. Because it's effective simply by adhering to the rule of **1 class = 1 function**, I felt it was an important principle that should be addressed first.

## 2. Which principles were harder to understand?（理解するのが難しかった原則はどれですか？）

- LSP (Liskov Substitution Principle) の理解に最も時間がかかりました。
- Understanding the Liskov Substitution Principle (LSP) took the longest.

- 最初は、子クラスで親のメソッドを上書きすればいいだけではと考えていましたが、実際には親クラスを期待している場所に子クラスを置いたとき、プログラムが予期せぬ挙動をしてはいけないという深い意味があることを学びました。特に、ペンギンの例を通じて「継承」よりも**インターフェースによる機能の分離**が有効な場合があることを理解するのに苦労しました。
- Initially, I thought it was simply a matter of overriding the parent's methods in the child class, but I learned that it actually has a deeper meaning: when you place a child class where the parent class is expected, the program shouldn't behave unexpectedly. In particular, I struggled to understand, through the penguin example, that **separation of functionality through interfaces** can sometimes be more effective than "inheritance."

## 3. What principles improved your code structure the most?（どの原則が最もコード構造を改善しましたか？）

- DIP と OCP が、私のコード構造を最も大きく改善してくれました。
- DIP and OCP have made the biggest improvements to my code structure.
- これまではクラスの中で直接別のクラスを new していましたが、DIPを適用して外部から入れるようにし、さらにOCPに従ってインターフェースを定義することで、**既存のコードを一切触らずに新しい機能を追加できる** という柔軟な設計を実現できました。この2つを組み合わせることで、テストがしやすく、変更に強い設計にできたと思いました。
- Previously, I was directly instantiating other classes within a class, but by applying DIP to allow external inclusion and defining interfaces according to OCP, I was able to achieve a flexible design that allows me to **add new functionality without touching any existing code**. By combining these two, I believe I was able to create a design that is easy to test and resilient to changes.
