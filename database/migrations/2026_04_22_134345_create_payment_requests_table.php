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
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->cascadeOnUpdate();
            $table->decimal('amount',12,2);
            $table->enum('particular',['program']);
            $table->bigInteger('particular_id');
            $table->enum('status',['pending','completed','failed','expired']);
            //IDS
            $table->string('payment_intent_id')->nullable();
            $table->string('payment_method_id')->nullable();
            $table->string('payment_client_key')->nullable();
            //
            $table->json('payment_intent')->default([]);
            $table->json('payment_method')->default([]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_requests');
    }
};
