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
         Schema::create('admin', function (Blueprint $table) {
        $table->id('admin_id');
        $table->string('full_name');
        $table->string('contact')->nullable();
        $table->string('email')->unique();
        $table->string('user_name')->unique();
        $table->string('password');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
