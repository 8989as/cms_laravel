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
            $table->json('name')->nullable(false); 
            $table->string('url')->nullable(); 
            $table->string('key')->unique()->nullable(false); 
            $table->json('description')->nullable(); 
            $table->string('icon')->nullable(); 
            $table->integer('pages_number')->default(0); 
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
