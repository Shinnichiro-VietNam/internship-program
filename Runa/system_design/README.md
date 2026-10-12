# Software Architecture & Laravel Internals (Reading Module)

**Duration:** 2–3 days · **Type:** conceptual reading + short notes (no coding)

You will learn how applications are structured (layers, MVC), how systems are deployed at a high level (monolith vs microservices), and how Laravel organizes a request internally.

**AI tools:** Limited. Ask your trainer before using ChatGPT, Copilot, etc.

---

## Files

| File                                     | Purpose                                                 |
| ---------------------------------------- | ------------------------------------------------------- |
| `README.md`                              | This guide                                              |
| `tasks_1.md`                             | Reading plan and exercises 1–7 (conceptual)             |
| `tasks_2.md`                             | **Optional follow-up:** refactor Books API into n-layer |
| `reference/architecture_patterns.md`     | n-tier, MVC, MVVM, MVP (short guide)                    |
| `reference/monolith_vs_microservices.md` | Monolith vs microservices (short guide)                 |
| `reference/laravel_reading_guide.md`     | What to focus on in each Laravel doc                    |
| `reference/layered_api_guide.md`         | How to split `restful-task-1` into layers               |

Work in `task_1/` on **your intern branch**.

---

## Setup

1. Read `tasks_1.md` and the reference files.
2. Use `task_1/notes.md` (section headers are already there).
3. Write **short** answers in your own words. Japanese optional.
4. No code files required for tasks 1.

**Prerequisites:** Basic Programming, OOP, SOLID, RESTful API (Books API).

---

## Official Laravel reading (required)

Read in order (Laravel 13.x):

1. [Layered architecture reference\*1](https://qiita.com/kichion/items/aca19765cb16e7e65946)
2. [Layered architecture reference\*2](https://zenn.dev/tsutani2828/articles/layeredarchitecture)
3. [MVC reference](https://qiita.com/riku-shiru/items/2bed096e106e72e0b58a)
4. [Monolith reference](https://qiita.com/ryucciarati/items/b19cc876afd92d59019a)(highly recommended)
5. [Request Lifecycle](https://laravel.com/docs/13.x/lifecycle)
6. [Service Providers](https://laravel.com/docs/13.x/providers)
7. [Service Container](https://laravel.com/docs/13.x/container)
8. [Facades](https://laravel.com/docs/13.x/facades)

No need to install Laravel for this module.

---

## Optional: hands-on refactor (`tasks_2.md`)

After tasks 1 (especially Exercises 1–3), you may refactor your Books API from `feature/restful-task-1` into n-layer on branch `feature/restful-layered`.

Reference solution: trainer-only (local, not in git). Ask your trainer after you have tried.

---

## After this module

You should be able to:

- Explain layered architecture and MVC at a high level
- Describe monolith vs microservices and when each is reasonable
- Trace a Laravel HTTP request and name providers, container, and facades
- _(If you do tasks 2)_ Separate HTTP, business rules, and file storage in the Books API
