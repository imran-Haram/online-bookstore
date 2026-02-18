# Online Bookstore — Data Flow Diagrams (DFD)

A **Data Flow Diagram (DFD)** is a graphical representation of the flow of data through a system. It shows how data enters the system, how it is processed, where it is stored, and how it exits. DFDs are a fundamental tool in structured systems analysis and are used during the **requirements analysis and system design** phases of the Software Development Life Cycle (SDLC).

---

## DFD Notation

| Symbol | Meaning | Representation |
|--------|---------|----------------|
| **Rectangle** | External Entity (source or destination of data outside the system) | `[Entity]` |
| **Rounded Rectangle / Circle** | Process (transforms data) | `(Process)` |
| **Open Rectangle** | Data Store (where data is persisted) | `[= Store =]` |
| **Arrow (→)** | Data Flow (movement of data between components) | `───→` |

---

## Level 0 — Context Diagram

The Context Diagram shows the **entire system as a single process** and identifies all external entities that interact with it. It defines the system boundary — what is inside and what is outside.

### External Entities

| Entity | Description |
|--------|-------------|
| **Customer** | Registers, logs in, browses books, manages a cart, places orders, views order history, updates profile, resets password. |
| **Administrator** | Logs in with admin privileges, manages books (CRUD), manages users (view/delete), manages orders (view/update status), views dashboard statistics. |

### Context Diagram

```
 ┌──────────┐                                                   ┌──────────────┐
 │          │── Registration Data / Login Credentials ────────→│              │
 │          │← Authentication Result ──────────────────────────│              │
 │          │── Password Reset Request ───────────────────────→│              │
 │          │← Reset Confirmation ────────────────────────────│              │
 │          │── Profile Update Data ───────────────────────────→│              │
 │          │← Updated Profile ──────────────────────────────│              │
 │          │── Search / Filter Criteria ──────────────────────→│    ONLINE    │
 │ Customer │← Book Listings & Details ────────────────────────│  BOOKSTORE   │
 │          │── Add to Cart Request ───────────────────────────→│   SYSTEM     │
 │          │← Cart Contents & Totals ─────────────────────────│              │
 │          │── Checkout / Place Order ────────────────────────→│              │
 │          │← Order Confirmation & History ───────────────────│              │
 └──────────┘                                                   │              │
                                                                │              │
 ┌──────────────┐                                               │              │
 │              │── Login Credentials ──────────────────────────→│              │
 │              │← Authentication + Admin Access ───────────────│              │
 │              │── Book Data (Add/Edit/Delete) ─────────────────→│              │
 │              │← CRUD Confirmation ──────────────────────────│              │
 │ Administrator│── View/Delete Users ──────────────────────────→│              │
 │              │← User List & Details ────────────────────────│              │
 │              │── View Orders / Update Status ────────────────→│              │
 │              │← Order Data ────────────────────────────────│              │
 │              │── Dashboard Request ──────────────────────────→│              │
 │              │← Dashboard Statistics ────────────────────────│              │
 └──────────────┘                                               └──────────────┘
```

### Data Flows Summary (Level 0)

| # | From | To | Data Flow |
|---|------|----|----------|
| 1 | Customer | System | Registration data (name, email, password) |
| 2 | System | Customer | Registration confirmation / errors |
| 3 | Customer | System | Login credentials (email, password) |
| 4 | System | Customer | Authentication result (success/failure) |
| 5 | Customer | System | Password reset request (email) |
| 6 | System | Customer | Reset confirmation / link |
| 7 | Customer | System | Profile update data (name, email, password) |
| 8 | System | Customer | Updated profile confirmation |
| 9 | Customer | System | Search query, filter criteria (category, price range, stock) |
| 10 | System | Customer | Filtered book listings, book detail pages |
| 11 | Customer | System | Add-to-cart request (book ID, quantity) |
| 12 | System | Customer | Cart contents with item details and totals |
| 13 | Customer | System | Checkout / place order request |
| 14 | System | Customer | Order confirmation & order history |
| 15 | Admin | System | Login credentials (email, password) |
| 16 | System | Admin | Authentication + admin access |
| 17 | Admin | System | Book data (title, author, category, price, stock, image URL, description) |
| 18 | System | Admin | Book management confirmation (created/updated/deleted) |
| 19 | Admin | System | View users request, delete user request |
| 20 | System | Admin | User list, user detail with order history |
| 21 | Admin | System | View orders / update order status |
| 22 | System | Admin | Order data |
| 23 | Admin | System | Dashboard request |
| 24 | System | Admin | Dashboard statistics (total users, books, orders, revenue) |

---

## Level 1 — System Overview DFD

Level 1 breaks the single "Online Bookstore System" process into its **major sub-processes** and shows the data stores (database tables) that each process reads from and writes to.

### Processes

| # | Process | Description |
|---|---------|-------------|
| P1 | User Authentication & Registration | Handles registration, login, logout, password reset, email verification |
| P2 | Profile Management | Handles profile viewing, updating, and account deletion |
| P3 | Book Catalog & Search | Handles book listing, detail view, search, and filtering |
| P4 | Shopping Cart Management | Handles adding, updating, removing cart items and displaying totals |
| P5 | Order Processing | Handles checkout, order creation, and order history viewing |
| P6 | Admin Book Management | Handles admin CRUD operations on books |
| P7 | Admin User Management | Handles admin viewing and deleting user accounts |
| P8 | Admin Order Management | Handles admin viewing all orders and updating statuses |
| P9 | Admin Dashboard | Aggregates and displays system-wide statistics |

### Data Stores

| ID | Data Store | Database Table(s) |
|----|------------|--------------------|
| D1 | Users Store | `users` |
| D2 | Books Store | `books` |
| D3 | Cart Store | `cart_items` |
| D4 | Orders Store | `orders`, `order_items` |
| D5 | Password Reset Tokens | `password_reset_tokens` |
| D6 | Sessions Store | `sessions` |

### Level 1 Diagram

```
                    ┌──────────┐
                    │ Customer │
                    └────┬─────┘
                         │
          Registration Data, Login Credentials
                         │
                         ▼
                ┌────────────────┐        ┌─────────────┐
                │      P1        │───────→│ D5 Password │
                │ Authentication │←───────│ Reset Tokens│
                │ & Registration │        └─────────────┘
                └───┬────┬───────┘
                    │    │                ┌─────────────┐
      Auth Result   │    └───────────────→│ D1 Users    │
                    │     Store User      │   Store     │
                    │                      └──────┬──────┘
                    │                             │
   ┌────────────┐←──┘                             │
   │  Customer  │                                 │
   └──┬──┬──┬───┘                                │
      │  │  │                                    │
      │  │  │  Profile Data          ┌───────────┴──────────┐
      │  │  └────────────────────────→      P2              │
      │  │     ┌─────────────────────│ Profile Management   │
      │  │     │  Updated Profile    └──────────────────────┘
      │  │     │
      │  │  Search/Filter Criteria   ┌──────────────────────┐
      │  └─────────────────────────→│        P3             │
      │        │                    │ Book Catalog & Search │←─────┐
      │        │ Book Listings      └───────────────────────┘      │
      │        │                                                   │
      │        │                    ┌──────────────┐               │
      │        │                    │ D2 Books     │───────────────┘
      │        │                    │   Store      │    Read Books
      │        │                    └──────┬───────┘
      │        │                           │
      │  Add/Update/Remove Cart    ┌───────┴────────────────┐
      └────────────────────────────→       P4               │    ┌──────────┐
               │                   │ Shopping Cart Mgmt     │───→│ D3 Cart  │
               │ Cart Contents     │                        │←───│  Store   │
               │ & Totals          └───────────────────────┘    └──────────┘
               │
               │  Checkout Request  ┌──────────────────────┐    ┌──────────┐
               └───────────────────→│       P5              │───→│ D4 Orders│
                  Order Confirmation│ Order Processing      │←───│  Store   │
               ┌───────────────────│                        │    └──────────┘
               │                    └──────────────────────┘
               ▼

   ┌──────────┐
   │  Admin   │
   └──┬──┬──┬─┘
      │  │  │
      │  │  │  Book CRUD Data       ┌──────────────────────┐    ┌──────────┐
      │  │  └──────────────────────→│       P6              │───→│ D2 Books │
      │  │     │                    │ Admin Book Management │←───│  Store   │
      │  │     │ Confirmation       └──────────────────────┘    └──────────┘
      │  │     │
      │  │  View/Delete Users       ┌──────────────────────┐    ┌──────────┐
      │  └─────────────────────────→│       P7              │───→│ D1 Users │
      │        │                    │ Admin User Management │←───│  Store   │
      │        │ User List/Details  └──────────────────────┘    └──────────┘
      │        │
      │  View/Update Orders         ┌──────────────────────┐    ┌──────────┐
      └────────────────────────────→│       P8              │───→│ D4 Orders│
               │                    │ Admin Order Management│←───│  Store   │
               │ Order Data         └──────────────────────┘    └──────────┘
               │
               │  Dashboard Request  ┌──────────────────────┐
               └────────────────────→│       P9              │──→ Reads D1,
                  Statistics         │  Admin Dashboard      │     D2, D4
               ┌────────────────────│                        │
               │                     └──────────────────────┘
               ▼
```

### Level 1 Data Flow Table

| # | Source | Destination | Data Flow Description |
|---|--------|-------------|----------------------|
| 1 | Customer | P1 | Registration data (name, email, password) |
| 2 | P1 | D1 | New user record |
| 3 | P1 | D5 | Password reset token |
| 4 | P1 | D6 | New session record |
| 5 | P1 | Customer | Authentication result, reset link |
| 6 | Customer | P2 | Profile update (name, email, new password) |
| 7 | P2 | D1 | Updated user record |
| 8 | P2 | Customer | Updated profile confirmation |
| 9 | Customer | P3 | Search query, category, price range, in-stock flag |
| 10 | D2 | P3 | Book records matching criteria |
| 11 | P3 | Customer | Paginated book list, book detail |
| 12 | Customer | P4 | Add/update/remove cart item (book ID, quantity) |
| 13 | P4 | D3 | Create/update/delete cart item record |
| 14 | D3 | P4 | Current cart items for user |
| 15 | D2 | P4 | Book details (title, price) for cart display |
| 16 | P4 | Customer | Cart contents with subtotals and grand total |
| 17 | Customer | P5 | Checkout / place order request |
| 18 | D3 | P5 | Cart items to convert to order items |
| 19 | P5 | D4 | New order + order item records |
| 20 | P5 | D3 | Delete cart items (clear cart after order) |
| 21 | P5 | Customer | Order confirmation, order history, order detail |
| 22 | D4 | P5 | Order records for current user |
| 23 | Admin | P6 | Book data (title, author, category, price, stock, image, description) |
| 24 | P6 | D2 | Create/update/delete book record |
| 25 | P6 | Admin | CRUD confirmation |
| 26 | Admin | P7 | View users / delete user request |
| 27 | D1 | P7 | User records with order counts |
| 28 | P7 | D1 | Delete user record |
| 29 | P7 | Admin | User list, user detail with orders |
| 30 | Admin | P8 | View orders / update order status |
| 31 | D4 | P8 | All order records with items |
| 32 | P8 | D4 | Updated order status |
| 33 | P8 | Admin | Order list, order detail |
| 34 | Admin | P9 | Dashboard view request |
| 35 | D1, D2, D4 | P9 | Aggregated counts and recent records |
| 36 | P9 | Admin | Statistics (total users, books, orders, revenue), recent orders, recent users |

---

## Level 2 — Detailed Process Decomposition

Level 2 expands each Level 1 process into more granular sub-processes. Below are the detailed DFDs for the most important processes.

### Level 2.1 — P1: User Authentication & Registration

```
┌──────────┐
│ Customer │
└──┬──┬──┬─┘
   │  │  │
   │  │  │  1.1 Registration Data (name, email, password)
   │  │  │
   │  │  ▼
   │  │  ┌─────────────────────────┐
   │  │  │      P1.1               │         ┌──────────┐
   │  │  │  Validate & Register    │────────→│ D1 Users │
   │  │  │  New User               │         │  Store   │
   │  │  └─────────┬───────────────┘         └──────────┘
   │  │            │
   │  │            │ Registration Confirmation / Validation Errors
   │  │            ▼
   │  │
   │  │  1.2 Login Credentials (email, password)
   │  │
   │  ▼
   │  ┌─────────────────────────┐
   │  │      P1.2               │         ┌──────────┐
   │  │  Authenticate User      │←───────│ D1 Users │ (verify credentials)
   │  │                         │         │  Store   │
   │  │                         │────────→│          │
   │  └─────────┬───────────────┘         └──────────┘
   │            │                         ┌──────────┐
   │            │ Create Session ────────→│D6 Session│
   │            │                         │  Store   │
   │            │ Auth Result             └──────────┘
   │            ▼
   │
   │  1.3 Forgot Password (email)
   │
   ▼
   ┌─────────────────────────┐
   │      P1.3               │         ┌──────────────┐
   │  Generate Password      │────────→│ D5 Password  │
   │  Reset Token            │         │ Reset Tokens │
   └─────────┬───────────────┘         └──────────────┘
             │
             │ Reset Link (via email)
             ▼
   ┌─────────────────────────┐
   │      P1.4               │         ┌──────────────┐
   │  Reset Password         │←───────│ D5 Password  │ (validate token)
   │                         │         │ Reset Tokens │
   │                         │────────→└──────────────┘
   └─────────┬───────────────┘
             │                         ┌──────────┐
             │ Update Password ───────→│ D1 Users │
             │                         │  Store   │
             │ Confirmation            └──────────┘
             ▼
```

**Sub-Process Descriptions:**

| Process | Name | Input | Output | Description |
|---------|------|-------|--------|-------------|
| P1.1 | Validate & Register | name, email, password | User record, confirmation | Validates uniqueness of email, hashes password with bcrypt, creates user in DB |
| P1.2 | Authenticate User | email, password | Session, auth result | Verifies credentials against DB, creates session, returns auth token |
| P1.3 | Generate Reset Token | email | Reset token, email link | Generates secure token, stores in `password_reset_tokens`, sends email |
| P1.4 | Reset Password | token, new password | Updated password | Validates token, hashes new password, updates user record, deletes token |

---

### Level 2.3 — P3: Book Catalog & Search

```
┌──────────┐
│ Customer │
└──┬──┬────┘
   │  │
   │  │  3.1 Browse Request (page number)
   │  ▼
   │  ┌─────────────────────────┐         ┌──────────┐
   │  │      P3.1               │←───────│ D2 Books │
   │  │  Retrieve Paginated     │         │  Store   │
   │  │  Book Listing           │         └──────────┘
   │  └─────────┬───────────────┘
   │            │ Paginated Book List (10 per page)
   │            ▼
   │
   │  3.2 Search Query (title/author/category keyword)
   │
   ▼
   ┌─────────────────────────┐         ┌──────────┐
   │      P3.2               │←───────│ D2 Books │
   │  Search Books by        │         │  Store   │
   │  Title / Author / Cat.  │         └──────────┘
   └─────────┬───────────────┘
             │ Matching Books
             ▼

   3.3 Filter Criteria (category, min_price, max_price, in_stock)
   │
   ▼
   ┌─────────────────────────┐         ┌──────────┐
   │      P3.3               │←───────│ D2 Books │
   │  Apply Filters          │         │  Store   │
   │  (category, price,      │         └──────────┘
   │   availability)         │
   └─────────┬───────────────┘
             │ Filtered & Paginated Results
             ▼

   3.4 Book ID (view detail)
   │
   ▼
   ┌─────────────────────────┐         ┌──────────┐
   │      P3.4               │←───────│ D2 Books │
   │  Retrieve Book Detail   │         │  Store   │
   │  (full information)     │         └──────────┘
   └─────────┬───────────────┘
             │ Book Detail (title, author, category, price,
             │             stock, description, image)
             ▼
        ┌──────────┐
        │ Customer │
        └──────────┘
```

**Sub-Process Descriptions:**

| Process | Name | Input | Output | Description |
|---------|------|-------|--------|-------------|
| P3.1 | Retrieve Paginated Listing | Page number | 10 books per page | Fetches books ordered by latest, paginated |
| P3.2 | Search Books | Search keyword | Matching books | Performs LIKE search on title, author, and category columns |
| P3.3 | Apply Filters | Category, min/max price, in_stock | Filtered results | Chains WHERE clauses for category, price range, stock > 0 |
| P3.4 | Retrieve Book Detail | Book ID | Full book record | Returns all fields for a single book |

---

### Level 2.4 — P4: Shopping Cart Management

```
┌──────────┐
│ Customer │
└──┬──┬──┬─┘
   │  │  │
   │  │  │  4.1 Add to Cart (book_id)
   │  │  ▼
   │  │  ┌─────────────────────────┐      ┌──────────┐   ┌──────────┐
   │  │  │      P4.1               │─────→│ D3 Cart  │   │ D2 Books │
   │  │  │  Add Item to Cart       │←────│  Store   │   │  Store   │
   │  │  │  (or increment qty)     │←─────────────────────│          │
   │  │  └─────────┬───────────────┘      └──────────┘   └──────────┘
   │  │            │ Confirmation                         (get price)
   │  │            ▼
   │  │
   │  │  4.2 Update Quantity (cart_item_id, new_quantity)
   │  ▼
   │  ┌─────────────────────────┐         ┌──────────┐
   │  │      P4.2               │────────→│ D3 Cart  │
   │  │  Update Cart Item Qty   │         │  Store   │
   │  └─────────┬───────────────┘         └──────────┘
   │            │ Updated Cart
   │            ▼
   │
   │  4.3 Remove Item (cart_item_id)
   ▼
   ┌─────────────────────────┐         ┌──────────┐
   │      P4.3               │────────→│ D3 Cart  │
   │  Remove Item from Cart  │         │  Store   │ (delete record)
   └─────────┬───────────────┘         └──────────┘
             │ Updated Cart
             ▼

   4.4 View Cart
   │
   ▼
   ┌─────────────────────────┐         ┌──────────┐   ┌──────────┐
   │      P4.4               │←───────│ D3 Cart  │   │ D2 Books │
   │  Calculate Subtotals    │←─────────────────────│  Store   │
   │  & Grand Total          │         └──────────┘   └──────────┘
   └─────────┬───────────────┘         (get items)    (get titles,
             │                                         prices)
             │ Cart Items + Subtotals + Grand Total
             ▼
        ┌──────────┐
        │ Customer │
        └──────────┘
```

**Sub-Process Descriptions:**

| Process | Name | Input | Output | Description |
|---------|------|-------|--------|-------------|
| P4.1 | Add Item to Cart | book_id, user_id | Cart item record | Checks if item exists → increments qty; otherwise creates new cart_item with book price |
| P4.2 | Update Cart Item Qty | cart_item_id, quantity | Updated record | Validates ownership (user_id), updates quantity |
| P4.3 | Remove Item from Cart | cart_item_id | Deleted record | Validates ownership, deletes cart_item record |
| P4.4 | Calculate Totals | user_id | Items with subtotals, grand total | Loads cart items with book relations, calculates price × quantity per item, sums all |

---

### Level 2.5 — P5: Order Processing

```
┌──────────┐
│ Customer │
└──┬──┬──┬─┘
   │  │  │
   │  │  │  5.1 View Checkout (summary request)
   │  │  ▼
   │  │  ┌─────────────────────────┐      ┌──────────┐   ┌──────────┐
   │  │  │      P5.1               │←────│ D3 Cart  │   │ D2 Books │
   │  │  │  Generate Checkout      │←─────────────────────│  Store   │
   │  │  │  Summary                │      └──────────┘   └──────────┘
   │  │  └─────────┬───────────────┘
   │  │            │ Cart Items + Total
   │  │            ▼
   │  │
   │  │  5.2 Place Order (confirm checkout)
   │  ▼
   │  ┌─────────────────────────┐      ┌──────────┐
   │  │      P5.2               │     │ D3 Cart  │
   │  │  Create Order           │←────│  Store   │ (read cart items)
   │  │  (DB Transaction)       │     └──────────┘
   │  │                         │
   │  │  ┌───────────────────┐  │      ┌──────────┐
   │  │  │ 5.2a Create Order │──┼─────→│ D4 Orders│ (insert order)
   │  │  │      record       │  │      │  Store   │
   │  │  └───────────────────┘  │      └──────────┘
   │  │  ┌───────────────────┐  │      ┌──────────┐
   │  │  │ 5.2b Create Order │──┼─────→│ D4 Orders│ (insert order_items)
   │  │  │      Items        │  │      │  Store   │
   │  │  └───────────────────┘  │      └──────────┘
   │  │  ┌───────────────────┐  │      ┌──────────┐
   │  │  │ 5.2c Clear Cart   │──┼─────→│ D3 Cart  │ (delete all items)
   │  │  └───────────────────┘  │      │  Store   │
   │  │                         │      └──────────┘
   │  └─────────┬───────────────┘
   │            │ Order Confirmation (order ID, details)
   │            ▼
   │
   │  5.3 View Order History
   ▼
   ┌─────────────────────────┐         ┌──────────┐
   │      P5.3               │←───────│ D4 Orders│
   │  Retrieve User Orders   │         │  Store   │ (where user_id = auth)
   └─────────┬───────────────┘         └──────────┘
             │ Paginated Order List
             ▼

   5.4 View Order Detail (order_id)
   │
   ▼
   ┌─────────────────────────┐         ┌──────────┐   ┌──────────┐
   │      P5.4               │←───────│ D4 Orders│   │ D2 Books │
   │  Retrieve Order Detail  │←─────────────────────│  Store   │
   │  with Line Items        │         └──────────┘   └──────────┘
   └─────────┬───────────────┘        (order + items) (book titles)
             │ Order Detail (items, quantities, prices, total)
             ▼
        ┌──────────┐
        │ Customer │
        └──────────┘
```

**Sub-Process Descriptions:**

| Process | Name | Input | Output | Description |
|---------|------|-------|--------|-------------|
| P5.1 | Generate Checkout Summary | user_id | Cart items, total | Loads cart items with book data, calculates grand total for review |
| P5.2 | Create Order (Transaction) | user_id, cart items | Order + OrderItems | Within a DB transaction: creates Order, creates OrderItems, deletes cart items |
| P5.2a | Create Order Record | user_id, total | Order row | Inserts into `orders` with status = 'pending' |
| P5.2b | Create Order Items | order_id, cart items | OrderItem rows | Inserts one `order_items` row per cart item (book_id, qty, price, line_total) |
| P5.2c | Clear Cart | user_id | Empty cart | Deletes all `cart_items` where user_id matches |
| P5.3 | Retrieve User Orders | user_id | Paginated orders | Fetches orders for authenticated user, newest first |
| P5.4 | Retrieve Order Detail | order_id, user_id | Order with items | Loads order with items.book; verifies ownership (403 if mismatch) |

---

### Level 2.6 — P6: Admin Book Management

```
┌──────────┐
│  Admin   │
└──┬──┬──┬─┘
   │  │  │
   │  │  │  6.1 Add Book (title, author, category, price, stock, image_url, description)
   │  │  ▼
   │  │  ┌─────────────────────────┐         ┌──────────┐
   │  │  │      P6.1               │────────→│ D2 Books │
   │  │  │  Validate & Create Book │         │  Store   │
   │  │  └─────────┬───────────────┘         └──────────┘
   │  │            │ Success / Validation Errors
   │  │            ▼
   │  │
   │  │  6.2 Edit Book (book_id, updated fields)
   │  ▼
   │  ┌─────────────────────────┐         ┌──────────┐
   │  │      P6.2               │←───────│ D2 Books │ (load existing)
   │  │  Validate & Update Book │────────→│  Store   │ (save changes)
   │  └─────────┬───────────────┘         └──────────┘
   │            │ Success / Validation Errors
   │            ▼
   │
   │  6.3 Delete Book (book_id)
   ▼
   ┌─────────────────────────┐         ┌──────────┐
   │      P6.3               │────────→│ D2 Books │ (delete record)
   │  Delete Book            │         │  Store   │
   └─────────┬───────────────┘         └──────────┘
             │ Deletion Confirmation
             ▼

   6.4 List All Books
   │
   ▼
   ┌─────────────────────────┐         ┌──────────┐
   │      P6.4               │←───────│ D2 Books │
   │  Retrieve Admin Book    │         │  Store   │
   │  Listing (paginated)    │         └──────────┘
   └─────────┬───────────────┘
             │ Paginated Book List with Edit/Delete Actions
             ▼
        ┌──────────┐
        │  Admin   │
        └──────────┘
```

---

### Level 2.8 — P8: Admin Order Management

```
┌──────────┐
│  Admin   │
└──┬──┬────┘
   │  │
   │  │  8.1 View All Orders
   │  ▼
   │  ┌─────────────────────────┐         ┌──────────┐   ┌──────────┐
   │  │      P8.1               │←───────│ D4 Orders│   │ D1 Users │
   │  │  List All Orders        │←─────────────────────│  Store   │
   │  │  (with customer info)   │         └──────────┘   └──────────┘
   │  └─────────┬───────────────┘        (all orders)   (customer names)
   │            │ Paginated Order List
   │            ▼
   │
   │  8.2 View Order Detail (order_id)
   │
   ▼
   ┌─────────────────────────┐         ┌──────────┐   ┌──────────┐
   │      P8.2               │←───────│ D4 Orders│   │ D2 Books │
   │  Retrieve Order Detail  │←─────────────────────│  Store   │
   │  with All Line Items    │         └──────────┘   └──────────┘
   └─────────┬───────────────┘
             │ Order + Items + Book Titles + Customer Info
             ▼

   8.3 Update Order Status (order_id, new_status)
   │
   ▼
   ┌─────────────────────────┐         ┌──────────┐
   │      P8.3               │────────→│ D4 Orders│
   │  Validate & Update      │         │  Store   │
   │  Order Status            │         └──────────┘
   └─────────┬───────────────┘
             │ Updated Status Confirmation
             ▼    (pending → processing → shipped → delivered / cancelled)
        ┌──────────┐
        │  Admin   │
        └──────────┘
```

---

### Level 2.9 — P9: Admin Dashboard

```
┌──────────┐
│  Admin   │
└────┬─────┘
     │
     │ Dashboard Request
     ▼
┌────────────────────────────────────────┐
│              P9                         │
│        Admin Dashboard                  │
│                                         │
│  ┌──────────────┐    ┌──────────────┐  │     ┌──────────┐
│  │ P9.1 Count   │───→│  Total Users │  │←───│ D1 Users │
│  │ Total Users  │    └──────────────┘  │     │  Store   │
│  └──────────────┘                      │     └──────────┘
│                                         │
│  ┌──────────────┐    ┌──────────────┐  │     ┌──────────┐
│  │ P9.2 Count   │───→│  Total Books │  │←───│ D2 Books │
│  │ Total Books  │    └──────────────┘  │     │  Store   │
│  └──────────────┘                      │     └──────────┘
│                                         │
│  ┌──────────────┐    ┌──────────────┐  │     ┌──────────┐
│  │ P9.3 Count   │───→│ Total Orders │  │←───│ D4 Orders│
│  │ Total Orders │    │ + Revenue    │  │     │  Store   │
│  └──────────────┘    └──────────────┘  │     └──────────┘
│                                         │
│  ┌──────────────┐    ┌──────────────┐  │
│  │ P9.4 Recent  │───→│ 5 Latest     │  │←─── D4 Orders
│  │ Orders       │    │ Orders       │  │
│  └──────────────┘    └──────────────┘  │
│                                         │
│  ┌──────────────┐    ┌──────────────┐  │
│  │ P9.5 Recent  │───→│ 5 Newest     │  │←─── D1 Users
│  │ Users        │    │ Users        │  │
│  └──────────────┘    └──────────────┘  │
│                                         │
└────────────────────────────────────────┘
     │
     │ Dashboard View (stats + recent orders + recent users)
     ▼
┌──────────┐
│  Admin   │
└──────────┘
```

---

## Complete Data Store ↔ Process Mapping

The following table shows **which processes read from and write to each data store**, providing a complete picture of data dependencies.

| Data Store | Read By (Processes) | Written By (Processes) |
|------------|--------------------|-----------------------|
| **D1 — Users** | P1.2 (authenticate), P2 (load profile), P7 (list users), P8.1 (customer names), P9.1 (count), P9.5 (recent) | P1.1 (register), P1.4 (reset password), P2 (update profile, delete account), P7 (delete user) |
| **D2 — Books** | P3 (catalog, search, filter, detail), P4.1 (get price), P4.4 (titles for cart), P5.1 (checkout summary), P5.4 (order item titles), P6.4 (admin listing), P8.2 (order item titles), P9.2 (count) | P6.1 (create), P6.2 (update), P6.3 (delete) |
| **D3 — Cart Items** | P4 (all sub-processes), P5.1 (checkout summary), P5.2 (order creation) | P4.1 (add item), P4.2 (update qty), P4.3 (remove item), P5.2c (clear cart) |
| **D4 — Orders** | P5.3 (user order history), P5.4 (order detail), P8 (all sub-processes), P9.3 (count + revenue), P9.4 (recent orders) | P5.2a (create order), P5.2b (create items), P8.3 (update status) |
| **D5 — Password Reset Tokens** | P1.4 (validate token) | P1.3 (generate token), P1.4 (delete used token) |
| **D6 — Sessions** | Laravel (session management) | P1.2 (create session), Laravel (update/destroy) |

---

## Summary

| DFD Level | Purpose | Processes Shown |
|-----------|---------|----------------|
| **Level 0 (Context)** | System boundary — who interacts with the system and what data flows in/out | 1 (entire system) |
| **Level 1** | Major functional areas and data stores | 9 processes, 6 data stores |
| **Level 2** | Detailed decomposition of each major process | 25+ sub-processes |

These DFDs collectively demonstrate that every data flow in the Online Bookstore system is:
- **Traceable** — each flow originates from an external entity or data store and terminates at a process, data store, or external entity.
- **Balanced** — every Level 1 process that has incoming/outgoing flows at Level 0 is properly decomposed at Level 2.
- **Complete** — all system functionality (authentication, catalog, cart, orders, admin) is represented.
