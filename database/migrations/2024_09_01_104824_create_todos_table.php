<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id');
            $table->string('name');
            $table->foreignId('user_id');
            $table->enum('status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
