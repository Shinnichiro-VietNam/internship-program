# API

Laravel JSON API for the bookstore. Week 1 creates the app and the shared error JSON. Feature endpoints come in later weeks.

Read `README.md` for the database, `.env`, and how to run the server.

---

## Request path

```text
routes/api.php
    → Controller          HTTP only: authorize, call one class, return JSON
        → Form Request    validation on writes
        → Query           reads
        → Action          writes
    → Resource            JSON fields
    → ResponseData        status, message, data, errors
```

A controller method stays short. It does not query Eloquent, does not check field rules, and does not assemble the JSON array.

```php
public function store(StoreBookRequest $request, CreateBookAction $create): ResponseData
{
    $this->authorize('create', Book::class);

    $book = $create->handle($request->validated());

    return $this->httpCreated(new BookResource($book));
}
```

```php
public function index(ListBooksQuery $query): ResponseData
{
    $this->authorize('viewAny', Book::class);

    return $this->httpOk(BookResource::collection($query->paginate()));
}
```

---

## Layout

```text
app/
├── Actions/Book/CreateBookAction.php      # one write, method handle()
├── Actions/Book/UpdateBookAction.php
├── Actions/Book/DeleteBookAction.php
├── Queries/Book/ListBooksQuery.php        # filters + sort + pagination
├── Queries/Book/FindBookQuery.php
├── Queries/Book/Filter/FilterBooksByTitle.php
├── Queries/Book/Sort/SortBooksByTitle.php
├── Http/
│   ├── Controllers/BookController.php
│   ├── Requests/Book/StoreBookRequest.php
│   ├── Resources/Book/BookResource.php
│   └── Responses/
│       ├── ResponseData.php
│       └── ApiErrorRenderer.php
├── Models/Book.php
├── Enums/OrderStatus.php                  # fixed sets live here
└── Traits/HandleResponse.php
```

Group by the thing the class works on (`Book`, `Order`, `Auth`), then by verb. A second screen does not add a method onto an unrelated controller.

| Kind | Responsibility |
| ---- | -------------- |
| Controller | Authorize, take the validated input or the query, return `ResponseData` |
| Form Request | Rules and the 400 body. One request class per write |
| Action | One write. `handle()` is the only public method. Create, update, delete, place order |
| Query | One read. List or find. The list query calls filter and sort classes |
| Filter / Sort | One `where` or one `orderBy`. The list query does not inline those clauses |
| Resource | The JSON fields for that model. `book_id` in the database, `id` in JSON |
| Enum | A closed set of values, such as order status |

There is no `Service` class and no `Repository`. A write that touches more than one table runs inside `DB::transaction()` in the Action.

---

## JSON

Same envelope as `../laravel/task_1/`. Copy `ResponseData`, `ApiErrorRenderer`, and the `api/*` renders in `bootstrap/app.php`.

Success:

```json
{ "status": 200, "message": "OK", "data": {} }
```

Error:

```json
{
  "status": 400,
  "message": "The given data was invalid.",
  "errors": {
    "code": "BAD_REQUEST",
    "fields": { "title": ["The title field is required."] }
  }
}
```

`BAD_REQUEST` 400, `UNAUTHORIZED` 401, `FORBIDDEN` 403, `NOT_FOUND` 404.

`GET /api/health` stays outside the envelope: `{ "status": "OK" }`.

---

## Rules

- Routes in `routes/api.php` only, prefix `/api`
- New endpoint: route, controller method, Action or Query, Resource. Follow the book example above
- Price on an order line is copied from `books.price` inside the Action. The request body does not set it
- Do not commit `.env`
