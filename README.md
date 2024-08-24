<div align="center">
  <h1>⚡ TaskFlow Pro — Enterprise Task Management Platform</h1>
  <p><strong>A Modern, Production-Grade Task Management System engineered with Clean Architecture, Decoupled Service Layers, Independent Form Requests, and Drag-and-Drop Reordering in Laravel.</strong></p>

  <p>
    <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 10">
    <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
    <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL 8.0">
    <img src="https://img.shields.io/badge/Code%20Style-PSR--12%20%2F%20Pint-brightgreen?style=for-the-badge" alt="PSR-12">
    <img src="https://img.shields.io/badge/License-MIT-blue?style=for-the-badge" alt="MIT License">
  </p>
</div>

---

## 📖 Overview

**TaskFlow Pro** is an enterprise-grade task tracking application engineered to showcase **Senior-level Laravel software engineering practices**. It avoids common monolithic anti-patterns (such as *Fat Controllers* and direct database queries in Blade views) by enforcing a strict separation of concerns, strict type hintings, unified response macros, and a reactive drag-and-drop user experience.

---

## 🏗️ Architectural Highlights

### 1. 🧩 Decoupled Service Layer Pattern
- **`TaskService` & `CategoryService`**: All business logic, Eloquent query builder scopes, database transactions, soft-deletes, and pagination algorithms are encapsulated within dedicated service classes rather than residing in controllers.

### 2. 🛡️ Independent Form Requests (Request Validation)
- Controller methods never perform raw `$request->validate()` calls.
- Validation is decoupled into **`StoreTaskRequest`**, **`UpdateTaskRequest`**, and **`StoreCategoryRequest`**, ensuring sanitized input and custom authorization hooks.

### 3. 🖐️ Drag-and-Drop Task Reordering (SortableJS)
- Real-time row reordering with instant AJAX persistence.
- Positions are tracked via an indexed `order` column and committed inside an atomic database transaction (`DB::transaction`).

### 4. 🗂️ Soft Deletes & Trash Lifecycle Management
- Safe deletion with full restoration support.
- Distinct segmented navigation tabs (`All Tasks` / `Trash`) with asynchronous state updates.

### 5. 🎨 Zero-Inline-CSS Clean Blade Architecture
- 100% free of inline `style="..."` attributes and embedded `<style>` tags.
- Fully modularized partial components:
  - `partials/_header.blade.php`
  - `partials/_filter_bar.blade.php`
  - `partials/_task_table.blade.php`
  - `partials/_task_rows.blade.php`
  - `partials/_alerts.blade.php`

### 6. 📊 Real-World Dataset & Automated Seeders
- Seeded with **50 realistic software engineering tasks** distributed across 5 categories, with active, completed, and soft-deleted states sourced directly from [`database/data/tasks.json`](database/data/tasks.json).

---

## 📂 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── TaskController.php         # Thin Resource Controller
│   │   ├── CategoryController.php     # Thin Category Controller
│   │   └── HomeController.php         # Dashboard View Controller
│   └── Requests/
│       ├── StoreTaskRequest.php       # Independent Validation Contract
│       ├── UpdateTaskRequest.php      # Independent Validation Contract
│       └── StoreCategoryRequest.php   # Independent Validation Contract
├── Models/
│   ├── Task.php                       # Strict Casts & BelongsTo Relations
│   └── Category.php                   # Mass-Assignment Protected
└── Services/
    ├── TaskService.php                # Business Logic & Filtering Engine
    └── CategoryService.php            # Category Domain Logic
```

---

## 🔌 API Endpoints Reference

| Method | Endpoint | Description | Request / Payload |
| :--- | :--- | :--- | :--- |
| `GET` | `/tasks` | List paginated tasks with dynamic filters | `?type=index&search=...&category=1&status=pending&page=1` |
| `POST` | `/tasks` | Create a new task | `StoreTaskRequest` (`title`, `description`, `category_id`) |
| `GET` | `/tasks/{id}` | Retrieve specific task details | — |
| `PUT` | `/tasks/{id}` | Update existing task | `UpdateTaskRequest` (`title`, `description`, `category_id`) |
| `DELETE` | `/tasks/{id}` | Move task to trash (Soft Delete) | — |
| `POST` | `/tasks/{id}/restore` | Restore soft-deleted task | — |
| `POST` | `/tasks/{id}/complete` | Toggle task status (`pending` $\leftrightarrow$ `completed`) | `status` |
| `POST` | `/tasks/reorder` | Update task sequence positions | `{ ordered_ids: [1, 5, 2, ...] }` |
| `GET` | `/categories` | List all available categories | — |
| `POST` | `/categories` | Store a new category | `StoreCategoryRequest` (`name`) |

---

## 🚀 Quickstart & Installation

### Prerequisites
- **PHP 8.2+** (with `pdo_mysql`, `mbstring`, `openssl` extensions)
- **Composer 2.x**
- **Node.js & NPM**
- **MySQL 8.0+**

### 1. Clone the Repository
```bash
git clone https://github.com/mo-saber-305/todo_list_task.git
cd todo_list_task
```

### 2. Install Dependencies
```bash
composer install
npm install && npm run build
```

### 3. Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```

Configure your database credentials in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_list_task
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Run Migrations & Seeders
```bash
php artisan migrate:fresh --seed
```

> **Demo User Account (Pre-Seeded):**
> - **Email:** `mosaber@test.com`
> - **Password:** `12345678`

### 5. Launch the Application
```bash
php artisan serve
```

Access the application in your browser at `http://127.0.0.1:8000`.

---

## 🧪 Code Quality & Standards

This project adheres strictly to **PSR-12** standards and is formatted with **Laravel Pint**:

```bash
# Run Laravel Pint Code Style Inspection
./vendor/bin/pint --test

# Fix & Align Code Styles
./vendor/bin/pint
```

---

## 📄 License

This software is open-sourced under the [MIT License](LICENSE).

---

<div align="center">
  <sub>Crafted with clean code & engineering precision by <a href="https://github.com/mo-saber-305">Mohamed Saber</a></sub>
</div>
