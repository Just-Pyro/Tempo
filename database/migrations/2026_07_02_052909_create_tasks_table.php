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
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->text('details');
            $table->time('etc');
            $table->time('atc');
            $table->dateTime('date_schedule')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'missed', 'archived']);
            $table->dateTime('archived_date')->nullable();
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
