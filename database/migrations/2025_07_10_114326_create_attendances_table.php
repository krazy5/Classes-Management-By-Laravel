<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->date('date');
            $table->enum('status', ['Present', 'Absent', 'Leave']);
            $table->text('remark')->nullable(); // If not present, add via migration

            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('student_records')->onDelete('cascade');
            $table->unique(['student_id', 'date']); // Prevent duplicate attendance entries
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
    
