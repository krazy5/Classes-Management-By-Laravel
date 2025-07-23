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
        Schema::create('messages', function (Blueprint $table) {
                $table->id();
                $table->morphs('sender');       // Creates sender_id and sender_type
                $table->morphs('recipient');    // Creates recipient_id and recipient_type
                $table->text('body');
                $table->timestamp('read_at')->nullable();
                $table->timestamps();

                // ✅ ADD THESE INDEXES FOR PERFORMANCE
                $table->index(['sender_id', 'sender_type']);
                $table->index(['recipient_id', 'recipient_type']);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
