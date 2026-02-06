@extends('layouts.app')

@section('content')
<div class="task-row" style="margin-bottom: 16px; align-items: flex-start;">
	<div>
		<h3 style="margin:0;">Overview</h3>
		<div class="muted">Yearly, monthly, and daily pulse with status breakdown.</div>
	</div>
	<div class="actions">
		<a class="btn" href="{{ route('tasks.create') }}">Add Task</a>
	</div>
</div>

<div class="grid" style="margin-bottom: 16px;">
	<div class="panel">
		<div class="split">
			<div class="stat-card">
				<div class="muted">Today</div>
				<div class="stat-number">{{ $todayCount }}</div>
				<div class="softer">Created today</div>
			</div>
			<div class="stat-card">
				<div class="muted">This Month</div>
				<div class="stat-number">{{ $monthCount }}</div>
				<div class="softer">Created in {{ now()->format('F') }}</div>
			</div>
			<div class="stat-card">
				<div class="muted">This Year</div>
				<div class="stat-number">{{ $yearCount }}</div>
				<div class="softer">Created in {{ now()->year }}</div>
			</div>
		</div>
	</div>
	<div class="panel">
		<div class="task-row" style="margin-bottom: 8px;">
			<h3 style="margin:0;">Status Mix</h3>
			<div class="muted">Distribution across workflow</div>
		</div>
		<div style="display:flex; gap:8px; flex-wrap: wrap;">
			<span class="badge">Pending: {{ $statusCounts['pending'] ?? 0 }}</span>
			<span class="badge">In Progress: {{ $statusCounts['in_progress'] ?? 0 }}</span>
			<span class="badge">Completed: {{ $statusCounts['completed'] ?? 0 }}</span>
		</div>
	</div>
</div>

<div class="panel">
	<div class="task-row" style="margin-bottom: 10px;">
		<h3 style="margin:0;">This Year</h3>
		<div class="muted">Tasks created per month</div>
	</div>
	<canvas id="perMonthChart" height="120"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js" crossorigin="anonymous"></script>
<script>
(() => {
	const ctx = document.getElementById('perMonthChart');
	if (!ctx) return;
	const data = @json($perMonth);
	const chart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
			datasets: [{
				label: 'Tasks',
				data,
				borderColor: '#4c8dff',
				backgroundColor: 'rgba(76, 141, 255, 0.18)',
				tension: 0.32,
				fill: true,
				borderWidth: 2,
				pointRadius: 4,
				pointBackgroundColor: '#5dd5ff',
			}]
		},
		options: {
			plugins: { legend: { display: false } },
			scales: {
				y: { beginAtZero: true, ticks: { precision:0, color: '#98a4c6' }, grid: { color: 'rgba(255,255,255,0.06)' } },
				x: { ticks: { color: '#98a4c6' }, grid: { color: 'rgba(255,255,255,0.04)' } },
			},
		}
	});
})();
</script>
@endsection
