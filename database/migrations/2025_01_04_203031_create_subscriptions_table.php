<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->string('gateway_id')->comment('ID returned by the payment gateway');
            $table->enum('status', ['active', 'inactive', 'canceled']);
            $table->timestamps();
            $table->timestamp('canceled_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
