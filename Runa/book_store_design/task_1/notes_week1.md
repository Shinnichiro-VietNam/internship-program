# Week 1 Notes

## Exercise 1: Selling-site pages

| Page                 | Path                                                                               | Purpose                                             | Actions                                                                 | Data              |
| -------------------- | ---------------------------------------------------------------------------------- | --------------------------------------------------- | ----------------------------------------------------------------------- | ----------------- |
| Home                 | `/`                                                                                | Top page. Suggest recommended products to customers | Search, open the cart, login and sign up, click banners, open a product | Books, Cart, User |
| Category             | `/all-category.html`                                                               | List of products by category                        | Filter, sort, change page size, open a product                          | Books             |
| One Product          | `/atlat-dia-li-viet-nam-theo-ct-gdpt-2018-chinh-sua-nam-2025-nxb-gd-viet-nam.html` | Details of one book                                 | Select variant, select quantity, add to cart, buy now                   | Books, Cart       |
| Search               | `/searchengine?q=Hello`                                                            | Results for a keyword                               | Search by keyword, filter, sort, open a product                         | Books             |
| Cart                 | `/checkout/cart/`                                                                  | Check the contents of the cart                      | Change the quantity, delete, proceed to order                           | Cart, Books       |
| Login / Register     | Popup (URL does not change)                                                        | Login and sign up                                   | Switch tabs, fill fields (not submitted)                                | User              |
| Footer account links | (footer on every page)                                                             | Links to address, account details, order history    | Click each link. Not logged in → sent to login                          | User, Order       |

### Home

- Header: logo, search bar, notification, cart icon, account, language, choose category
- Search: In Header (only icon and URL)
- Cart: In Header (only icon and URL)
- Account: In Header
- Banner: Click → goes to discount notification. The top advertising banner, main slide (arrow)
- Product blocks: FLASH SALE, Danh mục sản phẩm, Xu Hướng Mua Sắm, Best Sellers, TỦ SÁCH NỔI BẬT...

### Category

- Filters:
    - Nhóm sản phẩm: All Category、Sách Tiếng Việt、Foreign Books、Văn Phòng Phẩm、Đồ Chơi...
    - Giá: 0đ - 150,000đ、150,000đ - 300,000đ、300,000đ - 500,000đ、500,000đ - 700,000đ、700,000đ 以上
    - Genres: Comedy、Shounen、Drama、Adventure、Action...
    - Thương hiệu: Thiên Long、Deli、OEM...
    - Select price range and other options using the checkboxes.
- Sort:
    - This week best seller
    - This month best seller
    - This year best seller
    - This week's featured articles
    - This month highlight
    - This year highlight
    - discount
    - price of the products
    - Latest
- Card fields:
    - image of the product
    - title
    - trend badge
    - sale price
    - discount number
    - original price
    - star rating
    - stock: not shown on card

### One Product

- Price: sale price (red, 29.000 đ), original price (strikethrough), discount (-14%)
- Stock: no quantity number. Shows "107 bookstore(s) have stock"
- Quantity: `-` / `+` buttons, default 1
- Add to cart:
    - "Add to Cart" → Sản phẩm đã được thêm vào giỏ hàng.
    - "Buy now" → goes to `/checkout/cart/`
- Description: product code, supplier, author, publisher, publish year, weight

### Search

- Query: "Hello" → 242 results
- Path: `/searchengine?q=Hello`
- Result header: "Kết quả tìm kiếm: Hello (242 kết quả)" + category chips with counts
- Filters (Lọc theo, left sidebar), each option shows a count:
    - Danh mục chính (category)
    - Giá (price ranges) + custom min–max input + slider
    - Thương hiệu (brand)
- Card fields: image, title, sale price, original price (strikethrough), discount (%)
- Difference from category page:
    - filter options show result counts
    - custom price range input
    - sort by relevance
    - in-stock filter
    - no trend badge / star rating on cards
- If search: 'hhhhhhhaaaaaa' → Kết quả tìm kiếm:
  hhhhhhhaaaaaa (0 kết quả)

### Cart

- Path: `/checkout/cart/`
- Empty cart:
    - Message: Your shopping cart is empty.
    - Button: Buy Now
- With a book:
    - Line fields: image, title, price, quantity, line total, delete
    - Change quantity → up to the price
    - Delete → The registered items disappear.
- Summary: payment method, total price, find gift(promotion code)
- Checkout button without login → Even if you are logged in, your favorites will remain in your cart.

### Login / Register

- Tabs: "Đăng nhập" (login) / "Đăng ký" (register)
- Login fields:
    - Phone number or email
    - Password (show/hide button)
    - Links: forgot password
- Register fields:
    - Phone number
    - OTP code (button to send OTP)
    - Password
    - privacy policy button

### Footer account links

| Link                   | Path                        | Sends to login?   | Data  |
| ---------------------- | --------------------------- | ----------------- | ----- |
| Login / Create account | Popup (URL does not change) | (is login itself) | User  |
| Change address         | `/customer/address/index/`  | Yes               | User  |
| Account details        | `/customer/account/index/`  | Yes               | User  |
| Order history          | `/sales/order/history/`     | Yes               | Order |

- Not logged in → redirected to `/customer/account/login/referer/{base64 of original URL}/`. After login, it returns to the original page.

## Exercise 2: Feature list and admin screens

### Selling site

| Feature                       | Where you saw it      | Basic / Later / Out of scope | Why                                    |
| ----------------------------- | --------------------- | ---------------------------- | -------------------------------------- |
| Search books by keyword       | Header, Search page   | Basic                        | Needed to find a book                  |
| Book list by category         | Category page         | Basic                        | Needed to find a book                  |
| Book detail                   | One Product page      | Basic                        | Needed to check a book before buying   |
| Add to cart                   | One Product page      | Basic                        | Needed to put a book in a cart         |
| Change quantity / delete line | Cart page             | Basic                        | Needed to fix the cart before ordering |
| Place an order                | Cart page             | Basic                        | Main goal of the site                  |
| Order history / order detail  | Footer account links  | Basic                        | Needed to open the order again         |
| Login / register              | Popup                 | Basic                        | Login and register count as Basic      |
| Filter and sort               | Category, Search page | Later                        | Search works without it                |
| Sale price and discount       | Card, One Product     | Later                        | Discount                               |
| Promotion code                | Cart page             | Later                        | Discount                               |
| Star rating / reviews         | Category card         | Later                        | Review                                 |
| Banners, product blocks       | Home                  | Later                        | Admin-edited banners                   |
| Flash sale                    | Home                  | Later                        | Discount                               |
| Buy now                       | One Product page      | Later                        | Add to cart + cart page does the same  |
| Address book                  | Footer account links  | Later                        | Address can be typed in the order form |
| Notification, language        | Header                | Later                        | Not needed to buy a book               |
| OTP on register               | Register              | Out of scope                 | OTP                                    |
| Payment method                | Cart page             | Out of scope                 | Payment gateway                        |
| "N bookstores have stock"     | One Product page      | Out of scope                 | In-store pickup, store locator         |

### Admin site

| Screen       | What the admin does                                        | Selling page that fails if this is missing |
| ------------ | ---------------------------------------------------------- | ------------------------------------------ |
| Admin login  | Log in as admin                                            | All admin screens below                    |
| Book list    | See all books, open one to edit, delete                    | Category, Search                           |
| Book form    | Create and edit a book: title, author, price, stock, cover | Category, One Product                      |
| Order list   | See all orders                                             | Order history (orders are never handled)   |
| Order detail | See the lines of one order, change the status              | Order detail (status never changes)        |

### Gap against the current API

| Need                        | Covered today? | What is missing                                                                 |
| --------------------------- | -------------- | ------------------------------------------------------------------------------- |
| Book list and detail        | Yes            | `GET /api/books`, `GET /api/books/{book}` are public. Nothing missing for Basic |
| Login and register          | Yes            | `POST /api/register`, `POST /api/login`, `GET /api/user` exist. Nothing missing |
| Cover, category, sale price | No             | No `cover`, `category`, `sale_price` columns. No categories table               |
| Cart                        | No             | No cart table or cart API                                                       |
| Customer places an order    | No             | `POST /api/orders` is admin-only Customer cannot order or see own orders        |

## Exercise 4: Error JSON

### Files added or changed

| File                                      | Purpose                                                      |
| ----------------------------------------- | ------------------------------------------------------------ |
| `app/Http/Responses/ResponseData.php`     | Builds `{ status, message, data, errors }`                   |
| `app/Http/Responses/ApiErrorRenderer.php` | Turns exceptions into `ResponseData`                         |
| `app/Traits/HandleErrorException.php`     | 400 / 401 / 403 / 404 error bodies                           |
| `app/Traits/HandleResponse.php`           | `httpOk()`, `httpCreated()`, ..for controllers               |
| `app/Http/Controllers/Controller.php`     | Uses `HandleResponse` and `AuthorizesRequests`               |
| `bootstrap/app.php`                       | `render()` for `api/*`, guests get 401 instead of a redirect |
| `config/cors.php`                         | Allows `http://localhost:5173`                               |

### Differences from `laravel/task_1`

- `errors.fields` is an object: `{ "email": ["The email field is required."] }`. `laravel/task_1` used a list of `{ field, message }`.
- `HandleResponse` uses plain strings (`Created`, `No content`) instead of `trans('message.*')`. There is no `lang/` folder.

### Check

| Request                   | Result                          |
| ------------------------- | ------------------------------- |
| `GET /api/health`         | 200 `{"status":"OK"}`           |
| `GET /api/does-not-exist` | 404 `errors.code` = `NOT_FOUND` |

## Add: SQL query log

- `app/Http/Middleware/LogQueries.php`: enables the query log before the request, writes every SQL query to `storage/logs/laravel.log` after the response
- Registered in `bootstrap/app.php`

## Exercise 7: Checklist

Put this at the end of `notes_week1.md`.

| #   | Check                                                               | Done |
| --- | ------------------------------------------------------------------- | ---- |
| 1   | Home, list, product, search, cart, login/register opened on Fahasa  |  ✅️  |
| 2   | Each selling feature marked Basic, Later, or Out of scope           |  ✅️  |
| 3   | Admin list includes books, price, stock, and orders                 |  ✅️  |
| 4   | `GET /api/health` returns `{"status":"OK"}`                         |  ✅️  |
| 5   | `GET /api/does-not-exist` returns 404 and `errors.code` `NOT_FOUND` |  ✅️  |
| 6   | `/dev/ui` shows the four inputs and the health result               |  ✅️  |
| 7   | `.env` files are not committed                                      |  ✅️  |
