@extends('layouts.app')

@section('content')
<div class="task-row" style="margin-bottom: 16px; align-items: flex-start;">
	<div>
		<h3 style="margin:0;">Kanban Board</h3>
		<div class="muted">Drag and drop tasks between columns. Actions remain available on each card.</div>
	</div>
	<div class="actions">
		<a class="btn" href="{{ route('tasks.create') }}">Add Task</a>
	</div>
</div>

@php
	$columns = [
		['title' => 'Backlog', 'status' => 'pending'],
		['title' => 'In Progress', 'status' => 'in_progress'],
		['title' => 'Done', 'status' => 'completed'],
	];
@endphp

<div class="board" id="kanban-board">
	@foreach ($columns as $column)
		<section class="column" data-status="{{ $column['status'] }}">
			<div class="column-header">
				<div class="column-title">{{ $column['title'] }}</div>
				<span class="column-count">{{ $tasks->where('status', $column['status'])->count() }}</span>
			</div>
			<div class="drop-zone {{ $tasks->where('status', $column['status'])->isEmpty() ? 'empty' : '' }}" data-drop-zone data-status="{{ $column['status'] }}">
				@foreach ($tasks->where('status', $column['status']) as $task)
					<article class="task-card kanban-card" draggable="true" data-task-id="{{ $task->id }}" data-status="{{ $task->status }}">
						<div class="task-row">
							<div>
								<div style="font-weight: 700;">{{ $task->title }}</div>
								<div class="muted">{{ $task->description ?: 'No description yet.' }}</div>
							</div>
							<span class="status {{ $task->status }}">{{ str_replace('_', ' ', $task->status) }}</span>
						</div>
						<div class="task-row">
							<div class="softer">Due {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'Flexible' }}</div>
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
					</article>
				@endforeach
			</div>
		</section>
	@endforeach
</div>

<script>
(() => {
	const statusRoute = (id) => "{{ route('tasks.status', ':id') }}".replace(':id', id);
	const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
	const zones = document.querySelectorAll('[data-drop-zone]');
	const cards = document.querySelectorAll('.kanban-card');

	let draggingCard = null;

	cards.forEach((card) => {
		card.addEventListener('dragstart', (e) => {
			draggingCard = card;
			card.classList.add('dragging');
			e.dataTransfer.effectAllowed = 'move';
			e.dataTransfer.setData('text/plain', card.dataset.taskId);
		});

		card.addEventListener('dragend', () => {
			card.classList.remove('dragging');
			draggingCard = null;
		});
	});

	zones.forEach((zone) => {
		zone.addEventListener('dragover', (e) => {
			e.preventDefault();
			zone.classList.add('drop-active');
		});

		zone.addEventListener('dragleave', () => {
			zone.classList.remove('drop-active');
		});

		zone.addEventListener('drop', (e) => {
			e.preventDefault();
			zone.classList.remove('drop-active');

			const id = e.dataTransfer.getData('text/plain') || draggingCard?.dataset.taskId;
			const card = document.querySelector(`[data-task-id="${id}"]`);
			if (!card) return;

			const targetStatus = zone.dataset.status;
			const previousZone = card.parentElement;
			const previousStatus = card.dataset.status;

			if (targetStatus === previousStatus) {
				zone.appendChild(card);
				refreshEmpty();
				return;
			}

			zone.appendChild(card);
			card.dataset.status = targetStatus;
			syncStatusBadge(card, targetStatus);
			refreshEmpty();

			updateStatus(id, targetStatus).catch(() => {
				previousZone.appendChild(card);
				card.dataset.status = previousStatus;
				syncStatusBadge(card, previousStatus);
				refreshEmpty();
				alert('Could not update status. Please try again.');
			});
		});
	});

	function refreshEmpty() {
		zones.forEach((z) => z.classList.toggle('empty', !z.querySelector('.kanban-card')));
		updateCounts();
	}

	function updateCounts() {
		document.querySelectorAll('.column').forEach((col) => {
			const status = col.dataset.status;
			const countEl = col.querySelector('.column-count');
			if (countEl) {
				countEl.textContent = document.querySelectorAll(`.kanban-card[data-status="${status}"]`).length;
			}
		});
	}

	function syncStatusBadge(card, status) {
		const badge = card.querySelector('.status');
		if (!badge) return;
		badge.className = `status ${status}`;
		badge.textContent = status.replace(/_/g, ' ');
	}

	async function updateStatus(id, status) {
		const res = await fetch(statusRoute(id), {
			method: 'PATCH',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': token,
				'Accept': 'application/json',
			},
			body: JSON.stringify({ status }),
		});

		if (!res.ok) throw new Error('Request failed');
		const data = await res.json();
		if (!data.success) throw new Error('Update failed');
	}

	refreshEmpty();
})();
</script>
@endsection
