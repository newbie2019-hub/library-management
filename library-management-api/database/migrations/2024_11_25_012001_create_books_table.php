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
        Schema::create('books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('author_id')->constrained();
            $table->string('isbn_no');
            $table->string('title');
            $table->integer('quantity');
            $table->string('edition')->nullable();
            $table->string('price')->nullable();
            $table->integer('pages');
            $table->string('publisher')->nullable();
            $table->string('series')->nullable();
            $table->string('cover_photo')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('purchased_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
