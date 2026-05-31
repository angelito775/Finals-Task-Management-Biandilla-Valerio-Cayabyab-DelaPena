@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('tasks.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors mb-6">
            &larr; Back to tasks
        </a>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-100">
                <h2 class="text-xl font-semibold text-slate-900">Edit Task</h2>
                <p class="text-slate-500 text-sm mt-1">Update the details of your task.</p>
            </div>

            <form action="{{ route('tasks.update', $task) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-slate-700 mb-1.5">Task Title *</label>
                        <input id="title" name="title" value="{{ old('title', $task->title) }}" placeholder="What needs to be done?" class="w-full px-3 py-2.5 rounded-lg border {{ $errors->has('title') ? 'border-red-300 focus:ring-red-500' : 'border-slate-300 focus:ring-indigo-500' }} focus:ring-2 focus:border-transparent outline-none transition-shadow" />
                        @error('title')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Description <span class="text-slate-400 font-normal">(Optional)</span></label>
                        <textarea id="description" name="description" rows="3" placeholder="Add any extra details or notes here..." class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-shadow resize-none">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1.5">Category *</label>
                        <select id="category_id" name="category_id" class="w-full px-3 py-2.5 rounded-lg border {{ $errors->has('category_id') ? 'border-red-300 focus:ring-red-500' : 'border-slate-300 focus:ring-indigo-500' }} focus:ring-2 focus:border-transparent outline-none transition-shadow bg-white">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $task->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="priority_id" class="block text-sm font-medium text-slate-700 mb-1.5">Priority</label>
                        <select id="priority_id" name="priority_id" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-shadow bg-white">
                            @foreach($priorities as $priority)
                                <option value="{{ $priority->id }}" {{ old('priority_id', $task->priority_id) == $priority->id ? 'selected' : '' }}>{{ $priority->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="due_date" class="block text-sm font-medium text-slate-700 mb-1.5">Due Date *</label>
                        <input id="due_date" type="date" name="due_date" value="{{ old('due_date', $task->due_date->toDateString()) }}" class="w-full px-3 py-2.5 rounded-lg border {{ $errors->has('due_date') ? 'border-red-300 focus:ring-red-500' : 'border-slate-300 focus:ring-indigo-500' }} focus:ring-2 focus:border-transparent outline-none transition-shadow" />
                        @error('due_date')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('tasks.index') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-primary min-w-[140px]">Update Task</button>
                </div>
            </form>
        </div>
    </div>
@endsection
