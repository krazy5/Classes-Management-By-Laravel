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
        // Schema::table() is used to update an existing table.
        Schema::table('admin', function (Blueprint $table) {
            // This adds the special 'remember_token' column.
            // It's a VARCHAR(100) and nullable, which is exactly what Laravel needs.
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin', function (Blueprint $table) {
            // This will remove the column if you ever need to roll back the migration.
            $table->dropRememberToken();
        });
    }
};
