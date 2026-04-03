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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('name',100);
            $table->string('description',1024)->nullable();
            $table->boolean('on_sale')->default(false);
            $table->integer('lms_course_id')->nullable();
            $table->json('tags')->nullable();
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
        Schema::dropIfExists('courses');
    }
};
