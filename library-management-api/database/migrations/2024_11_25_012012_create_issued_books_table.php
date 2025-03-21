<?php

use App\Models\User;
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
        Schema::create('issued_books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('book_id')->constrained('books', 'id')->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignUuid('member_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->integer('quantity');
            $table->integer('returned_qty')->default(0);
            $table->timestamp('return_date');
            $table->timestamp('issued_at');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issued_books');
    }
};
