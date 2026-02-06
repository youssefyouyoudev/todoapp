@extends('layouts.app')

@section('content')
<div class="panel" style="max-width: 900px; margin: 0 auto;">
	<div class="task-row" style="margin-bottom: 16px;">
		<div>
			<h3 style="margin:0;">Task Detail</h3>
			<div class="muted">A focused snapshot of this task.</div>
		</div>
		<div class="actions">
			<a class="btn secondary" href="{{ route('tasks.index') }}">Back</a>
			<a class="btn secondary" href="{{ route('tasks.edit', $task) }}">Edit</a>
		</div>
	</div>
	<div class="task-card" style="padding:18px;">
		<div class="task-row">
			<div>
				<div style="font-size:20px;font-weight:800;">{{ $task->title }}</div>
				<div class="muted">{{ $task->description ?: 'No description yet.' }}</div>
			</div>
			<span class="status {{ $task->status }}">{{ str_replace('_', ' ', $task->status) }}</span>
		</div>
		<div class="task-row" style="margin-top: 12px;">
			<div class="badge">Due {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'Flexible' }}</div>
			<div class="muted">Created {{ $task->created_at->format('M d, Y h:i A') }}</div>
		</div>
	</div>
</div>
@endsection
