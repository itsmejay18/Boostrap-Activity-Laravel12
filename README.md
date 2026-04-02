# Bootstrap Activity Laravel App

This project is a Laravel-based file management and user administration activity project with authentication, dashboard views, and admin-oriented CRUD workflows.

## Core Modules

- Login and session handling
- Admin dashboard
- File management
- User management
- Shared layouts and partials for the admin interface

## Tech Stack

- Laravel and PHP
- Blade templates
- Eloquent models for users and file records
- Database configured through `.env`
- Node tooling for asset compilation

## Project Structure

- `app/Http/Controllers` contains login, dashboard, users, and file-management logic
- `app/Models` includes `User` and `FileRecord`
- `resources/views` contains authentication pages and admin views
- `routes/web.php` defines guest and authenticated flows

## Getting Started

1. Install PHP, Composer, Node.js, and a database server.
2. Run `composer install`.
3. Create a `.env` file from `.env.example`.
4. Configure the database in `.env`.
5. Run `php artisan key:generate`.
6. Run `php artisan migrate`.
7. Run `npm install`.
8. Run `npm run dev`.
9. Start the app with `php artisan serve`.

## Notes

- The repository appears to be built as an instructional or activity project, so the codebase is a good starting point for expanding file-management features.
