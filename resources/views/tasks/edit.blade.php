@extends('layouts.app')

@section('content')
<div class="panel" style="max-width: 900px; margin: 0 auto;">
	<div class="task-row" style="margin-bottom: 16px;">
		<div>
			<h3 style="margin:0;">Edit Task</h3>
			<div class="muted">Refine the details and keep momentum.</div>
		</div>
		<a class="btn secondary" href="{{ route('tasks.index') }}">Back</a>
	</div>
	@if ($errors->any())
		<div class="panel" style="background: rgba(255, 123, 123, 0.08); border-color: rgba(255, 123, 123, 0.4); color: #ffd7d7; margin-bottom: 12px;">
			<div style="font-weight:700; margin-bottom:6px;">Please fix the following:</div>
			<ul style="margin:0; padding-left:18px; color:inherit;">
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<form class="form" action="{{ route('tasks.update', $task) }}" method="POST">
		@csrf
		@method('PUT')
		<div class="field">
			<label for="title">Title</label>
			<input id="title" name="title" value="{{ old('title', $task->title) }}" required>
		</div>
		<div class="field">
			<label for="description">Description</label>
			<textarea id="description" name="description" rows="3">{{ old('description', $task->description) }}</textarea>
		</div>
		<div class="split">
			<div class="field">
				<label for="status">Status</label>
				<select id="status" name="status" required>
					<option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>Pending</option>
					<option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
					<option value="completed" {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}>Completed</option>
				</select>
			</div>
			<div class="field">
				<label for="due_date">Due Date</label>
				<input id="due_date" type="date" name="due_date" value="{{ old('due_date', $task->due_date ? \\Carbon\\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}">
			</div>
		</div>
		<div class="actions" style="justify-content:flex-end;">
			<button class="btn" type="submit">Update Task</button>
		</div>
	</form>
</div>
@endsection
