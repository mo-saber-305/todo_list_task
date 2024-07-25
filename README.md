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

2. Install dependencies:

   ```sh
   composer install
   npm install

3. Copy the .env.example file to .env:

   ```sh
   cp .env.example .env

 4. Generate the application key:
    
    ```sh
    php artisan key:generate

5. Set up your database in the .env file:

    ```sh
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

6. Run the migrations and seed the database:

   ```sh
   php artisan migrate --seed

7. Compile the assets:

   ```sh
   npm run dev

8. Serve the application:

   ```sh
   php artisan serve

