# Online Bookstore — Project Documentation

---

## About This Document

### What Is Included in This Document

This document serves as the **comprehensive technical and functional reference** for the Online Bookstore web application. It consolidates every aspect of the project — from high-level scope and business objectives down to database columns, route definitions, and file-level code structure — into a single, authoritative source of truth. The following table summarizes each section and the information it provides:

| # | Section | What It Covers |
|---|---------|---------------|
| 1 | **Project Overview** | A concise summary of what the application is, its purpose, and the core capabilities it offers to end users and administrators. |
| 2 | **Project Scope** | A detailed breakdown of the project's boundaries — including objectives, target user roles (Customer, Administrator, Guest), all functional features (user registration, authentication, book catalog, search/filtering, shopping cart, checkout, order tracking, and full admin panel), non-functional quality attributes (security, performance, responsiveness, maintainability, scalability), features explicitly excluded from scope, a system boundary diagram, and the final list of deliverables. |
| 3 | **Technology Stack** | The specific technologies, frameworks, and libraries used at each layer of the application — backend (Laravel 12, PHP 8.2+), database (MySQL 8.4.3), frontend (Blade, TailwindCSS 3, Alpine.js 3), build tooling (Vite 7), and authentication scaffold (Laravel Breeze 2.3). |
| 4 | **Database Schema** | The complete database design — all 13 tables with descriptions, entity-relationship mappings, and key column definitions including data types, foreign keys, and constraints. |
| 5 | **Features** | A feature-by-feature inventory of what the application does, organized by domain: authentication, book catalog, shopping cart, checkout/orders, and the admin panel. |
| 6 | **Application Architecture** | The internal structure of the codebase — Eloquent models and their relationships, all controllers and their responsibilities, middleware components, and a full tree of all 37 Blade view templates organized by module. |
| 7 | **Routes Summary** | Every HTTP route in the application, grouped by access level (public, guest-only, authenticated, admin-only), with method, URI, route name, and action description. |
| 8 | **Database Migrations** | A chronological list of all 9 migration files that define the database schema, showing how the database evolved over time. |
| 9 | **Seeders** | The database seeders available for populating initial data, including the admin user seeder. |
| 10 | **Validation Rules** | Server-side validation rules applied to book creation/update, cart updates, and order status changes, ensuring data integrity. |
| 11 | **Security Features** | A summary of all security mechanisms — session-based authentication, bcrypt password hashing, CSRF protection, authorization scoping, admin middleware, and mass assignment protection. |
| 12 | **Sample Data** | A snapshot of the initial data loaded from the SQL dump, showing the starting state of users, books, cart items, and orders. |
| 13 | **How to Run** | Step-by-step setup instructions for developers — from starting MySQL and importing the database to installing dependencies and launching the development servers. |
| 14 | **Project File Structure** | A complete directory tree of the entire project, showing the location of every controller, model, middleware, view, migration, seeder, configuration file, and frontend asset. |
| 15 | **Known Gaps / Future Enhancements** | An honest assessment of features not yet implemented and areas for future improvement, providing a roadmap for continued development. |
| — | **Data Flow Diagrams (DFD)** *(section 2.2 + `doc/DFD-Visual.html`)* | A complete set of DFDs at three levels: Level 0 (Context Diagram) showing external entities and system boundary, Level 1 showing 9 major processes and 4 data stores, and Level 2 with detailed decomposition of authentication, book catalog, shopping cart, order processing, admin book management, and admin dashboard processes. |
| — | **Entity Relationship Diagram (ERD)** *(section 2.3 + `doc/ERD-Visual.html`)* | A visual ERD showing all 5 database entities (users, books, cart_items, orders, order_items), their attributes, primary/foreign keys, data types, constraints, and one-to-many relationships with crow's foot notation. Includes entity details, relationship summary, and business rules. |

### Purpose of This Document in the Software Development Lifecycle

In any software development project, the **documentation phase** is a critical stage that bridges the gap between conceptual planning and actual implementation. This document was produced as part of the **requirements analysis, design, and documentation phase** of the Software Development Life Cycle (SDLC). Its purpose is multi-fold:

**1. Requirements Capture and Traceability**

This document formally records **what** the system must do (functional requirements) and **how well** it must perform (non-functional requirements). By documenting every feature — from user registration to admin order management — alongside its implementation evidence (controllers, routes, views), it creates a **traceability matrix** that links each business requirement to its corresponding code artifact. This ensures that no requirement is overlooked during development and that every piece of code serves a documented purpose.

**2. Communication Between Stakeholders**

Software projects involve multiple stakeholders — developers, project managers, testers, clients, and academic evaluators. This document provides a **common language and reference point** that all parties can use to understand the system. A developer can look up the route table to understand API endpoints; a tester can reference the validation rules to design test cases; a project manager can review the scope section to confirm that deliverables match expectations.

**3. Architectural Blueprint**

The architecture, database schema, and file structure sections serve as the **technical blueprint** of the application. They describe the MVC pattern, the separation of concerns between controllers, models, and views, the middleware pipeline, and the database relationships. This blueprint is essential for:
- **Onboarding new developers** who need to understand the system quickly.
- **Debugging issues** by knowing exactly where each piece of logic resides.
- **Planning future enhancements** by understanding the current structure and its extension points.

**4. Quality Assurance Foundation**

The validation rules, security features, and non-functional requirements documented here form the **foundation for quality assurance activities**. Testers can derive test cases directly from the functional scope (e.g., "verify that a customer cannot access `/admin/dashboard`"), the validation rules (e.g., "submit a book with a negative price and verify rejection"), and the security requirements (e.g., "attempt to access another user's order and verify a 403 response"). Without this documentation, testing would be ad-hoc and incomplete.

**5. Scope Management and Change Control**

The "Out of Scope" section (Section 2.6) is particularly important in project management. By explicitly listing features that are **not** part of the current project — such as payment gateway integration, email notifications, and wish lists — it sets clear expectations and prevents **scope creep**. If a stakeholder later requests one of these features, the team can point to this section and manage the request through a formal change control process rather than absorbing unplanned work.

**6. Knowledge Preservation**

Software projects are rarely developed in isolation or by a single person forever. Team members change, projects are handed off, and maintenance extends far beyond the initial development period. This document ensures that the **institutional knowledge** of the project — why certain design decisions were made, how the system is structured, what its limitations are — is preserved independently of any individual contributor. It transforms tribal knowledge into organizational knowledge.

### Benefits of the Documentation Phase

| # | Benefit | Description |
|---|---------|-------------|
| 1 | **Reduced Ambiguity** | Written specifications eliminate misunderstandings about what the system should do. Every stakeholder works from the same documented truth. |
| 2 | **Faster Onboarding** | New team members can read this document and understand the entire system — its purpose, architecture, database, routes, and features — without needing extensive verbal walkthroughs. |
| 3 | **Improved Code Quality** | When developers understand the full picture before writing code, they produce more cohesive, well-structured implementations that align with the overall architecture. |
| 4 | **Efficient Testing** | Testers derive comprehensive test plans directly from documented requirements, ensuring complete coverage and reducing the likelihood of missed defects. |
| 5 | **Easier Maintenance** | Future developers maintaining or extending the application can quickly locate relevant code, understand data flows, and identify the impact of proposed changes. |
| 6 | **Accountability and Traceability** | Every requirement can be traced to its implementation, and every implementation can be traced back to a requirement. This two-way traceability ensures nothing is built without justification and nothing is required without being built. |
| 7 | **Risk Mitigation** | By documenting known gaps and out-of-scope features upfront, the project team proactively identifies and communicates risks, preventing surprises during delivery or evaluation. |
| 8 | **Professional Standard** | Comprehensive documentation is a hallmark of professional software engineering. It demonstrates disciplined development practices and adds credibility to the project. |
| 9 | **Foundation for Future Phases** | The "Known Gaps / Future Enhancements" section provides a ready-made backlog for the next development iteration, ensuring continuity between project phases. |
| 10 | **Client and Evaluator Confidence** | A well-documented project gives clients and evaluators confidence that the development was methodical, thorough, and aligned with best practices in software engineering. |

---

## 1. Project Overview

An online bookstore web application built with **Laravel 12** (PHP 8.2+). It allows users to browse books, manage a shopping cart, place orders, and provides an admin panel for managing books, users, and orders.

---

## 2. Project Scope

### 2.1 Introduction

The **Online Bookstore** is a full-stack web application designed to simulate a real-world e-commerce platform specialized in selling books. The project demonstrates end-to-end implementation of a multi-role application with distinct customer and administrator workflows, covering user authentication, product catalog management, shopping cart operations, order processing, and administrative oversight.

### 2.2 Objectives

1. **Provide a user-friendly platform** for customers to discover, search, filter, and purchase books online.
2. **Implement role-based access control** separating customer capabilities from administrative privileges.
3. **Deliver a complete shopping experience** from browsing through cart management to order placement and tracking.
4. **Enable administrative management** of the entire bookstore — including books, users, and orders — through a dedicated admin panel.
5. **Demonstrate modern web development practices** using the Laravel ecosystem with Blade templating, TailwindCSS, and Vite.

### 2.3 Target Users

| Role | Description |
| ------------- | ----------- |
| **Customer** | A registered user who can browse books, search/filter the catalog, manage a shopping cart, place orders, and view order history. |
| **Administrator** | A privileged user (`is_admin = true`) who can manage the book catalog (add, edit, delete), manage user accounts, and oversee/update order statuses. |
| **Guest** | An unauthenticated visitor who can only access the landing page, registration, and login. All bookstore features require authentication. |

### 2.4 Functional Scope

#### 2.4.1 User Registration & Authentication
- New users can self-register with name, email, and password.
- Registered users can log in using email and password credentials.
- A "Forgot Password" flow allows users to reset their password via an emailed reset link.
- Email verification is supported to confirm user identity.
- Session-based authentication with "Remember Me" support.

#### 2.4.2 User Account Management
- Users can edit their profile information (name and email).
- Users can update their password from the profile page.
- Users can permanently delete their account.

#### 2.4.3 Book Catalog & Display
- The system displays all books in a paginated table (10 books per page).
- Each book shows: **title**, **author**, **category**, **price**, and **stock** quantity.
- A dedicated detail page shows full information including **description** and **image** (if available).

#### 2.4.4 Book Search & Filtering
- **Search**: Users can search books by title, author, or category using a single search input field.
- **Category filter**: Dropdown populated with all unique categories from the database.
- **Price range filter**: Minimum and maximum price inputs for narrowing results.
- **Availability filter**: "In Stock" checkbox to show only books with stock > 0.
- All filters can be combined and are preserved across pagination.
- A "Reset" button clears all active filters.

#### 2.4.5 Shopping Cart
- Authenticated users can add any in-stock book to their cart.
- If a book already exists in the cart, the quantity is incremented.
- Users can update the quantity of any cart item.
- Users can remove individual items from the cart.
- The cart page displays each item's title, unit price, quantity, subtotal, and the **grand total** calculated automatically.
- Cart items are scoped per user — users cannot access or modify another user's cart.

#### 2.4.6 Checkout & Order Placement
- The checkout page displays a summary of all cart items with prices and the total.
- Placing an order creates an `Order` record and corresponding `OrderItem` records in a database transaction.
- The cart is cleared upon successful order placement.
- Users are redirected to the order detail page after checkout.

#### 2.4.7 Order History & Tracking
- Users can view a paginated list of their past orders.
- Each order shows: order ID, total amount, status, and date.
- Order detail pages list all line items with book title, quantity, unit price, and line total.
- Orders are scoped — users can only view their own orders.

#### 2.4.8 Admin — Book Management
- Only administrators can add new books to the catalog.
- Only administrators can edit existing book details (title, author, category, description, price, stock, image URL).
- Only administrators can delete books from the catalog.
- The admin book management panel is accessible via the navigation bar (visible only to admins).
- Customers see only the "Add to Cart" action on book listings; Edit and Delete buttons are hidden.

#### 2.4.9 Admin — User Management
- Administrators can view a list of all registered users with their name, email, admin status, order count, and registration date.
- Administrators can view a detailed profile for any user, including their complete order history.
- Administrators can delete non-admin user accounts.
- Admin users cannot be deleted through this interface (safety measure).

#### 2.4.10 Admin — Order Management
- Administrators can view all orders across all users.
- Each order shows: order ID, customer name, total, item count, status, and date.
- Administrators can view full order details including all line items.
- Administrators can update order status through a dropdown with options: `pending`, `processing`, `shipped`, `delivered`, `cancelled`.

#### 2.4.11 Admin Dashboard
- Displays summary statistics: total users, total books, total orders, and total revenue.
- Shows the 5 most recent orders with status badges.
- Shows the 5 most recently registered users.
- Provides quick-access links to user management, book management, and order management.

### 2.5 Non-Functional Scope

| Aspect | Description |
| ------------------- | ----------- |
| **Security** | CSRF protection on all forms, bcrypt password hashing, session-based authentication, role-based middleware for admin routes, authorization checks on cart/order ownership. |
| **Responsiveness** | TailwindCSS-based responsive layout. Navigation includes both desktop and mobile (hamburger menu) variants. |
| **Performance** | Eager-loading of Eloquent relationships where needed, database pagination to limit query size, Vite-based asset bundling with HMR for development. |
| **Maintainability** | MVC architecture with clear separation of controllers, models, and views. Blade component system for reusable UI elements. |
| **Scalability** | Database-backed sessions, cache, and job queues are configured and ready for horizontal scaling. |

### 2.6 Out of Scope (Not Implemented)

The following features are **not** part of the current project scope:

1. **Payment gateway integration** — No real payment processing (Stripe, PayPal, etc.). Orders are recorded directly without payment.
2. **Inventory/stock decrement** — Book stock is displayed but not automatically reduced when an order is placed.
3. **Email notifications** — No transactional emails for order confirmation, status updates, or shipping notifications.
4. **Book image upload** — The `image_url` field stores external URLs; there is no file upload mechanism.
5. **Wish list / favorites** — Users cannot save books to a wish list.
6. **Book reviews and ratings** — No review or rating system for books.
7. **Discount codes / coupons** — No promotional pricing or coupon support.
8. **Shipping address management** — No address collection or shipping calculation.
9. **Multi-language / internationalization** — The interface is English-only.
10. **API endpoints** — No RESTful API; the application is server-rendered Blade templates only.
11. **Advanced analytics** — No sales reports, charts, or detailed admin analytics beyond the dashboard counters.

### 2.7 System Boundaries

```
┌─────────────────────────────────────────────────────────────┐
│                        BROWSER                              │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌────────────┐  │
│  │ Register │  │  Browse  │  │   Cart   │  │   Admin    │  │
│  │  Login   │  │  Search  │  │ Checkout │  │   Panel    │  │
│  │ Profile  │  │  Filter  │  │  Orders  │  │ Users/Books│  │
│  └────┬─────┘  └────┬─────┘  └────┬─────┘  └─────┬──────┘  │
│       │             │             │               │         │
└───────┼─────────────┼─────────────┼───────────────┼─────────┘
        │             │             │               │
┌───────▼─────────────▼─────────────▼───────────────▼─────────┐
│                   LARAVEL 12 APPLICATION                    │
│  Routes → Middleware → Controllers → Models → Views         │
│           (auth, admin)                                     │
└───────────────────────────┬─────────────────────────────────┘
                            │
┌───────────────────────────▼─────────────────────────────────┐
│                     MySQL 8.4.3                             │
│  users · books · cart_items · orders · order_items          │
│  sessions · cache · jobs · password_reset_tokens            │
└─────────────────────────────────────────────────────────────┘
```

### 2.8 Deliverables

| # | Deliverable | Description |
|---|-------------|-------------|
| 1 | Source Code | Complete Laravel 12 application with all controllers, models, views, routes, and middleware. |
| 2 | Database Schema | SQL dump (`online_bookstore (1).sql`) with schema and seed data for 13 tables. |
| 3 | Admin Panel | Fully functional admin dashboard with book, user, and order management views. |
| 4 | Authentication System | Registration, login, password reset, email verification, and profile management. |
| 5 | Project Documentation | This document (`doc/ProjectDocumentation.md`) covering scope, architecture, features, and setup instructions. |

---

## 2.2 Data Flow Diagram (DFD)

A **Data Flow Diagram (DFD)** is a graphical representation of the flow of data through the Online Bookstore system. It shows how data enters the system, how it is processed, where it is stored, and how it exits. The DFDs below were developed at three standard levels of decomposition.

> **Visual DFD:** Open `doc/DFD-Visual.html` in any web browser for the full graphical DFD diagrams (suitable for printing or screenshotting into Microsoft Visio).
>
> **Detailed DFD Reference:** See `doc/DataFlowDiagram.md` for the complete textual DFD documentation with all data flow tables.

### DFD Notation

| Symbol | Meaning | Description |
|--------|---------|-------------|
| Rectangle | **External Entity** | Source or destination of data outside the system (Guest, Customer, Administrator) |
| Circle / Rounded Rectangle | **Process** | Transforms or manipulates data (e.g., P1 Authentication, P3 Book Catalog) |
| Open Rectangle (with ID divider) | **Data Store** | Where data is persisted (e.g., D1 Users, D2 Books, D3 Cart Items, D4 Orders) |
| Arrow (→) | **Data Flow** | Movement of data between entities, processes, and data stores |

---

### Level 0 — Context Diagram

The Context Diagram shows the **entire Online Bookstore as a single process** and identifies the two external entities that interact with it.

```
 ┌──────────┐                                                   ┌───────────────────┐
 │          │─── Registration Data / Login Credentials ────────→│                   │
 │          │←── Authentication Result ───────────────────────│                   │
 │          │─── Password Reset Request ───────────────────────→│                   │
 │          │←── Reset Confirmation ──────────────────────────│                   │
 │          │─── Search / Filter Criteria ─────────────────────→│                   │
 │          │←── Book Listings & Details ──────────────────────│                   │
 │ Customer │─── Add/Update/Remove Cart ───────────────────────→│  ONLINE BOOKSTORE │
 │          │←── Cart Contents & Totals ───────────────────────│     SYSTEM (P0)   │
 │          │─── Place Order ──────────────────────────────────→│                   │
 │          │←── Order Confirmation & History ─────────────────│                   │
 │          │─── Profile Update ───────────────────────────────→│                   │
 │          │←── Updated Profile ─────────────────────────────│                   │
 └──────────┘                                                   │                   │
                                                                │                   │
 ┌──────────────┐                                               │                   │
 │              │─── Login Credentials ────────────────────────→│                   │
 │              │←── Authentication + Admin Access ───────────│                   │
 │              │─── Book Data (Add/Edit/Delete) ──────────────→│                   │
 │              │←── CRUD Confirmation ────────────────────────│                   │
 │ Administrator│─── View/Delete Users ────────────────────────→│                   │
 │              │←── User List & Details ──────────────────────│                   │
 │              │─── View Orders / Update Status ──────────────→│                   │
 │              │←── Order Data ──────────────────────────────│                   │
 │              │─── Dashboard Request ────────────────────────→│                   │
 │              │←── Dashboard Statistics ────────────────────│                   │
 └──────────────┘                                               └───────────────────┘
```

**External Entities:**

| Entity | Description |
|--------|-------------|
| **Customer** | Registers, logs in, browses books, manages cart, places orders, views order history, updates profile, resets password |
| **Administrator** | Logs in with admin privileges, manages books (CRUD), manages users (view/delete), manages orders (view/update status), views dashboard statistics |

---

### Level 1 — System Overview DFD

Level 1 decomposes the system into **9 major processes** and **6 data stores**, with **Customer** and **Administrator** as the only external entities.

```
  [Customer]──→(P1 Authentication & Registration)──→[D1 Users] [D5 Pwd Tokens] [D6 Sessions]
                         │
  [Customer]──→(P2 Profile Management)──→[D1 Users]
                         │
  [Customer]──→(P3 Book Catalog & Search)←──[D2 Books]
                         │
  [Customer]──→(P4 Shopping Cart Mgmt)──→[D3 Cart Items]←──[D2 Books (prices)]
                         │
  [Customer]──→(P5 Order Processing)──→[D4 Orders]←──[D3 Cart Items]
                         │
  [Admin]────→(P6 Admin Book Management)──→[D2 Books]
                         │
  [Admin]────→(P7 Admin User Management)──→[D1 Users]
                         │
  [Admin]────→(P8 Admin Order Management)──→[D4 Orders]
                         │
  [Admin]────→(P9 Admin Dashboard)←── Reads [D1], [D2], [D4]
```

**Processes:**

| # | Process | Description |
|---|---------|-------------|
| P1 | Authentication & Registration | Registration, login, logout, password reset, email verification |
| P2 | Profile Management | View, update, and delete user profile |
| P3 | Book Catalog & Search | Book listing, detail view, search (title/author/category), filtering (category/price/stock) |
| P4 | Shopping Cart Management | Add, update quantity, remove cart items, calculate subtotals and grand total |
| P5 | Order Processing | Checkout, order creation (DB transaction), order history, order detail |
| P6 | Admin Book Management | Admin CRUD operations on books (create, read, update, delete) |
| P7 | Admin User Management | Admin view user list, user detail with order history, delete users |
| P8 | Admin Order Management | Admin view all orders, view order detail, update order status |
| P9 | Admin Dashboard | Aggregate statistics — total users, books, orders, revenue; recent orders and users |

**Data Stores:**

| ID | Store | Table(s) |
|----|-------|----------|
| D1 | Users | `users` |
| D2 | Books | `books` |
| D3 | Cart Items | `cart_items` |
| D4 | Orders | `orders`, `order_items` |
| D5 | Password Tokens | `password_reset_tokens` |
| D6 | Sessions | `sessions` |

---

### Level 2 — Process Decomposition

#### P1: Authentication & Registration

| Sub-Process | Input | Output | Description |
|-------------|-------|--------|-------------|
| P1.1 Validate & Register | name, email, password | User record → D1 | Validates unique email, hashes password (bcrypt), creates user |
| P1.2 Authenticate User | email, password | Session → D6 | Verifies credentials against D1, creates session |
| P1.3 Generate Reset Token | email | Token → D5 | Creates secure token, stores in password_reset_tokens |
| P1.4 Reset Password | token, new password | Updated user → D1 | Validates token from D5, updates password, deletes used token |

#### P3: Book Catalog & Search

| Sub-Process | Input | Output | Description |
|-------------|-------|--------|-------------|
| P3.1 List Books | Page number | Paginated list ← D2 | 10 books per page, ordered by latest |
| P3.2 Search Books | Keyword | Matching books ← D2 | LIKE search on title, author, category |
| P3.3 Apply Filters | Category, price range, stock | Filtered results ← D2 | WHERE clauses chained on D2 |
| P3.4 View Book Detail | Book ID | Full record ← D2 | All fields for a single book |

#### P4: Shopping Cart Management

| Sub-Process | Input | Output | Description |
|-------------|-------|--------|-------------|
| P4.1 Add Item | book_id | Cart item → D3 | If exists: increment qty; else: create new record |
| P4.2 Update Quantity | cart_item_id, qty | Updated record → D3 | Validates ownership, updates quantity |
| P4.3 Remove Item | cart_item_id | Delete record → D3 | Validates ownership, deletes from cart |
| P4.4 Calculate Totals | user_id | Items + totals ← D3, D2 | Loads cart with book relations, computes price × qty |

#### P5: Order Processing

| Sub-Process | Input | Output | Description |
|-------------|-------|--------|-------------|
| P5.1 Checkout Summary | user_id | Cart + total ← D3, D2 | Loads cart items with book data for review |
| P5.2 Create Order *(DB Transaction)* | user_id | Order → D4, clear D3 | Inserts order row (status='pending'), inserts order_items, deletes all cart items |
| P5.3 View Order History | user_id | Orders ← D4 | User's orders, newest first, paginated |
| P5.4 View Order Detail | order_id | Order + items ← D4, D2 | Loads order with line items and book info; verifies ownership |

#### P6: Admin Book Management

| Sub-Process | Input | Output | Description |
|-------------|-------|--------|-------------|
| P6.1 Create Book | All book fields | INSERT → D2 | Validates and creates new book record |
| P6.2 Update Book | book_id, updated fields | UPDATE → D2 | Loads existing from D2, validates, saves changes |
| P6.3 Delete Book | book_id | DELETE → D2 | Removes book record |
| P6.4 List Books | — | All books ← D2 | Paginated admin book listing |

#### P9: Admin Dashboard

| Sub-Process | Input | Output | Description |
|-------------|-------|--------|-------------|
| P9.1 Count Users | — | Total ← D1 | COUNT(*) on users table |
| P9.2 Count Books | — | Total ← D2 | COUNT(*) on books table |
| P9.3 Count Orders + Revenue | — | Count + SUM ← D4 | COUNT(*) and SUM(total) on orders |
| P9.4 Recent Orders | — | 5 latest ← D4 | Latest 5 orders with status |
| P9.5 Recent Users | — | 5 newest ← D1 | Latest 5 registered users |

---

### Data Store × Process Matrix

| Data Store | P1 | P2 | P3 | P4 | P5 | P6 | P7 | P8 | P9 |
|------------|----|----|----|----|----|----|----|----|-----|
| **D1 Users** | R/W | R/W | — | — | — | — | R/W | R | R |
| **D2 Books** | — | — | R | R | R | R/W | — | R | R |
| **D3 Cart Items** | — | — | — | R/W | R/W | — | — | — | — |
| **D4 Orders** | — | — | — | — | R/W | — | — | R/W | R |
| **D5 Pwd Tokens** | R/W | — | — | — | — | — | — | — | — |
| **D6 Sessions** | R/W | — | — | — | — | — | — | — | — |

*(R = Read, W = Write, R/W = Both)*

---

## 2.3 Entity Relationship Diagram (ERD)

An **Entity Relationship Diagram (ERD)** is a visual representation of the database structure showing entities (tables), their attributes (columns), primary keys, foreign keys, and the relationships between them. The ERD below documents the Online Bookstore's data model.

> **Visual ERD:** Open `doc/ERD-Visual.html` in any web browser for the full graphical ERD diagram with crow's foot notation (suitable for printing or screenshotting into Microsoft Visio).

### Entities

| Entity | Table | Description |
|--------|-------|-------------|
| **users** | `users` | Registered users (customers and administrators) |
| **books** | `books` | Book catalog with title, author, category, price, stock |
| **cart_items** | `cart_items` | Shopping cart items linking users to books |
| **orders** | `orders` | Customer orders with total and status |
| **order_items** | `order_items` | Individual line items within an order |

### ERD Diagram

```
  ┌──────────────┐          ┌──────────────────┐          ┌──────────────┐
  │    users      │          │   cart_items      │          │    books      │
  ├──────────────┤          ├──────────────────┤          ├──────────────┤
  │ PK id         │──┐      │ PK id             │      ┌──│ PK id         │
  │    name       │  │  1  *│ FK user_id        │      │  │    title      │
  │    email      │  ├─────→│ FK book_id        │←─────┤  │    author     │
  │    is_admin   │  │      │    quantity        │  1  *│  │    category   │
  │    password   │  │      │    price           │      │  │    price      │
  │    ...        │  │      │    created_at      │      │  │    stock      │
  └──────────────┘  │      └──────────────────┘      │  │    image_url  │
                     │                                  │  │    ...        │
                     │  1   ┌──────────────────┐   1   │  └──────────────┘
                     │      │    orders         │      │
                     │      ├──────────────────┤      │
                     └─────→│ PK id             │      │
                        *   │ FK user_id        │      │
                            │    total          │      │
                            │    status         │      │
                            │    created_at     │      │
                            └────────┬─────────┘      │
                                     │                  │
                                  1  │  ┌──────────────────┐
                                     │  │  order_items      │
                                     │  ├──────────────────┤
                                     └─→│ PK id             │
                                     *  │ FK order_id       │
                                        │ FK book_id        │←── * ──┘
                                        │    quantity        │     1
                                        │    price           │
                                        │    line_total      │
                                        └──────────────────┘
```

### Relationships

| # | Parent | Child | FK | Cardinality | On Delete | Description |
|---|--------|-------|----|-------------|-----------|-------------|
| 1 | users | cart_items | user_id | 1 : * | CASCADE | A user can have many cart items |
| 2 | books | cart_items | book_id | 1 : * | CASCADE | A book can appear in many carts |
| 3 | users | orders | user_id | 1 : * | CASCADE | A user can place many orders |
| 4 | orders | order_items | order_id | 1 : * | CASCADE | An order contains many line items |
| 5 | books | order_items | book_id | 1 : * | CASCADE | A book can appear in many order items |

### Business Rules

1. Each **user** can have zero or many cart items and zero or many orders.
2. Each **cart item** belongs to exactly one user and references exactly one book.
3. Each **order** belongs to exactly one user and contains one or many order items.
4. Each **order item** references exactly one order and exactly one book.
5. The **cart_items** table is an associative entity between users and books (shopping phase).
6. The **order_items** table is an associative entity between orders and books (purchase phase).
7. All foreign keys use **CASCADE** on delete — removing a parent record removes all dependent child records.

---

## 3. Technology Stack

| Layer        | Technology                         |
| ------------ | ---------------------------------- |
| Backend      | Laravel 12.38.1 (PHP 8.2+)        |
| Database     | MySQL 8.4.3                        |
| Frontend     | Blade Templates, TailwindCSS 3     |
| JS Framework | Alpine.js 3                        |
| Build Tool   | Vite 7                             |
| Auth         | Laravel Breeze 2.3                 |
| HTTP Client  | Axios                              |
| CSS Forms    | @tailwindcss/forms                 |
| Font         | Figtree (via Tailwind config)      |

---

## 3. Database Schema

**Database name:** `online_bookstore`

### 3.1 Tables

| Table                  | Description                                      |
| ---------------------- | ------------------------------------------------ |
| `users`                | Registered users (customers & admins)             |
| `books`                | Book catalog (title, author, category, price, stock) |
| `cart_items`           | Items currently in a user's shopping cart         |
| `orders`               | Placed orders with total and status               |
| `order_items`          | Individual line items within an order             |
| `password_reset_tokens`| Tokens for password reset flow                    |
| `sessions`             | Database-backed user sessions                     |
| `migrations`           | Laravel migration tracking                        |
| `cache`                | Database-backed cache store                       |
| `cache_locks`          | Cache lock management                             |
| `jobs`                 | Queued jobs                                       |
| `job_batches`          | Batched job tracking                              |
| `failed_jobs`          | Failed job log                                    |

### 3.2 Entity Relationships

```
User  1──M  CartItem  M──1  Book
User  1──M  Order     1──M  OrderItem  M──1  Book
User  1──1  PasswordResetToken (via email)
User  1──M  Session
```

### 3.3 Key Columns

**users**
- `id`, `name`, `email`, `password`, `is_admin` (boolean), `email_verified_at`, `remember_token`, `created_at`, `updated_at`

**books**
- `id`, `title`, `author`, `category`, `description`, `price` (decimal 8,2), `stock` (int), `image_url`, `created_at`, `updated_at`

**cart_items**
- `id`, `user_id` (FK → users), `book_id` (FK → books), `quantity`, `price` (decimal 8,2), `created_at`, `updated_at`

**orders**
- `id`, `user_id` (FK → users), `total` (decimal 10,2), `status` (default: 'pending'), `created_at`, `updated_at`

**order_items**
- `id`, `order_id` (FK → orders), `book_id` (FK → books), `quantity`, `price` (decimal 10,2), `line_total` (decimal 10,2), `created_at`, `updated_at`

---

## 4. Features

### 4.1 Authentication (Laravel Breeze)
- User registration
- User login / logout
- Password reset (forgot password → email link → reset)
- Email verification
- Password confirmation
- Profile management (edit name/email, change password, delete account)

### 4.2 Book Catalog
- **Browse books** with pagination (10 per page)
- **Search** by title, author, or category
- **Filter** by category, price range (min/max), and availability (in stock)
- **View** individual book details
- **Create / Edit / Delete** books (admin-only — buttons hidden from customers)

### 4.3 Shopping Cart
- **Add** a book to cart (increments quantity if already in cart)
- **View** cart with item list and total
- **Update** item quantity
- **Remove** items from cart
- Authorization check: users can only modify their own cart items

### 4.4 Checkout & Orders
- **Checkout page**: summary of cart items and total
- **Place order**: creates order + order items in a DB transaction, clears the cart
- **Order history**: paginated list of past orders
- **Order detail**: view individual order with line items
- Authorization check: users can only view their own orders

### 4.5 Admin Panel (`/admin/*`)
Protected by `AdminMiddleware` (requires `is_admin = true`).

- **Dashboard**: total users, total books, total orders, total revenue, 5 most recent orders, 5 newest users
- **User management**: list all users, view user detail with order history, delete users
- **Order management**: list all orders, view order detail, update order status (`pending`, `processing`, `shipped`, `delivered`, `cancelled`)
- **Book management**: list all books, create new book, edit book, delete book

---

## 5. Application Architecture

### 5.1 Models (Eloquent)

| Model       | File                          | Relationships                          |
| ----------- | ----------------------------- | -------------------------------------- |
| `User`      | `app/Models/User.php`         | hasMany CartItem, hasMany Order        |
| `Book`      | `app/Models/Book.php`         | (standalone, referenced by CartItem & OrderItem) |
| `CartItem`  | `app/Models/CartItem.php`     | belongsTo User, belongsTo Book         |
| `Order`     | `app/Models/Order.php`        | belongsTo User, hasMany OrderItem      |
| `OrderItem` | `app/Models/OrderItem.php`    | belongsTo Order, belongsTo Book        |

### 5.2 Controllers

| Controller              | File                                              | Purpose                         |
| ----------------------- | ------------------------------------------------- | ------------------------------- |
| `BookController`        | `app/Http/Controllers/BookController.php`          | CRUD for books + search/filter  |
| `CartController`        | `app/Http/Controllers/CartController.php`          | Cart add/update/remove/view     |
| `OrderController`       | `app/Http/Controllers/OrderController.php`         | Checkout + order history        |
| `AdminController`       | `app/Http/Controllers/AdminController.php`         | Admin dashboard & management    |
| `ProfileController`     | `app/Http/Controllers/ProfileController.php`       | Profile edit/update/delete      |
| Auth Controllers (7)    | `app/Http/Controllers/Auth/*`                      | Login, register, password reset, email verification |

### 5.3 Middleware

| Middleware         | File                                           | Purpose                              |
| ------------------ | ---------------------------------------------- | ------------------------------------ |
| `AdminMiddleware`  | `app/Http/Middleware/AdminMiddleware.php`        | Blocks non-admin users (403)         |
| `auth`             | Built-in Laravel                                | Requires authenticated session       |
| `verified`         | Built-in Laravel                                | Requires verified email              |

### 5.4 Views (Blade Templates)

```
resources/views/
├── welcome.blade.php              # Landing page
├── dashboard.blade.php            # User dashboard (post-login)
├── layouts/
│   ├── app.blade.php              # Main authenticated layout
│   ├── guest.blade.php            # Guest/auth pages layout
│   └── navigation.blade.php      # Navigation bar
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
│   ├── forgot-password.blade.php
│   ├── reset-password.blade.php
│   ├── confirm-password.blade.php
│   └── verify-email.blade.php
├── books/
│   ├── index.blade.php            # Book listing with search/filter
│   ├── show.blade.php             # Single book detail
│   ├── create.blade.php           # Add new book form
│   ├── edit.blade.php             # Edit book form
│   └── partials/form.blade.php    # Shared book form partial
├── cart/
│   └── index.blade.php            # Shopping cart view
├── checkout/
│   └── create.blade.php           # Checkout / order review
├── orders/
│   ├── index.blade.php            # Order history list
│   └── show.blade.php             # Order detail
├── profile/
│   ├── edit.blade.php             # Profile edit page
│   └── partials/
│       ├── update-profile-information-form.blade.php
│       ├── update-password-form.blade.php
│       └── delete-user-form.blade.php
├── admin/
│   ├── dashboard.blade.php        # Admin dashboard with stats
│   ├── books/
│   │   ├── index.blade.php        # Admin book listing
│   │   ├── create.blade.php       # Admin add book form
│   │   └── edit.blade.php         # Admin edit book form
│   ├── users/
│   │   ├── index.blade.php        # Admin user listing
│   │   └── show.blade.php         # Admin user detail + orders
│   └── orders/
│       ├── index.blade.php        # Admin order listing
│       └── show.blade.php         # Admin order detail + status update
└── components/                    # Reusable Blade components
    ├── application-logo.blade.php
    ├── auth-session-status.blade.php
    ├── danger-button.blade.php
    ├── dropdown.blade.php
    ├── dropdown-link.blade.php
    ├── input-error.blade.php
    ├── input-label.blade.php
    ├── modal.blade.php
    ├── nav-link.blade.php
    ├── primary-button.blade.php
    ├── responsive-nav-link.blade.php
    ├── secondary-button.blade.php
    └── text-input.blade.php
```

---

## 6. Routes Summary

### 6.1 Public Routes

| Method | URI       | Action              |
| ------ | --------- | -------------------- |
| GET    | `/`       | Welcome page         |

### 6.2 Auth Routes (Guest only)

| Method | URI                        | Action                  |
| ------ | -------------------------- | ----------------------- |
| GET    | `/register`                | Registration form       |
| POST   | `/register`                | Submit registration     |
| GET    | `/login`                   | Login form              |
| POST   | `/login`                   | Submit login            |
| GET    | `/forgot-password`         | Forgot password form    |
| POST   | `/forgot-password`         | Send reset link         |
| GET    | `/reset-password/{token}`  | Reset password form     |
| POST   | `/reset-password`          | Submit new password     |

### 6.3 Authenticated Routes

| Method | URI                        | Name              | Action                    |
| ------ | -------------------------- | ----------------- | ------------------------- |
| GET    | `/dashboard`               | dashboard         | User dashboard            |
| GET    | `/profile`                 | profile.edit      | Edit profile              |
| PATCH  | `/profile`                 | profile.update    | Update profile            |
| DELETE | `/profile`                 | profile.destroy   | Delete account            |
| GET    | `/books`                   | books.index       | List books                |
| GET    | `/books/create`            | books.create      | Create book form          |
| POST   | `/books`                   | books.store       | Store new book            |
| GET    | `/books/{book}`            | books.show        | View book                 |
| GET    | `/books/{book}/edit`       | books.edit        | Edit book form            |
| PUT    | `/books/{book}`            | books.update      | Update book               |
| DELETE | `/books/{book}`            | books.destroy     | Delete book               |
| GET    | `/cart`                    | cart.index        | View cart                 |
| POST   | `/cart/add/{book}`         | cart.add          | Add book to cart          |
| POST   | `/cart/update/{cartItem}`  | cart.update       | Update cart quantity      |
| DELETE | `/cart/remove/{cartItem}`  | cart.remove       | Remove from cart          |
| GET    | `/checkout`                | checkout.create   | Checkout page             |
| POST   | `/checkout`                | checkout.store    | Place order               |
| GET    | `/orders`                  | orders.index      | Order history             |
| GET    | `/orders/{order}`          | orders.show       | Order detail              |

### 6.4 Admin Routes (`/admin/*`, requires `is_admin`)

| Method | URI                            | Name                 | Action                |
| ------ | ------------------------------ | -------------------- | --------------------- |
| GET    | `/admin/dashboard`             | admin.dashboard      | Admin dashboard       |
| GET    | `/admin/users`                 | admin.users          | List users            |
| GET    | `/admin/users/{user}`          | admin.users.show     | View user             |
| DELETE | `/admin/users/{user}`          | admin.users.destroy  | Delete user           |
| GET    | `/admin/orders`                | admin.orders         | List orders           |
| GET    | `/admin/orders/{order}`        | admin.orders.show    | View order            |
| PATCH  | `/admin/orders/{order}/status` | admin.orders.status  | Update order status   |
| GET    | `/admin/books`                 | admin.books          | List books            |
| GET    | `/admin/books/create`          | admin.books.create   | Create book form      |
| POST   | `/admin/books`                 | admin.books.store    | Store book            |
| GET    | `/admin/books/{book}/edit`     | admin.books.edit     | Edit book form        |
| PATCH  | `/admin/books/{book}`          | admin.books.update   | Update book           |
| DELETE | `/admin/books/{book}`          | admin.books.destroy  | Delete book           |

---

## 7. Database Migrations

| Migration File                                      | Description                         |
| --------------------------------------------------- | ----------------------------------- |
| `0001_01_01_000000_create_users_table.php`           | Users, password_reset_tokens, sessions tables |
| `0001_01_01_000001_create_cache_table.php`           | Cache and cache_locks tables        |
| `0001_01_01_000002_create_jobs_table.php`            | Jobs, job_batches, failed_jobs tables |
| `2025_11_14_084413_create_books_table.php`           | Books table                         |
| `2025_11_14_091817_create_cart_items_table.php`      | Cart items table                    |
| `2025_11_14_110259_create_orders_table.php`          | Orders table                        |
| `2025_11_14_110305_create_order_items_table.php`     | Order items table                   |
| `2025_11_16_124800_add_is_admin_to_users_table.php`  | Adds `is_admin` column to users     |
| `2025_11_16_125000_add_status_to_orders_table.php`   | Adds `status` column to orders      |

---

## 8. Seeders

| Seeder              | Description                                                  |
| ------------------- | ------------------------------------------------------------ |
| `DatabaseSeeder`    | Default Laravel seeder                                       |
| `AdminUserSeeder`   | Creates admin user: `admin@bookstore.com` / `admin123`       |

---

## 9. Validation Rules

### Book (create/update)
- `title` — required, string, max 255
- `author` — required, string, max 255
- `category` — nullable, string, max 255
- `description` — nullable, string
- `price` — required, numeric, min 0
- `stock` — required, integer, min 0
- `image_url` — nullable, valid URL

### Cart Update
- `quantity` — required, integer, min 1

### Order Status Update (Admin)
- `status` — required, one of: `pending`, `processing`, `shipped`, `delivered`, `cancelled`

---

## 10. Security Features

- **Authentication**: session-based via Laravel Breeze
- **Password hashing**: bcrypt (12 rounds)
- **CSRF protection**: built-in Laravel middleware
- **Authorization**: cart items and orders are scoped to the authenticated user (`abort(403)` on mismatch)
- **Admin middleware**: checks `is_admin` flag, returns 403 for non-admins
- **Mass assignment protection**: only `$fillable` fields are assignable on all models

---

## 11. Sample Data (from SQL dump)

| Entity     | Count | Examples                                          |
| ---------- | ----- | ------------------------------------------------- |
| Users      | 1     | `imran` / `imran@example.com` (is_admin = 0)      |
| Books      | 3     | test1 ($1000), test2 ($4000), test3 ($500)        |
| Cart Items | 1     | User 1 has 1x test3 in cart                       |
| Orders     | 1     | Order #1 — $1000 — pending                        |
| Order Items| 1     | 1x test1 @ $1000                                  |

---

## 12. How to Run

```bash
# 1. Start MySQL server (via Laragon or standalone)
# 2. Create database
mysql -u root -e "CREATE DATABASE IF NOT EXISTS online_bookstore;"

# 3. Import SQL dump
mysql -u root online_bookstore < "online_bookstore (1).sql"

# 4. Configure .env (DB_CONNECTION=mysql, DB_DATABASE=online_bookstore, DB_USERNAME=root)

# 5. Install dependencies
composer install
npm install

# 6. Generate app key (if needed)
php artisan key:generate

# 7. Start development servers
php artisan serve          # Laravel at http://127.0.0.1:8000
npm run dev                # Vite at http://localhost:5173
```

---

## 13. Project File Structure

```
online-bookstore/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── BookController.php
│   │   │   ├── CartController.php
│   │   │   ├── Controller.php
│   │   │   ├── OrderController.php
│   │   │   ├── ProfileController.php
│   │   │   └── Auth/ (7 auth controllers)
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php
│   │   └── Requests/
│   │       ├── ProfileUpdateRequest.php
│   │       └── Auth/LoginRequest.php
│   ├── Models/
│   │   ├── Book.php
│   │   ├── CartItem.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   └── User.php
│   ├── Providers/
│   │   └── AppServiceProvider.php
│   └── View/Components/
│       ├── AppLayout.php
│       └── GuestLayout.php
├── config/               (10 config files)
├── database/
│   ├── factories/
│   │   └── UserFactory.php
│   ├── migrations/       (9 migration files)
│   └── seeders/
│       ├── AdminUserSeeder.php
│       └── DatabaseSeeder.php
├── public/               (web root)
├── resources/
│   ├── css/app.css
│   ├── js/app.js, bootstrap.js
│   └── views/            (37 Blade templates)
├── routes/
│   ├── web.php           (main routes)
│   ├── auth.php          (auth routes)
│   └── console.php
├── storage/
├── tests/
├── composer.json
├── package.json
├── vite.config.js
├── tailwind.config.js
├── postcss.config.js
└── phpunit.xml
```

---

## 14. Known Gaps / Future Enhancements

1. **Book image upload** — The `image_url` field stores external URLs; there is no file upload mechanism.
2. **Order status notifications** — Admin can update order status but there are no email notifications sent to customers.
3. **Payment integration** — No payment gateway (Stripe, PayPal, etc.); checkout simply records the order.
4. **Stock decrement** — The stock field exists on books but is not automatically reduced when an order is placed.
5. **Admin search/filter** — Admin book/user/order listing pages do not have search or filter functionality.
6. **Wish list** — No mechanism for users to save books for later.
7. **Book reviews/ratings** — No review or rating system.
8. **Shipping addresses** — No address collection or shipping cost calculation.
