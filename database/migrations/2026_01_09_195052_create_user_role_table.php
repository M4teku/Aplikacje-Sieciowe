<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_role', function (Blueprint $table) {
            $table->foreignId('id_user')->constrained('user', 'id_user');
            $table->foreignId('id_role')->constrained('role', 'id_role');
            $table->timestamp('assigned_at')->useCurrent();
            $table->primary(['id_user', 'id_role']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('user_role');
    }
};