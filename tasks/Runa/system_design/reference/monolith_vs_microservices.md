# Monolith vs Microservices (Short Guide)

This module stays **conceptual**. You are not building or deploying either style.

---

## Monolith

**One application** contains most features: routing, business logic, data access, often background jobs — deployed as one unit.

**Examples at intern level**

- Your plain PHP Books API in a single project folder
- A Laravel app with books, orders, and admin in one codebase

**Pros**

- Simple to develop, test, and deploy early in a project
- Easier debugging (one process, one repo)
- No network calls between “internal” features

**Cons**

- Codebase can grow large and harder to navigate
- One bug or deploy can affect the whole system
- Scaling often means scaling the entire app, not just one feature

---

## Microservices

The system is split into **many small services**, each owning a bounded area (e.g. “catalog service”, “payment service”). They communicate over the network (usually HTTP or messages).

**Pros**

- Teams can own services independently
- Scale or deploy one service without touching others
- Technology can differ per service (in theory)

**Cons**

- Operational complexity (many deploys, monitoring, failures)
- Network latency and partial failures
- Harder local development and testing
- **Not** a default choice for small apps or early startups

---

## When to think monolith first

- Small team, new product, unclear boundaries
- Same as: “start simple, split later **if** you have a real reason”

## When microservices might make sense (high level)

- Large organization, many teams on the same product
- Clear boundaries, different scaling needs per feature
- Mature DevOps and observability

For internship level: **know the words and trade-offs**. Deep distributed-system design is a later topic.

---

## Relation to layered architecture

- **Layers** = how code is organized **inside** one application.
- **Monolith vs microservices** = how **applications** are split and deployed **across** a system.

You can have a layered monolith (very common). Microservices often have layers **inside** each service too.

---

## Suggested extra reading (optional)

- [Microservices (Martin Fowler)](https://martinfowler.com/articles/microservices.html) — long; skim intro and “MonolithFirst” if short on time
- Search: “モノリシック マイクロサービス 違い” for Japanese summaries
