<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description')->nullable();
        $table->foreignId('category_id')->constrained()->cascadeOnDelete();
        $table->date('due_date');
        $table->foreignId('priority_id')->default(2)->constrained('priorities')->cascadeOnDelete();
        $table->foreignId('status_id')->default(1)->constrained('statuses')->cascadeOnDelete();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
