<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('book', function (Blueprint $table) {
            $table->id('id_book');
            $table->string('title', 256);
            $table->string('author', 256);
            $table->string('genre', 100);
            $table->text('description', 4000);
            $table->foreignId('created_by')->constrained('user', 'id_user');
            $table->foreignId('updated_by')->nullable()->constrained('user', 'id_user');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('book');
    }
};