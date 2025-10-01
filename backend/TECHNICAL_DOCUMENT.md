### **Technical Document: JakaAja - Web Kantin Polibatam**

**Version:** 1.0
**Date:** 23 May 2024

### 1. Project Overview

JakaAja is a web-based canteen application for Politeknik Negeri Batam (Polibatam). It aims to streamline the ordering process for students, providing a centralized platform to browse menus from various canteens, place orders, and make payments. The system will also provide management tools for canteen owners and a high-level administrative dashboard for system oversight.

*   **Project Name:** JakaAja
*   **Core Users:** Students, Tenant Managers, Admins.
*   **Key Technologies:** Laravel 12, Blade, Tailwind CSS, Alpine.js, MySQL/PostgreSQL, Pusher, FCM.

### 2. Terminology Standardization

To ensure consistency in the codebase, database, and documentation, we will use the following terms:

*   **Tenant:** Refers to the individual shop, stall, or canteen. (Replaces `Stand`). This is a common and professional term.
*   **Tenant Manager:** The user role responsible for managing a Tenant. (Replaces `Pengelola`).
*   **Student:** The end-user who places orders. (Replaces `Pengguna`).
*   **Menu Item:** A specific food or drink item sold by a Tenant. (Replaces `Item`).
*   **Category:** Food/drink categories like "Minuman", "Roti", etc.
*   **Order:** A transaction record for items purchased from a *single* Tenant. A student's checkout from a cart with items from 3 tenants will generate 3 separate orders.

### 3. Technical Stack & Key Decisions

*   **Backend:** Laravel 12 (or latest stable)
    *   **Authentication:** Laravel's default auth scaffolding (Breeze with Blade). It's simple, secure, and quick to set up.
    *   **Database:** MySQL 8+ or PostgreSQL 14+.
    *   **Real-time Events:** Laravel Echo with Pusher for real-time order status updates.
    *   **File/Image Handling:** `spatie/laravel-medialibrary` for handling all image uploads (user avatars, tenant logos, QRIS, menu items, payment proofs). It simplifies file management and conversions.
    *   **Notifications:** Laravel's built-in notification system, which supports channels for Database, Mail, and custom channels for FCM.
*   **Frontend:**
    *   **UI Framework:** Tailwind CSS for a utility-first approach, enabling rapid UI development.
    *   **Interactivity:** Alpine.js. It's lightweight and integrates perfectly with Blade. It will be used primarily for the **shopping cart system**, which will be managed entirely on the client-side using **Local Storage**.
*   **Deployment (Suggestion):** A simple VPS (DigitalOcean, Linode) with Laravel Forge or manual setup with Nginx, PHP-FPM, and Supervisor (for queues).

### 4. Database Schema Design

This schema is designed for clarity, efficiency, and scalability.

**`users`**
*   `id` (PK, BigInt, Unsigned)
*   `name` (String)
*   `email` (String, Unique)
*   `email_verified_at` (Timestamp, Nullable)
*   `password` (String)
*   `role` (Enum: 'admin', 'tenant_manager', 'student') - Default: 'student'
*   `fcm_token` (Text, Nullable) - For Firebase Cloud Messaging push notifications.
*   `remember_token`, `timestamps`

---
**`tenants`** (The canteen/shop)
*   `id` (PK, BigInt, Unsigned)
*   `user_id` (FK to `users.id`) - The Tenant Manager.
*   `building_id` (FK to `buildings.id`, Nullable)
*   `name` (String)
*   `slug` (String, Unique) - For clean URLs.
*   `description` (Text, Nullable)
*   `is_open` (Boolean) - To show if the tenant is currently open or closed.
*   `timestamps`
*   *Media Library will handle logo and QRIS images.*

---
**`buildings`**
*   `id` (PK, BigInt, Unsigned)
*   `name` (String, Unique)
*   `timestamps`

---
**`categories`** (Food/Drink categories)
*   `id` (PK, BigInt, Unsigned)
*   `name` (String)
*   `slug` (String, Unique)
*   `timestamps`

---
**`menu_items`**
*   `id` (PK, BigInt, Unsigned)
*   `tenant_id` (FK to `tenants.id`)
*   `name` (String)
*   `description` (Text, Nullable)
*   `price` (Decimal, 10, 2)
*   `is_available` (Boolean) - For stock availability.
*   `timestamps`
*   *Media Library will handle the item image.*

---
**`category_menu_item`** (Pivot Table)
*   `category_id` (FK to `categories.id`)
*   `menu_item_id` (FK to `menu_items.id`)
*   Primary Key: (`category_id`, `menu_item_id`)

---
**`orders`**
*   `id` (PK, BigInt, Unsigned)
*   `order_code` (String, Unique) - A user-friendly, unique ID like `JKA-2405-0001`.
*   `student_id` (FK to `users.id`)
*   `tenant_id` (FK to `tenants.id`)
*   `total_price` (Decimal, 10, 2)
*   `payment_method` (Enum: 'qris', 'cash')
*   `payment_status` (Enum: 'pending', 'paid', 'failed') - Default: 'pending'.
*   `order_status` (Enum: 'pending_approval', 'rejected', 'preparing', 'ready_to_pickup', 'completed')
*   `student_notes` (Text, Nullable)
*   `timestamps`
*   *Media Library will handle the QRIS payment proof attachment.*

---
**`order_items`** (What was actually in the order)
*   `id` (PK, BigInt, Unsigned)
*   `order_id` (FK to `orders.id`)
*   `menu_item_id` (FK to `menu_items.id`, Nullable) - Nullable in case the original item is deleted.
*   `item_name` (String) - Snapshot of the item name at time of order.
*   `price` (Decimal, 10, 2) - Snapshot of the price at time of order.
*   `quantity` (Integer)

### 5. Work Separation: (Frontend) & (Backend)

This is a proposed breakdown for the 1-month timeline, designed for parallel work.

| Week | (Backend) | (Frontend) | Collaboration Points |
| :--- | :--- | :--- | :--- |
| **Week 1** | **Project & Auth Setup:** <br>- Init Laravel project, Git repo. <br>- Setup database, run migrations for `users`, `tenants`, `buildings`. <br>- Implement Laravel Breeze auth (Register, Login, Logout, Password Reset). <br>- Create basic seeders for dummy data. <br>- Setup Spatie Media Library. | **UI Foundation & Static Pages:** <br>- Setup Tailwind CSS & Alpine.js. <br>- Create main layout (Blade components: header, footer, sidebar). <br>- Build static pages: Landing page. <br>- Style the auth pages generated by Breeze (Login, Register). | - Agree on Git branching strategy (e.g., `main`, `develop`, feature branches). <br>- provides HTML/CSS for to integrate into Blade layouts. |
| **Week 2** | **Core Viewing & Cart Logic:** <br>- Build models, controllers, and routes for viewing Tenants and their Menu Items. <br>- Implement API/endpoints that return tenant/menu data as JSON. <br>- Create Category models & controllers. <br>- Implement search and filter logic (by name, category). | **Browsing & Cart Implementation:** <br>- Build UI for Tenant List page. <br>- Build UI for a single Tenant's Menu page. <br>- Implement the **Alpine.js Shopping Cart** using Local Storage. <br>- Cart functionality: Add item, remove item, update quantity, clear cart. <br>- Display cart summary on all pages. | - provides with the exact JSON structure for tenants and menus. <br>- shows the cart data structure for the checkout process. |
| **Week 3** | **Ordering & Management:** <br>- Implement the Checkout Controller logic (receives cart data, creates Orders & OrderItems). <br>- Implement Order Status logic. <br>- Setup **Pusher & Laravel Echo** for real-time events. <br>- Fire `OrderStatusUpdated` event when a Tenant Manager changes an order's status. <br>- Build controllers for Tenant Manager dashboard (view/manage orders, update status). | **Checkout & Order History:** <br>- Build the Checkout page UI. <br>- Implement logic to send cart data to Sely's checkout endpoint. <br>- Build the Student's Order History page. <br>- Implement **Laravel Echo listener** on the history page to update order statuses in real-time without refreshing. <br>- Build the Tenant Manager dashboard UI to manage orders. | - Intense collaboration on the checkout API endpoint. <br>- explains the private channel name format (e.g., `private-orders.{student_id}`) for to listen on. |
| **Week 4** | **Admin, Notifications & Polish:** <br>- Build Admin dashboard: User Management, Tenant Management, etc. <br>- Implement **Notification System (FCM & Email)**. Listen for the `OrderStatusUpdated` event to send notifications. <br>- Implement basic financial reports (e.g., export orders to CSV). <br>- Write tests, final seeding, and prepare for deployment. | **Admin UI & Final Touches:** <br>- Build the UI for all Admin management pages. <br>- Implement frontend for user profile/settings page. <br>- Final responsive design checks and bug fixes across the entire application. <br>- Write simple user guide/manual book content. | - provides endpoints for all Admin CRUD operations. <br>- Final integration testing together. |

