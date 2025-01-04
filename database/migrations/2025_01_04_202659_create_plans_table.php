<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->enum('type', ['free', 'basic', 'premium', 'enterprise']);
            $table->integer('count_projects');
            $table->integer('count_users_project');
            $table->integer('count_admin_project');
            #TODO: adicionar IA para auxiliar em futuras tarefas dos projetos
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
