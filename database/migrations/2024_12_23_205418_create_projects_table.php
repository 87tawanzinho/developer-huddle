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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('project_type', ['programming', 'design', 'engineering']);
            $table->enum('structure', ['scrum', 'kanbam']);
            $table->text('description');
            $table->boolean('is_private')->default(false);
            $table->string('cover_path');
            $table->timestamp('start_date')->nullable()->default(null);
            // Syntax error or access violation: 1067 Invalid default value
            $table->timestamp('end_date')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
