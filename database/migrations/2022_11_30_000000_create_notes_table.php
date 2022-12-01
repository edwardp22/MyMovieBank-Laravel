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
        Schema::create('notes', function (Blueprint $table) {
            $table->id('noteId');
            $table->integer('userId');
            $table->char('imDbId',20);
            $table->string('note',8000);
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });

        DB::table('notes')->insert([
            ['userId' => '1', 'imDbId' => 'tt9114286', 'note' => 'I have to watch this next week.', 'created_at' => '2022-11-24 19:54:44', 'updated_at' => '2022-11-24 19:54:44'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
};
