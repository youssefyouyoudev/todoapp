# Do It — Laravel Task Manager

A sleek task manager built with Laravel and Blade, styled to mimic a modern dashboard (see inline-styled views). It supports full CRUD for tasks with status, description, and due dates.

## Features
- Task CRUD with statuses: `pending`, `in_progress`, `completed`
- Drag-and-drop kanban board with inline AJAX status updates
- Dashboard with Chart.js (monthly trend) and year/month/day stats
- Due date tracking and friendly formatting
- Flash success + validation error messaging
- Dark, dashboard-inspired UI (inline CSS in Blade layout)
- Summary stats for completed and in-progress tasks

## Stack
- PHP 8.2+ / Laravel 12
- Blade views (inline styles, no external CSS required)
- Chart.js via CDN on the dashboard
- Vite + npm for asset bundling (optional if you rebuild assets)
- Pest/PHPUnit for testing

## Getting Started
```bash
git clone  https://github.com/youssefyouyoudev/todoapp todoapp
cd todoapp

composer install
cp .env.example .env
php artisan key:generate

# Configure DB in .env, then run migrations
php artisan migrate

# (Optional) rebuild front-end assets
npm install
npm run build

# Serve the app
php artisan serve
```

Visit http://localhost:8000 — the root redirects to `/tasks`.

## Core Routes
- `GET /tasks` — list tasks
- `GET /tasks/create` — create form
- `POST /tasks` — store
- `GET /tasks/{task}` — show
- `GET /tasks/{task}/edit` — edit form
- `PUT/PATCH /tasks/{task}` — update
- `DELETE /tasks/{task}` — destroy

## Testing
```bash
php artisan test
# or
./vendor/bin/pest
```

## Notes
- All styling lives inline in `resources/views/layouts/app.blade.php` and is reused across task views.
- The home route redirects to the tasks index so the view always receives data from the controller.
