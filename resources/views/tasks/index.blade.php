@extends('layouts.app')

@section('content')
<div class="grid" style="margin-bottom: 18px;">
	<div class="panel">
		<div class="task-row" style="margin-bottom: 12px;">
			<h3>Today</h3>
			<div class="actions">
				<a class="btn" href="{{ route('tasks.create') }}">Add Task</a>
			</div>
		</div>
		<div class="tasks">
			@forelse($tasks as $task)
				<div class="task-card">
					<div class="task-row">
						<div>
							<div style="font-weight: 700;">{{ $task->title }}</div>
							<div class="muted">{{ $task->description ?: 'No description yet.' }}</div>
						</div>
						<span class="status {{ $task->status }}">{{ str_replace('_', ' ', $task->status) }}</span>
					</div>
					<div class="task-row">
						<div class="muted">Due {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'Flexible' }}</div>
						<div class="actions">
							<a class="btn secondary" href="{{ route('tasks.show', $task) }}">View</a>
							<a class="btn secondary" href="{{ route('tasks.edit', $task) }}">Edit</a>
							<form class="inline" action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?');">
								@csrf
								@method('DELETE')
								<button class="btn danger" type="submit">Delete</button>
							</form>
						</div>
					</div>
				</div>
			@empty
				<div class="muted">Nothing scheduled yet. Add your first task.</div>
			@endforelse
		</div>
	</div>
	<div class="panel">
		<h3>Upcoming</h3>
		<div class="muted" style="margin-bottom: 14px;">Stay aware of the week at a glance.</div>
		<div style="display: grid; gap: 12px;">
			<div class="badge">{{ now()->format('F Y') }}</div>
			<div class="subtle-chart">Calendar placeholder</div>
			<div class="stat-card">
				<div class="muted">Completed</div>
				<div class="stat-number">{{ $tasks->where('status', 'completed')->count() }}</div>
			</div>
			<div class="stat-card">
				<div class="muted">In Progress</div>
				<div class="stat-number">{{ $tasks->where('status', 'in_progress')->count() }}</div>
			</div>
		</div>
	</div>
</div>
@endsection
