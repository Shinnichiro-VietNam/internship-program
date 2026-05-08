## SOLID Principles

- SOLID is an acronym formed from the first letters of five principles; it refers to design rules that make software easier to maintain. It serves as a guideline for where to place specific source code.

- SOLIDとは、5つの原則の頭文字をとったもので、ソフトウェア設計の際に保守しやすいような設計のルールのこと。どこにどのソースコードを置くのか、その指標となるもの

- **S (Single Responsibility)**
    - The Single Responsibility Principle / 単一責任の原則
        - A class should have a single responsibility.
        - クラスは、単一の責任を持つべきだ。

- **O (Open-Closed)**
    - The Open-Closed Principle / オープン・クローズドの原則
        - A class should be open for extension but closed for modification.
        - クラスは、拡張にはオープンで、変更にはクローズドであるべきだ。

- **L (Liskov Substitution)**
    - Liskov's Substitution Principle / リスコフの置換原則
        - If S is a subtype of T, replacing all T-type objects in a program with S-type objects does not change the program's behavior in any way.
        - SがTのサブタイプである場合、プログラム内のT型のオブジェクトをS型のオブジェクトに置き換えても、そのプログラムの特性は何も変わらない。

- **I (Interface Segregation)**
    - The Principle of Interface Segregation / インターフェイス分離の原則
        - You should not enforce dependencies on methods that the client does not use.
        - クライアントが使用しないメソッドへの依存を、強制すべきではない。

- **D (Dependency Inversion)**
    - The Principle of Dependency Inversion / 依存性逆転の原則
        - Higher-level modules should not depend on lower-level modules. Both should depend on abstractions.
        - 上位モジュールは、下位モジュールに依存してはならない。どちらも抽象化に依存すべきだ。
        - Abstraction should not depend on details. Details should depend on abstraction.
        - 抽象化は詳細に依存してはならない。詳細が抽象化に依存すべきだ。

## Five principles in detail / 5つの原則を詳しく

### SRP(Single Responsibility Principle)

- A short definition in my own words
    - Make sure you can describe that class in a single sentence as 'something used for doing X.'
    - そのクラスを **〇〇をするためのもの** と一言で説明できる ようにすること。

- A simple PHP example
    - ❌Bad: Roles are overlapping / 役割が混ざっている

```code
    class Calculator {
        public function add($a, $b) {
        $result = $a + $b;
        //  It even displays the calculation results 計算結果を表示までしちゃっている
        echo "結果は " . $result . " です";
        }
    }
```

- ⭕️Good: Divide roles / 役割を分ける

```code
    class Math {
        public function add($a, $b) {
            return $a + $b;
        }
    }

    class Display {
        public function show($text) {
            echo "【結果】" . $text;
        }
    }
```

- A short explanation of why the design is better / このデザインが優れている理由についての簡単な説明
    - Ease of repair / 直しやすい
        - If you just want to change the visual appearance, you only need to change the `display` property.
        - 表示の見た目だけを変えたい場合は`display` だけを変更すればいい
    - Easy to reuse / 使い回しやすい
        - In the case of `Bad`, it outputs the result without prompting, so it cannot be used in the app.
        - Badの例だと、勝手にechoしてしまうのでアプリでは使えない。

### OCP(Open/Closed Principle)

- A short definition in my own words
    - When adding new features, ensure that you can simply add new code rather than having to rewrite the existing code
    - 機能を追加するときに、元々あるコードを書き換えるのではなく、新しいコードを付け足すだけで済むようにする

- A simple PHP example
    - ❌Bad: Every time a new feature is added, I end up rewriting the original class. / 新機能が増えるたびに、元のクラスを書き換えている

```code
    class AnimalSound {
    public function makeOutput($animalType) {
        if ($animalType === 'dog') {
            return "ワンワン";
        } elseif ($animalType === 'cat') {
            return "ニャーにゃー";
        }
        // 新しく要素を追加したいとき、この既存の関数を書き換える必要がある
    }
}
```

- ⭕️Good: Simply create a new class without making any changes to the existing code / 新しいクラスを作るだけで既存のコードは一切変更しない

```code

    interface Animal {
        public function speak();
    }

    class Dog implements Animal {
        public function speak() { return "ワンワン"; }
    }

    class Cat implements Animal {
        public function speak() { return "ニャー"; }
    }

    class Bird implements Animal {
        public function speak() { return "ピーピー"; }
    }
```

- A short explanation of why the design is better / このデザインが優れている理由についての簡単な説明
    - Less prone to bugs / バグが出にくい
        - Ensuring that existing code doesn't break when new features are added.
        - 新機能を追加したときに既存のコードが壊れない
    - The test was easy / テストが楽
        - Since you only need to test the parts where new features have been added,
        - 新機能を追加したものだけテストをすればいいから

### LSP(Liskov Substitution Principle)

- A short definition in my own words
    - Even if the parent class is replaced with a child class, the program should continue to run without any issues.
    - 親クラスを子クラスに置き換えても、プログラムが問題なく動き続けるべき

- A simple PHP example
    - ❌Bad: The child is "rejecting" the parent's role / 子が親の機能を拒否している

```code
    class Bird {
        public function fly() {
            return "飛びます";
        }
    }

    class Penguin extends Bird {
        public function fly() {
            die("飛べません！");
        }
    }
```

- ⭕️Good: Classify correctly by "role" / 正しく役割で分ける

```code
    class Bird {
        public function eat() {
            return "食べます";
        }
    }

    // 飛べる鳥だけ「fly」を持たせる
    class Sparrow extends Bird {
        public function fly() {
            return "飛びます";
        }
    }

    class Penguin extends Bird {
        // eatだけができる
    }
```

- A short explanation of why the design is better / このデザインが優れている理由についての簡単な説明
    - Peace of mind for users / 使う人が安心
        - Because I can trust the pattern
        - 型を信じることができるから
    - Simple / シンプル
        - The code becomes cleaner
        - コードがきれいになる
