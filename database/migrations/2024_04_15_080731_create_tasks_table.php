<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leader_id')->constrained("users")->onDelete('cascade');
            $table->foreignId('user_id')->constrained("users")->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->timestamp('dead_line');
            $table->timestamp('completed_at')->nullable();
            $table->tinyInteger('schedule')->default(0)->comment('0 => None, 1 => Daily, 2 => Weekly, 3 => Monthly');
            $table->tinyInteger('priority')->default(0)->comment('0 => To do last, 1 => Normal, 2 => Important');
            $table->tinyInteger('status')->default(0)->comment('0 => To Do, 1 => In Progress, 2 => Done');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
