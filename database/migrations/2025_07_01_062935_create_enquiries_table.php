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
                        Schema::create('enquiries', function (Blueprint $table) {
                            $table->id();
                            $table->string('full_name');
                            $table->string('contact_number', 15);
                            $table->string('email')->nullable();
                            $table->string('location')->nullable();
                            $table->string('course_interested');
                            $table->decimal('fees_offered', 10, 2)->nullable();
                            $table->date('enquiry_date')->default(DB::raw('CURDATE()'));
                            $table->enum('status', ['Pending', 'Contacted', 'Joined', 'Not Interested'])->default('Pending');
                            $table->text('remark')->nullable();
                            $table->timestamps();
                        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
