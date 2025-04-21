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
        Schema::create('ukm_admin', function (Blueprint $table) {
            $table->id('nim');
            $table->string('name', 100);
            $table->string('password_hash', 255);
            $table->string('phone', 20);
            $table->string('email', 100);
            $table->foreignId('ukm_id')
                  ->constrained('ukm')
                  ->onDelete('cascade');
            $table->string('photo')->default('photos/default.jpg');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ukm_admin');
    }
};
