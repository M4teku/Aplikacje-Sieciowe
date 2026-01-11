<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('review', function (Blueprint $table) {
            $table->id('id_review');
            $table->foreignId('id_user')->constrained('user', 'id_user');
            $table->foreignId('id_book')->constrained('book', 'id_book');
            $table->integer('rating');
            $table->text('content', 4000);
            $table->timestamps();
            $table->unique(['id_user', 'id_book']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('review');
    }
};