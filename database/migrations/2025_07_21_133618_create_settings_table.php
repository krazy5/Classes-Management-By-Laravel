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
        Schema::create('settings', function (Blueprint $table) {
            
            $table->id();
           $table->string('institute_name')->nullable();
        $table->string('institute_address')->nullable();
        $table->string('institute_email')->nullable();
        $table->string('institute_phone')->nullable();
        $table->string('institute_logo')->nullable(); // store filename only
            $table->timestamps();
   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
