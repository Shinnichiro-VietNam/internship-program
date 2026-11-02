# Week 4 Notes

| Page             | URL                                              | What to copy                                                                                                                                                                                                                                                                                                                 |
| ---------------- | ------------------------------------------------ | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Home             | https://demo2.pavothemes.com/bookory/home-5/     | Dark top bar (tagline left, phone right), header row (logo, coral Categories button, pill search, account, cart badge), centered menu row, pale pink hero (label, headline, price, Shop now, cover blocks, dots), Popular Books header (title, line, View all) and book cards, pale pink sale strip, dark four-column footer |
| Product          | https://demo2.pavothemes.com/bookory/product/    | Not this week. Week 5                                                                                                                                                                                                                                                                                                        |
| Login / Register | https://demo2.pavothemes.com/bookory/my-account/ | Light gray title band, breadcrumb, label with a red asterisk, pill inputs, eye icon on the password, full-width coral button. Bookory puts Login and Register in two columns on one page. This app keeps `/login` and `/register` as two routes, one column each                                                             |

## Skipped on Login

Bookory shows “Remember me” and “Lost your password?”. Both stay out. There is no API for remembering a session beyond the token we already store, and no API for resetting a password.

## Colors

Taken from Bookory `style.css` `:root` and the Elementor kit (`post-4.css`). The week 4 class `accent` is Bookory’s `--primary`. Bookory’s own `--accent` is the heading black, so that value sits on `ink`.

| Class               | Bookory variable                             | Where it is used                           | Hex       |
| ------------------- | -------------------------------------------- | ------------------------------------------ | --------- |
| `accent`, `primary` | `--primary`                                  | Buttons, prices, active menu, cart badge   | `#F65D4E` |
| `primary-hover`     | `--primary_hover`                            | Button hover                               | `#f4402f` |
| `ink`               | `--accent`                                   | Headings                                   | `#000000` |
| `text`              | `--text`                                     | Body text                                  | `#444444` |
| `lighter`           | `--lighter`                                  | Breadcrumb, hints                          | `#999999` |
| `border`            | `--border`                                   | Input border                               | `#E6E6E6` |
| `background`        | `--background`                               | Page and input fill                        | `#ffffff` |
| `blush`             | hero slide background                        | Slide 2 is `#fcedec`. Slide 1 is `#fbf1e6` | `#fcedec` |
| `mist`              | my-account title band (`post-3100.css`)      | Title band. Search field is `#F6F6F6`      | `#F0F0F0` |
| `dark`              | header `post-125.css`, footer `post-329.css` | Top bar and footer                         | `#282828` |
