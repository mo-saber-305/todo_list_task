# To-Do List Application

This is a simple To-Do List application built with Laravel for the backend and jQuery for the frontend.

## Features

- User registration and login.
- Add, edit, and soft delete tasks.
- Each task has a title, description, category, and status (pending/completed).
- Categories for tasks (e.g., Work, Personal, Urgent).
- Pagination for task listing.
- Task filtering by category and status.
- Search tasks by title or description.

## Installation

Follow these steps to set up and run the application locally.

### Prerequisites

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL

### Steps

1. Clone the repository:

   ```sh
   git clone https://github.com/mo-saber-305/todo_list_task.git
   cd todo_list_task
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate --seed
   npm run dev
   php artisan serve

