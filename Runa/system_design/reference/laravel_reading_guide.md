# Laravel Reading Guide

Read in this order. Use this sheet to know **what to look for**; the official docs have full detail.

---

## 1. Request Lifecycle

**URL:** https://laravel.com/docs/13.x/lifecycle

**Focus on**

- Entry: `public/index.php` → `bootstrap/app.php`
- HTTP kernel: bootstrappers, middleware stack
- Service providers loaded before routing
- Router dispatches to controller / route
- Response travels back through middleware → sent to browser

**Ask yourself**

- Where does “my code” (controller) run in this pipeline?
- What runs **before** my controller? (middleware, bootstrap)

---

## 2. Service Providers

**URL:** https://laravel.com/docs/13.x/providers

**Focus on**

- Providers bootstrap the app (database, routes, validation, etc.)
- `register()` — bind things into the **service container** only
- `boot()` — runs after all providers registered; routes, events, view composers, etc.
- Listed in `bootstrap/providers.php`
- `AppServiceProvider` is the usual place for app-specific setup

**Ask yourself**

- Why must `register()` not depend on services from another provider’s `boot()`?
- What is the difference between `register` and `boot`?

---

## 3. Service Container

**URL:** https://laravel.com/docs/13.x/container

**Focus on**

- Container resolves class dependencies (dependency injection)
- Constructor type-hints are auto-filled
- Bindings: `bind`, `singleton`, interface → implementation
- Connect to **DIP** from SOLID: depend on abstractions, container wires implementations

**Ask yourself**

- How is this different from `new MyClass()` everywhere?
- How does this relate to Dependency Inversion Principle?

---

## 4. Facades

**URL:** https://laravel.com/docs/13.x/facades

**Focus on**

- Facades are a **static-looking API** to services in the container
- They are not “real” static classes; they proxy to container instances
- Facades vs constructor injection (testability, explicit dependencies)
- Examples: `Route`, `Cache`, `DB` facades

**Ask yourself**

- Why might you prefer injection in a controller but see `Cache::get()` in docs?
- How do facades still use the container under the hood?

---

## Mapping to your prior work

| You already know | Laravel piece |
| ---------------- | ------------- |
| SOLID / DIP | Service container, bindings |
| Books API `index.php` routing | Routes + middleware + controller |
| Separating repository from handler | Layers + MVC + container injection |
| REST “layered system” constraint | Middleware stack, kernel |

---

## You do not need (for this module)

- Writing bindings or custom providers in code
- Memorizing every facade class
- Octane, queues, or deployment details
