<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('idBook');                //id книги
            $table->integer('idUser');               //id юзера
            $table->integer('code');                //4х значный код для получения книги
            $table->string('status');             //статус (забронировано, выдано, принято)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
