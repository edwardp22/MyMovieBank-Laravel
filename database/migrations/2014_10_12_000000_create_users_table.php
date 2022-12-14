<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->tinyInteger('isAdmin')->default(0);
        });

        DB::table('users')->insert([
            ['name' => 'Edward', 'email' => 'edwardp22@hotmail.com', 'password' => '$2y$10$rQgkEyPzDijWCT/WQE9bQedQaqDjGX6ZZ0If02hAgXU0rBiHWIrJq', 'created_at' => '2022-11-24 17:40:05', 'updated_at' => '2022-11-30 19:18:41', 'isAdmin' => '0'],
            ['name' => 'test', 'email' => 'test@test.com', 'password' => '$2y$10$rQgkEyPzDijWCT/WQE9bQedQaqDjGX6ZZ0If02hAgXU0rBiHWIrJq', 'created_at' => '2022-11-24 17:40:05', 'updated_at' => '2022-11-30 19:18:41', 'isAdmin' => '0'],
            ['name' => 'admin', 'email' => 'admin@test.com', 'password' => '$2y$10$rQgkEyPzDijWCT/WQE9bQedQaqDjGX6ZZ0If02hAgXU0rBiHWIrJq', 'created_at' => '2022-11-24 17:40:05', 'updated_at' => '2022-11-30 19:18:41', 'isAdmin' => '1'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
