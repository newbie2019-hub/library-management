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
        Schema::create('returned_books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('issued_book_id')->constrained()->cascadeOnDelete();
            $table->string('fine');
            $table->timestamp('returned_at');
            $table->integer('quantity');
            $table->string('remarks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returned_books');
    }
};
