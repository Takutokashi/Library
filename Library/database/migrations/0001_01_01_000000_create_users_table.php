<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');                                                         //Имя
            $table->string('surname');                                                     //Фамилия
            $table->string('email');                                                      //Email
            $table->string('password');                                                  //Пароль
            $table->string('remember_token')->default('noToken');;                //токен ->default('noToken');
            $table->string('role');                                                    //Роль (admin, librarian, user)       ->default('user')
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
