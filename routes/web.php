<?php

use App\Http\Controllers\TaskController;
use App\Models\Task;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::get('/dashboard', function () {
    $todayCount = Task::whereDate('created_at', now()->toDateString())->count();
    $monthCount = Task::whereYear('created_at', now()->year)
        ->whereMonth('created_at', now()->month)
        ->count();
    $yearCount = Task::whereYear('created_at', now()->year)->count();

    $statusCounts = Task::selectRaw('status, count(*) as count')
        ->groupBy('status')
        ->pluck('count', 'status');

    $perMonthRaw = Task::selectRaw('MONTH(created_at) as m, count(*) as c')
        ->whereYear('created_at', now()->year)
        ->groupBy('m')
        ->pluck('c', 'm');

    $perMonth = [];
    for ($i = 1; $i <= 12; $i++) {
        $perMonth[] = $perMonthRaw[$i] ?? 0;
    }

    return view('dashboard', [
        'todayCount' => $todayCount,
        'monthCount' => $monthCount,
        'yearCount' => $yearCount,
        'statusCounts' => $statusCounts,
        'perMonth' => $perMonth,
    ]);
})->name('dashboard');

Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');
Route::resource('tasks', TaskController::class);
