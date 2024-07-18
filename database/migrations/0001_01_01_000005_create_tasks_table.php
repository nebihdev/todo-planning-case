<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('estimated_duration')->comment('İşin süreceği tahmini süre');
            $table->unsignedInteger('difficulty_level')->comment('İşin zorluk seviyesi');
            $table->foreignId('sprint_id')->nullable()->constrained('sprints');
            $table->foreignId('assigned_developer_id')->nullable()->constrained('developers');
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
