# OOP CONCEPTS SUMMARY

## What is Object-oriented programming / オブジェクト思考とは
- Definition / 定義
  - A development methodology that manages data and its associated methods as a unit called a "class".
  - データとそれに関連するメソッドを 「クラス」という単位でまとめて管理する開発手法

- History / 歴史
  - OOP was developed by Alan Kay in the 1960s and was conceived as a means to address the complexity of programming in particular.
  - OOPは1960年代後半にアラン・ケイ氏によって開発され、特にプログラミングの複雑さに対応する手段として考案された。


## OOP Advantages / OOPの利点
- Because it has a reusable function / 再利用性があるから
- Because it increases conservation / 保守性が高まるから
- Because it's also expandable / 拡張性もあるから


|原則名 | 概念 | 例（理由）
|-- | -- | --
|1. カプセル化 | 中身を隠して守る | **スマホの操作** ：内部の複雑な配線は隠し、ボタン操作だけに限定することで故障を防ぐ。
|2. 継承 | 便利な機能の使い回し | **スマホ → タブレット** ：スマホの基本画面を引き継ぎ大画面という特徴だけを付け足すことで効率がいい。
|3. 抽象化 | 必要な機能だけ見せる | **テレビのリモコン** ：映る仕組みを知らなくても、選局ボタンというボタンさえあれば誰でも操作できる。
|4. ポリモーフィズム | 同じ命令で違う動き | **課題を出してという指示** ：同じ言葉でも、相手次第で中身が変わる。
---


## Class & Object / クラスとオブジェクト
- 1. Class
  - Blue print. It has properties and methods. / 設計図　属性とメソッドを持つ
- 2. Object
  - A physical entity created from a blueprint. / 設計図から作られた実体
  - An instance of a class / クラスのインスタンス

## Four Pillars of OOP / OOPの４大原則
| Principle / 原則 | Mean / 意味 | Keywords / キーワード |
| :--- | :--- | :--- |
| **Encapsulation / カプセル化** | Protect internal data and prevent direct external access / 内部のデータを保護して、外部からは直接は接触させない。 | `public`, `private`, `protected` |
| **Inheritance / 継承** | Create a new class by reusing the function ality of an existing class./ 既存のクラスの機能を再利用して新しいクラスを作る。| `extends`|
| **Abstraction / 抽象化** | It hides the complex details and only shows the necessary operations. / 複雑な中身を隠し必要な操作だけを見せる。| `abstract` `interface`|
| **Polymorphism / ポリモーフィズム** | Even with the same command, the behavior changes depending on the object. / 同じ命令でもオブジェクトによって動きが変わる。 | `implements` |

## Visibility / アクセス修飾子の使い分け
- **Public**
  - Accessible from anywhere
  - どこからでもアクセス可能
- **Protected**
  - Accessible from the class itself and from classes that inherit it
  - そのクラス自身と、継承したクラスからあくせすが可能
- **Private**
  - It can only be accessed from within the class it self
  - そのクラス自身からしかアクセスできない

## Interface vs Abstract / インターフェース　ｖｓ　抽象クラス
| Feature / 特徴 | Interface / インターフェース | Abstract / 抽象クラス |
| :--- | :--- | :--- |
| Role / 役割 | Define what can be done. / なにができるかを定義 | Define the commonalities of what they are. /何であるかの共通項を定義 |
| Contents / 中身 | Method definition only. / メソッドの定義のみ | I can also write concrete code ./ 具体的なコードも書ける |
| Multiple use / 複数利用 | Multiple implementations are possible. / 複数実装が可能 | Only one can be inherited. / 1つしか継承できない |