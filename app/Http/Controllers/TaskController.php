<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Models\Priority;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['category', 'priority', 'status']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('priority')) {
            $query->whereHas('priority', function($q) use ($request) {
                $q->where('name', $request->priority);
            });
        }

        if ($request->filled('sort')) {
            if ($request->sort === 'due_date') {
                $query->orderBy('due_date', 'asc');
            } elseif ($request->sort === 'priority') {
                $query->orderBy('priority_id', 'desc'); 
            } elseif ($request->sort === 'created_at') {
                $query->latest();
            }
        } else {
            $query->orderBy('due_date', 'asc');
        }

        $allTasks = $query->get();

        $pendingTasks = $allTasks->where('status_id', 1);
        $completedTasks = $allTasks->where('status_id', 2);

        $overdueCount = $pendingTasks->filter(function($task) {
            return $task->due_date->isPast() && !$task->due_date->isToday();
        })->count();

        return view('tasks.index', [
            'tasks' => $allTasks,
            'pendingTasks' => $pendingTasks,
            'completedTasks' => $completedTasks,
            'categories' => Category::all(),
            'totalTasks' => $allTasks->count(),
            'overdueCount' => $overdueCount
        ]);
    }

    public function create()
    {
        return view('tasks.create', [
            'categories' => Category::all(),
            'priorities' => Priority::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'priority_id' => 'required|exists:priorities,id',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $validated['status_id'] = 1; 

        Task::create($validated);
        
        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', [
            'task' => $task,
            'categories' => Category::all(),
            'priorities' => Priority::all()
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'priority_id' => 'required|exists:priorities,id',
            'due_date' => 'required|date',
        ]);

        $task->update($validated);
        
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function toggle(Task $task)
    {
        $task->update([
            'status_id' => $task->status_id === 1 ? 2 : 1
        ]);
        
        return back()->with('success', 'Task status updated!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return back()->with('success', 'Task deleted permanently.');
    }
}