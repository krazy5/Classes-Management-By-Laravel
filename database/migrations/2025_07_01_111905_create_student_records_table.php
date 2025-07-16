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
         Schema::create('student_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id')->nullable(); // ✅ Corrected line

            $table->string('photo', 200)->nullable();
            $table->string('student_id', 200)->unique();
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('roll_no', 200)->nullable();
            $table->string('parent_name', 200)->nullable();
            $table->date('dob')->nullable();
            $table->string('mobile_no', 200)->nullable();
            $table->string('gender', 200)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('batch_name', 200)->nullable();
            $table->date('start_date')->nullable();
            $table->string('class_subject', 200)->nullable();
            $table->string('school_college', 200)->nullable();
            $table->string('attachment', 200)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('std', 100)->nullable();
            $table->string('reciept_no', 200)->nullable();
            $table->string('password', 200)->nullable();
            
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('set null');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_records');
    }
};
