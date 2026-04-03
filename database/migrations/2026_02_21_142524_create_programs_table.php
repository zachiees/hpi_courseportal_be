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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('on_sale')->default(false);
            $table->enum('pricing_type',['total','custom'])->default('custom');
            $table->decimal('price',12,2)->default(0);
            $table->decimal('price_sale',12,2)->default(0);
            $table->decimal('price_computed',12,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
