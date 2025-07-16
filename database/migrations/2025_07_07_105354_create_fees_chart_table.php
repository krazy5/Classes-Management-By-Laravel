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
        Schema::create('fees_chart', function (Blueprint $table) {
             $table->id(); // Default primary key
            $table->string('board_exam', 50)->nullable();
            $table->string('std', 50)->nullable();
            $table->string('course_name', 100)->nullable(); // Newly added field
            $table->string('subject', 100)->nullable();
            $table->double('yearly_fees')->nullable();
            $table->double('monthly_fees')->nullable();
            $table->string('remarks', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees_chart');
    }
};
