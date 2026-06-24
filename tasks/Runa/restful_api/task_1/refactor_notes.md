## Exercise 10 — Quick plan

1. What was wrong with having everything in one index.php?

- It violates the Separation of Concerns principle. Mixing HTTP parsing, validation rules, and file operations in one single file makes the code highly tangled, very difficult to test individually, and easily broken by minor changes.

1. すべてを1つのindex.phpファイルにまとめることの何が問題だったのでしょうか？

- 関心の分離の原則に違反しています。HTTP解析、検証ルール、ファイル操作を1つのファイルに混在させると、コードが非常に複雑になり、個別にテストするのが非常に困難になり、わずかな変更でも簡単に壊れてしまう。

2. Architecture Diagram:
   [Controller] (Presentation Layer)
   │
   ▼ (Calls)
   [Service] (Business Logic Layer)
   │
   ▼ (Calls / Depends on Interface)
   [Repository] (Data Access Layer)

3. Classes to create:

- Http/Response.php
- Http/Router.php
- Controllers/HealthController.php
- Controllers/BookController.php
- Services/BookService.php
- Repositories/BookRepositoryInterface.php
- Repositories/JsonBookRepository.php
