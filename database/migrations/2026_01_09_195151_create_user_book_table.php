<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_book', function (Blueprint $table) {
            $table->foreignId('id_user')->constrained('user', 'id_user');
            $table->foreignId('id_book')->constrained('book', 'id_book');
            $table->foreignId('id_status')->constrained('reading_status', 'id_status');
            $table->integer('progress')->default(0);
            $table->date('start_date')->nullable();
            $table->date('planned_end_date')->nullable();
            $table->timestamps();
            $table->primary(['id_user', 'id_book']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('user_book');
    }
};