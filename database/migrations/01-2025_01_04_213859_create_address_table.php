<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->string('street');
            $table->smallInteger('number')->unsigned();
            $table->string('complement')->nullable();
            $table->string('neighborhood');
            $table->string('city');
            $table->string('state');
            $table->char('country', 3);
            $table->char('zipcode', 10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('address');
    }
};
