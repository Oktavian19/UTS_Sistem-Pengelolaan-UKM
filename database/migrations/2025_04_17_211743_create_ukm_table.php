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
        Schema::create('ukm', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->text('description');
            $table->foreignId('category')
                  ->constrained('category')
                  ->onDelete('cascade');
            $table->string('email', 100);
            $table->string('phone', 20);
            $table->string('website', 255)->nullable();
            $table->string('logo_path', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')
                  ->constrained('admins')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ukm');
    }
};
