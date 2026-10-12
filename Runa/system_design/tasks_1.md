# Software Architecture Tasks 1 (2–3 Days)

| Day | Topic | Exercises |
| --- | ----- | --------- |
| 1 | Layered architecture + MVC | 1–3 |
| 2 | Monolith vs microservices | 4 |
| 3 | Laravel internals | 5–7 |

Read `README.md` and all files in `reference/` before you start.

Create `task_1/notes.md` with the section headings below. **No PHP or SQL files** — reading and short notes only.

**Tip:** Short answers in your own words are enough. Japanese is optional unless you want the practice.

---

## Concepts (quick reference)

**Layered (n-tier)** — Presentation, business, data — each layer has one main job.

**MVC** — Model (data), View (output), Controller (coordinates). Main pattern for Laravel.

**Monolith** — One app, one deploy. **Microservices** — many small services over the network.

**Laravel** — Request → kernel → providers → middleware → router → controller → response. Container handles dependency injection (DIP). Facades are shortcuts to container services.

---

### Exercise 1: Layered architecture

Section `## Exercise 1 — Layered architecture` in `notes.md`:

1. What is layered architecture? (2–3 sentences)
2. Name the three classic layers and what each does (short bullet list).
3. Optional: one simple diagram (boxes + arrows).

---

### Exercise 2: MVC (and MVVM / MVP)

Section `## Exercise 2 — MVC`:

Read `reference/architecture_patterns.md`.

1. Define **Model**, **View**, **Controller** in one line each.
2. Which pattern matters most for Laravel backend? Why? (one sentence)
3. Optional: one line each on MVVM and MVP — only if you read about them.

---

### Exercise 3: Your Books API

Section `## Exercise 3 — Books API`:

Think about `restful_api/task_1/` (plain PHP, not Laravel).

1. Give **one example** from your API for each layer: presentation, business, data.
2. Is it layered yet, or mostly one file? One sentence.

**Optional next step:** `tasks_2.md` — refactor into real layers.

---

### Exercise 4: Monolith vs microservices

Section `## Exercise 4 — Monolith vs microservices`:

Read `reference/monolith_vs_microservices.md`.

1. Define monolith and microservices (one sentence each).
2. One pro and one con of each.
3. Is your Books API a monolith? Yes/no + why.
4. Bonus (one sentence): how is **layered architecture** different from **monolith vs microservices**?

---

### Exercise 5: Laravel request lifecycle

Section `## Exercise 5 — Request lifecycle`:

Read [Request Lifecycle](https://laravel.com/docs/13.x/lifecycle) and `reference/laravel_reading_guide.md`.

1. List **5 main steps** from request to response (your own short labels).
2. Where do middleware and routing fit in?
3. Optional: 2–3 bullets comparing Laravel vs your plain PHP `index.php`.

---

### Exercise 6: Providers and container

Section `## Exercise 6 — Providers and container`:

Read [Service Providers](https://laravel.com/docs/13.x/providers) and [Service Container](https://laravel.com/docs/13.x/container).

1. What does a service provider do? (one sentence)
2. What is the difference between `register()` and `boot()`? (one sentence each)
3. What is the service container / dependency injection? (2–3 sentences)
4. How does this connect to **DIP** from SOLID? (one sentence is enough)

---

### Exercise 7: Facades + wrap-up

Section `## Exercise 7 — Facades` and `## Final reflection`:

Read [Facades](https://laravel.com/docs/13.x/facades).

**Facades**

1. What is a Laravel facade? (one sentence)
2. Facade vs constructor injection — one advantage of each.

**Final reflection** (3–5 lines total)

1. Name **two things** Laravel would handle for you that your Books API did manually.
2. One topic you want to ask your trainer about.

---

## Submission checklist

| Item | Done? |
| ---- | ----- |
| `task_1/notes.md` has sections for Exercises 1–7 + Final reflection |
| Answers in your own words |
| Laravel docs read: lifecycle, providers, container, facades |

**Trainer review:** understanding matters more than length.
