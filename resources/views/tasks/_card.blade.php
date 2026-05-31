@php
    $isCompleted = $task->status_id === 2; // Assuming status_id 2 is 'Completed'
    $isOverdue = ! $isCompleted && $task->due_date->isPast();
    $dueText = $task->due_date->isToday()
        ? 'Due today'
        : ($task->due_date->isTomorrow() ? 'Due tomorrow' : ($isOverdue ? 'Overdue · ' . $task->due_date->diffInDays(now()) . 'd ago' : 'Due ' . $task->due_date->format('M j')));

    $priorityStyles = 'bg-slate-100 text-slate-600 border-slate-200';
    if ($task->priority && $task->priority->name === 'High') {
        $priorityStyles = $isCompleted ? 'bg-slate-50 text-slate-400 border-slate-100' : 'bg-red-50 text-red-700 border-red-200';
    } elseif ($task->priority && $task->priority->name === 'Medium') {
        $priorityStyles = $isCompleted ? 'bg-slate-50 text-slate-400 border-slate-100' : 'bg-amber-50 text-amber-700 border-amber-200';
    }

    $dueStyles = 'bg-slate-100 text-slate-600 border-slate-200';
    if ($isCompleted) {
        $dueStyles = 'bg-slate-50 text-slate-400 border-slate-100';
    } elseif ($isOverdue) {
        $dueStyles = 'bg-red-50 text-red-700 border-red-200 font-medium';
    } elseif ($task->due_date->isToday() || $task->due_date->isTomorrow()) {
        $dueStyles = 'bg-amber-50 text-amber-700 border-amber-200 font-medium';
    }

    $categoryStyles = 'bg-slate-100 text-slate-700 border-slate-200';
    if ($task->category) {
        $categoryStyles = match ($task->category->color) {
            'indigo' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            'rose' => 'bg-rose-50 text-rose-700 border-rose-200',
            'amber' => 'bg-amber-50 text-amber-700 border-amber-200',
            'emerald' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'cyan' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
            default => 'bg-slate-100 text-slate-700 border-slate-200',
        };
    }
@endphp

<div class="group relative bg-white rounded-xl border shadow-sm p-4 transition-all hover:shadow-md hover:border-slate-300 flex gap-4 {{ $isOverdue ? 'border-l-4 border-l-red-500' : 'border-slate-200' }} {{ $isCompleted ? 'opacity-75' : 'opacity-100' }}">
    <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="shrink-0">
        @csrf
        @method('PATCH')
        <button type="submit" class="mt-0.5 shrink-0 w-6 h-6 rounded-full border-2 flex items-center justify-center transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ $isCompleted ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300 hover:border-indigo-400 bg-transparent' }}">
            @if($isCompleted)
                <span class="text-[10px] font-bold">✔</span>
            @endif
        </button>
    </form>

    <div class="flex-1 min-w-0">
        <h3 class="text-base font-medium truncate transition-colors {{ $isCompleted ? 'text-slate-400 line-through' : 'text-slate-900' }}">{{ $task->title }}</h3>
        @if($task->description)
            <p class="mt-1 text-sm {{ $isCompleted ? 'text-slate-400' : 'text-slate-500' }}">{{ $task->description }}</p>
        @endif

        <div class="mt-3 flex flex-wrap gap-2">
            @if($task->category)
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-xs font-medium border {{ $isCompleted ? 'bg-slate-50 text-slate-400 border-slate-100' : $categoryStyles }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $isCompleted ? 'bg-slate-300' : 'bg-current' }}"></span>
                    {{ $task->category->name }}
                </span>
            @endif
            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs border {{ $dueStyles }}">{{ $dueText }}</span>
            @if($task->priority)
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs border {{ $priorityStyles }}">{{ $task->priority->name }}</span>
            @endif
        </div>
    </div>

    <div class="shrink-0 opacity-0 group-hover:opacity-100 focus-within:opacity-100 transition-opacity flex items-center gap-1">
        <a href="{{ route('tasks.edit', $task) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500" title="Edit Task">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.25V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
        </a>

        <form action="{{ route('tasks.destroy', $task) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-red-500" title="Delete Task">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </button>
        </form>
    </div>
</div>