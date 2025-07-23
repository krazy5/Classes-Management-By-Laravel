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
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id');
            $table->string('day_of_week'); // e.g., 'Monday', 'Tuesday'
            $table->time('start_time');
            $table->time('end_time');
            $table->string('subject')->nullable();
            $table->string('teacher_name')->nullable(); // or future FK to teachers table
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
