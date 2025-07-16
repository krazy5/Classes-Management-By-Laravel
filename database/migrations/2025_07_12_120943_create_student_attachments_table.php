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
        Schema::create('student_attachments', function (Blueprint $table) {
            $table->id();
        $table->unsignedBigInteger('student_id');
        $table->string('file_path');
        $table->string('file_type')->nullable(); // 'pdf', 'jpg', etc.
        $table->string('original_name')->nullable(); // original uploaded filename
        $table->timestamps();

        $table->foreign('student_id')->references('id')->on('student_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attachments');
    }
};
