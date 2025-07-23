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
                Schema::create('notifications', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('message');
                $table->unsignedBigInteger('student_id')->nullable(); // Null means sent to all
                $table->string('audience')->default('all'); // ✅ Add this line
                $table->boolean('is_read')->default(false);
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->foreign('student_id')->references('id')->on('student_records')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('notifications');
        }
    };
