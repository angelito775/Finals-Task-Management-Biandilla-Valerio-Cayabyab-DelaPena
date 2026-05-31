@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900">My Tasks</h2>
                <p class="text-slate-500 mt-1">Stay organized and focused on what matters.</p>
            </div>
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center justify-center gap-2 bg-indigo-600 text-white px-4 py-2.5 rounded-lg font-medium shadow-sm hover:bg-indigo-700 transition-colors sm:w-auto w-full">
                + New Task
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg flex items-center justify-between shadow-sm">
                <p class="text-sm font-medium">{{ session('success') }}</p>
                <a href="{{ route('tasks.index') }}" class="text-emerald-600 hover:text-emerald-800">Dismiss</a>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="bg-slate-100 p-3 rounded-lg text-slate-600">
                    <span class="text-xl font-semibold">{{ $tasks->count() }}</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Tasks</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="bg-amber-50 p-3 rounded-lg text-amber-600">
                    <span class="text-xl font-semibold">{{ $pendingTasks->count() }}</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Pending</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="bg-emerald-50 p-3 rounded-lg text-emerald-600">
                    <span class="text-xl font-semibold">{{ $completedTasks->count() }}</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Completed</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="bg-red-50 p-3 rounded-lg text-red-600">
                    <span class="text-xl font-semibold">{{ $overdueCount }}</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Overdue</p>
                    @if($overdueCount > 0)
                        <p class="text-xs text-red-500 font-medium">Needs attention</p>
                    @endif
                </div>
            </div>
        </div>

        @if($tasks->isEmpty())
            <div class="bg-white rounded-xl border border-slate-200 p-12 text-center shadow-sm">
                <p class="text-slate-500">No tasks match your filters. Try adjusting your search or dropdowns.</p>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-200">
                        <span class="text-amber-500">⏰</span>
                        <h3 class="font-semibold text-slate-900">Pending</h3>
                        <span class="bg-amber-100 text-amber-700 py-0.5 px-2 rounded-full text-xs font-medium ml-2">{{ $pendingTasks->count() }}</span>
                    </div>
                    <div class="space-y-3">
                        @forelse($pendingTasks as $task)
                            @include('tasks._card', ['task' => $task])
                        @empty
                            <div class="p-8 text-center border-2 border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                                <p class="text-slate-500 font-medium">All caught up! 🎉</p>
                                <p class="text-sm text-slate-400 mt-1">No pending tasks match your criteria.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-200">
                        <span class="text-emerald-500">✔️</span>
                        <h3 class="font-semibold text-slate-900">Completed</h3>
                        <span class="bg-emerald-100 text-emerald-700 py-0.5 px-2 rounded-full text-xs font-medium ml-2">{{ $completedTasks->count() }}</span>
                    </div>
                    <div class="space-y-3">
                        @forelse($completedTasks as $task)
                            @include('tasks._card', ['task' => $task])
                        @empty
                            <div class="p-8 text-center border-2 border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                                <p class="text-slate-400 text-sm">Completed tasks will appear here.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection