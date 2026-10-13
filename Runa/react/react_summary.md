# React summary for beginners

Read the concept first, then the example. A component is a function: it receives data and returns UI. When the data changes, React draws the screen again.

## 1. Concepts

### Props

Data a parent component passes to a child. The child only reads it. The child does not change it. To change it, the parent passes a new value down.

Props can be a string, a number, an object, or a function. The child calls that function to tell the parent something happened.

```tsx
function BookCard({ title, price }) {
  return (
    <h3>
      {title} — {price}đ
    </h3>
  );
}

<BookCard title='Clean Code' price={120000} />;
```

`BookCard` receives `title` and `price` from `BookList` and displays them.

### State

Data the component itself keeps, and can change.

```tsx
const [value, setValue] = useState(initialValue);
```

Calling `setValue` makes React draw the component again with the new value. Assigning `value = ...` directly does not change the screen.

When the new value depends on the old one, write:

```tsx
setCount((prev) => prev + 1);
```

Count button clicks:

```tsx
const [count, setCount] = useState(0);

<button onClick={() => setCount((prev) => prev + 1)}>Clicked {count} times</button>;
```

Book search box: each keystroke, `setAuthor` updates the text in the box.

### Props and state together

The parent keeps the state. The parent passes that state down to the child as props. When the child wants a change, it calls the function the parent passed down.

Data flows in one direction: parent → child.

```tsx
<SearchBox author={author} onChange={setAuthor} />
```

`BooksPage` keeps `author` with `useState`, then passes it to `SearchBox`. Inside `SearchBox`, `author` is a prop. Typing calls `onChange`, which runs `setAuthor` in the parent.

### useEffect

The place for work outside the UI: calling an API, setting a timer, listening to events.

The effect runs after the screen has been drawn.

```tsx
useEffect(() => {
  // setup: the work to do
  return () => {
    // cleanup: undo that work
  };
}, [dependencies]);
```

The array at the end decides when the effect runs again.

Load books once when the page opens:

```tsx
useEffect(() => {
  async function load() {
    const res = await fetch('/api/books');
    setBooks(await res.json());
  }
  void load();
}, []);
```

`[]` means it runs only when the page first appears.

#### The useEffect lifecycle

The lifecycle is the time a component stays on screen: it appears, the data changes some number of times, then it is removed.

##### Mount

The component has just been put on screen. For example, the books page just opened.

Setup runs after the screen is drawn. This is when you call the API the first time, or start a timer.

##### Update

The component is still there, but state or props changed, so React draws it again. A component can update many times.

The effect runs again only if a value in the dependency array changed. Before it runs again, the previous cleanup runs first.

##### Unmount

The component is removed from the screen. For example, the user goes to another page.

Cleanup runs to stop a timer, remove a listener, or cancel a request that is still in flight.

### useMemo

Remembers the result of a calculation. It calculates again only when the inputs change.

```tsx
const result = useMemo(() => calculate(data), [data]);
```

Use it when the calculation is expensive, for example filtering a very large list of books. A cheap calculation such as `books.length` does not need it.

Filter books by a maximum price:

```tsx
const affordable = useMemo(() => {
  return books.filter((book) => book.price <= maxPrice);
}, [books, maxPrice]);
```

If `books` and `maxPrice` have not changed, the list is not filtered again.

### useCallback

Remembers a function. It creates a new function only when a dependency changes.

Each time a component draws again, a function written inside it is a new function. `useCallback` keeps the same function if the data has not changed.

You need this when that function is in the dependency array of `useEffect`, so the effect does not run again without a real reason.

`useMemo` remembers a result. `useCallback` remembers a function.

The function that loads books is created again only when `author` changes:

```tsx
const fetchBooks = useCallback(async () => {
  const res = await fetch(`/api/books?author=${author}`);
  setBooks(await res.json());
}, [author]);

useEffect(() => {
  void fetchBooks();
}, [fetchBooks]);
```

## 2. Order of one mount or update

1. **Render.** React calls the component function to learn the new UI. It has not changed the DOM yet, and it has not called an API.
2. **Commit.** React updates the DOM only where it actually differs.
3. **Paint.** The browser draws the screen. The user sees the result before the effect runs.
4. **Effect.** `useEffect` runs. API calls, timers, and subscriptions belong in this step.

## 3. The dependency array

### `[]`

Setup runs on mount. Cleanup runs on unmount. Updates do not make this effect run again.

Open the page and load books once. Leave the page and the request is cancelled.

```tsx
useEffect(() => {
  const controller = new AbortController();
  void load(controller.signal);
  return () => controller.abort();
}, []);
```

### `[author]`

Setup runs on mount, and runs again every time `author` changes. Before each new run, the previous cleanup runs first. The last cleanup runs on unmount.

Change the keyword and the old request is cancelled, then books load with the new keyword.

```tsx
useEffect(() => {
  const controller = new AbortController();
  void load(author, controller.signal);
  return () => controller.abort();
}, [author]);
```

## 4. One update cycle

`author` changes from empty to `"Martin"`:

```text
render with author = "Martin"
  → commit: update the DOM
  → paint: the user sees the new screen
  → cleanup: cancel the request for the empty author
  → setup: fetch with author = "Martin"
```

Leaving the page runs only the last cleanup: the `"Martin"` request is cancelled if it is still in flight.
