<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Category;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Lookup Tables
        Priority::insert([
            ['id' => 1, 'name' => 'Low'],
            ['id' => 2, 'name' => 'Medium'],
            ['id' => 3, 'name' => 'High'],
        ]);

        Status::insert([
            ['id' => 1, 'name' => 'Pending'],
            ['id' => 2, 'name' => 'Completed'],
        ]);

        Category::insert([
            ['id' => 1, 'name' => 'Work', 'color' => 'indigo', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Personal', 'color' => 'rose', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Study', 'color' => 'amber', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Health', 'color' => 'emerald', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Errands', 'color' => 'cyan', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. Seed Initial Tasks
        Task::insert([
            ['id' => 1, 'title' => 'Finish Q3 Financial Report', 'description' => 'Compile all department expenses and revenue projections for the board meeting.', 'category_id' => 1, 'due_date' => '2026-05-29', 'priority_id' => 3, 'status_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'title' => 'Pick up groceries', 'description' => 'Milk, eggs, bread, and coffee beans.', 'category_id' => 5, 'due_date' => '2026-05-31', 'priority_id' => 2, 'status_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'title' => 'Read Chapter 4 of "Clean Code"', 'description' => '', 'category_id' => 3, 'due_date' => '2026-06-01', 'priority_id' => 1, 'status_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'title' => 'Morning Run (5km)', 'description' => 'Try to keep pace under 5:30/km.', 'category_id' => 4, 'due_date' => '2026-05-31', 'priority_id' => 3, 'status_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'title' => 'Call Mom for her birthday', 'description' => '', 'category_id' => 2, 'due_date' => '2026-06-03', 'priority_id' => 3, 'status_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'title' => 'Update Laravel dependencies', 'description' => 'Run composer update and check for breaking changes in the new major release.', 'category_id' => 1, 'due_date' => '2026-05-26', 'priority_id' => 2, 'status_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
