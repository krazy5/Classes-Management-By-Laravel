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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fees_record_id');
            $table->integer('installment_no');
            $table->double('amount');
            $table->date('due_date')->nullable();
            $table->date('receive_date')->nullable();
            $table->enum('payment_mode', ['Cash', 'Cheque', 'UPI', 'Bank Transfer'])->nullable();
            $table->enum('status', ['Pending', 'Paid', 'Overdue'])->default('Pending');
            $table->string('transaction_id')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('fees_record_id')->references('id')->on('fees_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
