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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id('favoriteId');
            $table->integer('userId');
            $table->char('imDbId',20);
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });

        DB::table('favorites')->insert([
            ['userId' => '1', 'imDbId' => 'tt9114286', 'created_at' => '2022-11-24 19:54:44', 'updated_at' => '2022-11-24 19:54:44'],
            ['userId' => '1', 'imDbId' => 'tt10999120', 'created_at' => '2022-11-24 19:57:51', 'updated_at' => '2022-11-24 19:57:51'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
};
