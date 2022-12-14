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
        Schema::create('wishes', function (Blueprint $table) {
            $table->id('wishId');
            $table->integer('userId');
            $table->char('imDbId',20);
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });

        DB::table('wishes')->insert([
            ['userId' => '2', 'imDbId' => 'tt12003946', 'created_at' => '2022-11-30 18:41:36', 'updated_at' => '2022-11-30 18:41:36'],
            ['userId' => '2', 'imDbId' => 'tt12530246', 'created_at' => '2022-11-30 18:41:36', 'updated_at' => '2022-11-30 18:41:36'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wishes');
    }
};
