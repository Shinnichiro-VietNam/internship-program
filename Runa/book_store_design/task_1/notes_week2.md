# Week2 Note

---

# Exercise 3: Login page

## 1 what Yup check

- Email is not empty.
- Check the Email format.
- Password is not empty.
- Check Password must be 8 characters or longer

## 2 what you still have to read from a 400 body

- If the server rejects the request after it has passed through Yup, read the errors.field and output it to Input.

## Test checklist (`notes_week2.md`)

| #   | Check                                    | Expect                             | Done |
| --- | ---------------------------------------- | ---------------------------------- | ---- |
| 1   | POST `/api/register` with a new email    | 201 and `data.token`               | ✅️   |
| 2   | POST `/api/register` with the same email | 400, field error on email          | ✅️   |
| 3   | POST `/api/login` with a wrong password  | 401                                | ✅️   |
| 4   | Submit `/login` with an empty email      | Yup error, no request              | ✅️   |
| 5   | Open `/account` while logged out         | redirect to `/login`               | ✅️   |
| 6   | Login as `reader@example.com`            | land on `/`, header shows the name | ✅️   |
| 7   | Logout                                   | token gone, header shows Login     | ✅️   |
| 8   | `/dev/ui`                                | week 1 inputs still render         | ✅️   |
