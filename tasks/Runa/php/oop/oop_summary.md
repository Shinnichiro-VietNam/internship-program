# OOP CONCEPTS SUMMARY

## What is Object-oriented programming / オブジェクト思考とは
- Because it has a reusable function / 再利用性があるから
- Because it increases conservation / 保守性が高まるから
- Because it's also expandable / 拡張性もあるから

## Class & Object / クラスとオブジェクト
- 1. Class
  - Blue print. It has properties and methods. / 設計図　属性とメソッドを持つ
- 2. Object
  - A physical entity created from a blueprint. / 設計図から作られた実体

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
| Role / 役割 | Define what can be done. / なにができるかを定義 | Define the commonalities of what they are. /何であるかの共通項を定義 |
| Contents / 中身 | Method definition only. / メソッドの定義のみ | I can also write concrete code ./ 具体的なコードも書ける |
| Multiple use / 複数利用 | Multiple implementations are possible. / 複数実装が可能 | Only one can be inherited. / 1つしか継承できない |