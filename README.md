# Do It — Laravel Task Manager 🗂️

A modern **task management dashboard** built with **Laravel + Blade**, featuring kanban workflow, analytics, and an inline-styled dark UI. Ideal as a portfolio piece, internal tool, or SaaS starter.

---

## ✨ Features

- Full task lifecycle (create, view, edit, delete)
- Statuses: `pending`, `in_progress`, `completed`
- Drag-and-drop kanban board with AJAX status updates
- Dashboard analytics: yearly/monthly/daily counts + Chart.js monthly trend
- Friendly due dates, flash success messages, validation errors
- Inline dark UI styling (no external CSS required)
- Summary cards and status distribution

---

## 🧠 Tech Stack

| Layer | Technology |
|------|------------|
| Backend | PHP 8.2+, Laravel 12 |
| Frontend | Blade (inline CSS) |
| Charts | Chart.js (CDN) |
| Build | Vite + npm |
| Testing | Pest / PHPUnit |
| Database | MySQL / SQLite / PostgreSQL |

---

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+ (for optional asset build)
- A SQL database (MySQL/PostgreSQL/SQLite)

### Setup
```bash
git clone https://github.com/youssefyouyoudev/todoapp todoapp
cd todoapp

composer install
cp .env.example .env
php artisan key:generate

# Configure DB in .env then migrate
php artisan migrate

# (Optional) build assets
npm install
npm run build

# Run the app
php artisan serve
```

Visit http://localhost:8000 — root redirects to `/tasks`. Dashboard lives at `/dashboard`.

---

## 🧭 Usage
- Kanban: drag cards between columns to update status via AJAX.
- Dashboard: view year/month/day totals and a monthly Chart.js line graph.
- Tasks: create/edit with title, description, status, and due date.

---

## 🔗 Key Routes
- `/tasks` — list/kanban
- `/tasks/create` — new task
- `/tasks/{task}` — detail
- `/tasks/{task}/edit` — edit
- `/tasks/{task}` (DELETE) — delete
- `/tasks/{task}/status` (PATCH) — AJAX status update
- `/dashboard` — analytics

---

## 🧪 Testing
```bash
php artisan test
# or
./vendor/bin/pest
```

---

## 📸 Screenshots

Place captures in `screenshots/` for GitHub rendering:

```text
/screenshots
  ├── dashboard.png
  ├── kanban.png
  └── create-task.png
