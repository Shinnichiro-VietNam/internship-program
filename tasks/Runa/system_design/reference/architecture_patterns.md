# Architecture Patterns (Short Guide)

Use this before external reading. Answers in `task_1/notes.md` should be in **your own words**.

---

## Layered (n-tier) architecture

An application is split into **layers**. Each layer has a role and usually talks mainly to the layer below.

**Classic three layers**

| Layer | Role | Typical concerns |
| ----- | ---- | ---------------- |
| **Presentation** | What the user or client sees | HTTP, JSON responses, HTML, routing |
| **Business / Application** | Rules and use cases | Validation, “create book”, “calculate total” |
| **Data** | Storage and retrieval | SQL, files, external APIs |

**Rules of thumb**

- Upper layers depend on lower layers, not the reverse.
- A change in the database should not force a rewrite of HTTP routing logic (if layers are respected).
- Your plain PHP Books API can be described in layers even without a framework.

**More than three tiers**

- “n-tier” just means multiple layers; sometimes people split “API”, “domain”, and “infrastructure” separately.
- The idea is the same: **separation of concerns**.

---

## MVC (Model–View–Controller)

Common in web backends (including Laravel).

| Part | Role |
| ---- | ---- |
| **Model** | Data and business rules (e.g. `Book`, database access) |
| **View** | Presentation (HTML, JSON shape shown to client) |
| **Controller** | Receives request, calls model, returns view/response |

**Flow (simplified)**

```text
Request → Controller → Model → (data) → Controller → Response / View
```

Laravel maps roughly to: `routes` → `Controller` → `Model` (Eloquent) → `view` or JSON.

---

## MVVM (Model–View–ViewModel)

Common in UI-heavy frontends (Vue, React with patterns, mobile apps).

| Part | Role |
| ---- | ---- |
| **Model** | Data |
| **View** | UI (what user sees) |
| **ViewModel** | State and commands for the view; binds view to model |

The View does not talk to the Model directly; the ViewModel sits in between.

---

## MVP (Model–View–Presenter)

Similar to MVC; the **Presenter** handles more UI logic than a thin controller.

| Part | Role |
| ---- | ---- |
| **Model** | Data |
| **View** | Passive UI (often notifies presenter of user actions) |
| **Presenter** | Updates view from model; reacts to user input |

Less common in modern Laravel backends; useful to know for comparison.

---

## Quick comparison

| Pattern | Best known for | Laravel relevance |
| ------- | -------------- | ----------------- |
| **Layered** | Any structured app | Folder structure, separation |
| **MVC** | Server-rendered web, APIs | **Primary** Laravel style |
| **MVVM** | SPA / rich UI | Frontend (e.g. Vue in Laravel stack) |
| **MVP** | Some desktop / legacy UI | Awareness only |

---

## Suggested extra reading (optional)

- [MDN: MVC](https://developer.mozilla.org/en-US/docs/Glossary/MVC) — short glossary entry
- Search: “MVC とは” or “三層アーキテクチャ とは” for Japanese explanations if helpful
