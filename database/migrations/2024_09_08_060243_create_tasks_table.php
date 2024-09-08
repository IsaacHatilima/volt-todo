<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id');
            $table->foreignId('user_id');
            $table->foreignId('todo_id');
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
