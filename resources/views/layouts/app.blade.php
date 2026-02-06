<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Do It — Tasks</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<style>
		:root {
			--bg: #0f1629;
			--panel: #131a2c;
			--panel-2: #19223a;
			--primary: #4c8dff;
			--primary-2: #5dd5ff;
			--accent: #ffcc66;
			--text: #dbe4ff;
			--muted: #98a4c6;
			--danger: #ff7b7b;
			--success: #5be5a5;
			--shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
			--radius: 16px;
			--radius-sm: 12px;
		}

		* { box-sizing: border-box; }
		body {
			margin: 0;
			font-family: "Segoe UI", "Helvetica Neue", sans-serif;
			background: radial-gradient(120% 120% at 10% 20%, rgba(92, 68, 255, 0.12), transparent),
						radial-gradient(120% 120% at 80% 0%, rgba(0, 206, 255, 0.18), transparent),
						var(--bg);
			color: var(--text);
			min-height: 100vh;
			overflow-x: hidden;
		}

		a { color: inherit; text-decoration: none; }

		.shell {
			display: grid;
			grid-template-columns: 260px 1fr;
			min-height: 100vh;
		}

		.sidebar {
			background: linear-gradient(180deg, rgba(19, 26, 44, 0.95), rgba(19, 26, 44, 0.8));
			padding: 28px 22px;
			display: flex;
			flex-direction: column;
			gap: 24px;
			border-right: 1px solid rgba(255, 255, 255, 0.04);
		}

		.brand {
			font-size: 22px;
			font-weight: 700;
			letter-spacing: 0.04em;
		}

		.nav-group {
			display: flex;
			flex-direction: column;
			gap: 8px;
		}

		.nav-label {
			font-size: 12px;
			text-transform: uppercase;
			letter-spacing: 0.1em;
			color: var(--muted);
			margin-bottom: 4px;
		}

		.nav-link {
			display: flex;
			align-items: center;
			gap: 10px;
			padding: 12px 14px;
			border-radius: var(--radius-sm);
			color: var(--text);
			background: transparent;
			transition: background 0.15s ease, transform 0.1s ease;
			font-weight: 600;
		}

		.nav-link:hover { background: rgba(255, 255, 255, 0.06); transform: translateX(2px); }
		.nav-link.active { background: rgba(76, 141, 255, 0.16); color: #fff; }

		.nav-dot { width: 10px; height: 10px; border-radius: 50%; background: var(--primary); }

		.sidebar-footer {
			margin-top: auto;
			display: grid;
			gap: 8px;
			font-size: 13px;
			color: var(--muted);
		}

		.main {
			padding: 30px 32px 40px;
			background: linear-gradient(135deg, rgba(25, 34, 58, 0.9), rgba(15, 22, 41, 0.9));
		}

		.topbar {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-bottom: 24px;
		}

		.top-title { font-size: 26px; font-weight: 700; }

		.pill {
			background: rgba(255, 255, 255, 0.06);
			border: 1px solid rgba(255, 255, 255, 0.08);
			padding: 10px 14px;
			border-radius: 999px;
			color: var(--muted);
			display: inline-flex;
			gap: 8px;
			align-items: center;
			font-size: 13px;
		}

		.grid {
			display: grid;
			grid-template-columns: 2fr 1fr;
			gap: 16px;
		}

		.panel {
			background: var(--panel);
			border: 1px solid rgba(255, 255, 255, 0.05);
			border-radius: var(--radius);
			padding: 18px;
			box-shadow: var(--shadow);
		}

		.panel h3 { margin: 0 0 10px; font-size: 16px; letter-spacing: 0.01em; }
		.muted { color: var(--muted); font-size: 13px; }

		.tasks {
			display: grid;
			gap: 12px;
		}

		.task-card {
			background: var(--panel-2);
			border-radius: var(--radius-sm);
			padding: 14px;
			display: grid;
			gap: 6px;
			border: 1px solid rgba(255, 255, 255, 0.04);
			position: relative;
			overflow: hidden;
		}

		.task-card:before {
			content: "";
			position: absolute;
			inset: 0;
			background: linear-gradient(90deg, rgba(76, 141, 255, 0.08), transparent);
			opacity: 0;
			pointer-events: none;
			transition: opacity 0.2s ease;
		}

		.task-card:hover:before { opacity: 1; }

		.task-row {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 12px;
		}

		.status {
			padding: 6px 10px;
			border-radius: 999px;
			font-size: 12px;
			font-weight: 700;
			letter-spacing: 0.02em;
			text-transform: uppercase;
			color: #0f1629;
		}

		.status.pending { background: #ffd166; }
		.status.in_progress { background: #5dd5ff; }
		.status.completed { background: #5be5a5; }

		.badge { padding: 6px 10px; border-radius: 10px; background: rgba(255, 255, 255, 0.08); font-size: 12px; color: var(--muted); }
		.actions { display: flex; gap: 8px; flex-wrap: wrap; }

		.btn {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			padding: 10px 14px;
			border-radius: var(--radius-sm);
			border: 1px solid transparent;
			background: var(--primary);
			color: #0f1629;
			font-weight: 700;
			cursor: pointer;
			transition: transform 0.1s ease, box-shadow 0.1s ease;
			text-decoration: none;
		}

		.btn:hover { transform: translateY(-1px); box-shadow: 0 12px 30px rgba(76, 141, 255, 0.25); }
		.btn.secondary { background: transparent; border-color: rgba(255, 255, 255, 0.1); color: var(--text); }
		.btn.danger { background: transparent; border-color: rgba(255, 123, 123, 0.4); color: #ff9f9f; }
		.btn:focus-visible { outline: 2px solid var(--primary-2); outline-offset: 2px; }

		form.inline { display: inline; }

		.form {
			display: grid;
			gap: 14px;
		}

		.field { display: grid; gap: 6px; }
		.field label { font-size: 13px; color: var(--muted); }
		.field input, .field textarea, .field select {
			padding: 12px;
			border-radius: var(--radius-sm);
			border: 1px solid rgba(255, 255, 255, 0.08);
			background: rgba(255, 255, 255, 0.04);
			color: var(--text);
			resize: vertical;
		}

		.split { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; }

		.stat-card { display: grid; gap: 6px; padding: 16px; border-radius: var(--radius); background: var(--panel-2); border: 1px solid rgba(255, 255, 255, 0.05); }
		.stat-number { font-size: 28px; font-weight: 800; }

		.subtle-chart {
			height: 120px;
			background: linear-gradient(180deg, rgba(76, 141, 255, 0.16), transparent);
			border-radius: var(--radius);
			border: 1px dashed rgba(255, 255, 255, 0.08);
			display: grid;
			place-items: center;
			color: var(--muted);
			font-size: 13px;
		}

		.board { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 14px; }
		.column { background: var(--panel); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: var(--radius); padding: 14px; box-shadow: var(--shadow); display: grid; gap: 10px; }
		.column-header { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
		.column-title { font-weight: 700; letter-spacing: 0.01em; }
		.column-count { padding: 6px 10px; border-radius: 999px; background: rgba(255, 255, 255, 0.06); color: var(--muted); font-size: 12px; }
		.drop-zone { min-height: 80px; display: grid; gap: 10px; }
		.drop-zone.empty::before { content: "Drop tasks here"; color: var(--muted); font-size: 12px; border: 1px dashed rgba(255, 255, 255, 0.1); padding: 12px; border-radius: var(--radius-sm); text-align: center; }
		.drop-zone.drop-active { outline: 1px dashed var(--primary); outline-offset: 4px; }
		.kanban-card { cursor: grab; transition: transform 0.12s ease, box-shadow 0.12s ease, opacity 0.12s ease; }
		.kanban-card.dragging { opacity: 0.65; transform: scale(0.99); box-shadow: 0 16px 34px rgba(0, 0, 0, 0.4); }
		.softer { color: var(--muted); font-size: 12px; }

		@media (max-width: 980px) {
			.shell { grid-template-columns: 1fr; }
			.sidebar { flex-direction: row; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 2; }
			.nav-group { flex-direction: row; flex-wrap: wrap; }
			.main { padding: 24px; }
			.grid { grid-template-columns: 1fr; }
		}
	</style>
</head>
<body>
	<div class="shell">
		<aside class="sidebar">
			<div class="brand">DO IT.</div>
			<div class="nav-group">
				<div class="nav-label">Navigate</div>
				<a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
					<span class="nav-dot"></span>
					Dashboard
				</a>
				<a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}">
					<span class="nav-dot"></span>
					Tasks
				</a>
				<a href="{{ route('tasks.create') }}" class="nav-link {{ request()->routeIs('tasks.create') ? 'active' : '' }}">
					<span class="nav-dot"></span>
					New Task
				</a>
			</div>
			<div class="sidebar-footer">
				<span>Calm, focused, done.</span>
				<span class="pill">Made for productivity</span>
			</div>
		</aside>
		<main class="main">
			<div class="topbar">
				<div>
					<div class="top-title">Your Professional Task Manager.</div>
					<div class="muted">Stay on top of today and glide through the week.</div>
				</div>
				<span class="pill">Focus mode · 25:00</span>
			</div>
			@if ($message = session('success'))
				<div class="panel" style="margin-bottom: 14px; border-color: rgba(91, 229, 165, 0.4); background: rgba(91, 229, 165, 0.08); color: #d2ffe9;">
					{{ $message }}
				</div>
			@endif
			@yield('content')
		</main>
	</div>
</body>
</html>
