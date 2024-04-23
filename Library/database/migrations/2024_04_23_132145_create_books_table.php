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
            $table->id();
            $table->string('title');  //название
            $table->string('author'); // автор
            $table->string('genre'); // жанр
            $table->text('shortDescription'); //краткое описание
            $table->text('description'); //полноценное описание
            $table->string('picture'); //ссылка на изображение
            $table->boolean('booking')->default(false); //бронирование true or false
            $table->boolean('issued')->default(false); // если книга в наличии = true, иначе false
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
