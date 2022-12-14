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
        Schema::create('comments', function (Blueprint $table) {
            $table->id('commentId');
            $table->integer('userId');
            $table->char('imDbId',20);
            $table->string('username',45);
            $table->date('date');
            $table->tinyInteger('rate');
            $table->string('title',45);
            $table->string('content',8000);
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->tinyInteger('isRejected')->default(0);
        });

        DB::table('comments')->insert([
            ['userId' => '2', 'imDbId' => 'tt9114286', 'username' => 'test', 'date' => '2022-11-30', 'rate' => '4', 'title' => 'My First comment', 'content' => 'This is my first time commenting.', 'created_at' => '2022-11-30 15:58:05', 'updated_at' => '2022-11-30 19:32:45', 'isRejected' => '0'],
            ['userId' => '2', 'imDbId' => 'tt9114286', 'username' => 'test', 'date' => '2022-11-30', 'rate' => '5', 'title' => 'My Second comment', 'content' => 'This is my second time commenting.', 'created_at' => '2022-11-30 15:58:10', 'updated_at' => '2022-11-30 19:30:01', 'isRejected' => '0'],
            ['userId' => '1', 'imDbId' => 'tt9114286', 'username' => 'Edward', 'date' => '2022-11-30', 'rate' => '1', 'title' => 'Not so good', 'content' => 'I am writing this because I can.', 'created_at' => '2022-11-30 15:58:10', 'updated_at' => '2022-11-30 19:30:01', 'isRejected' => '0'],
            ['userId' => '2', 'imDbId' => 'tt9114286', 'username' => 'test', 'date' => '2022-12-01', 'rate' => '2', 'title' => 'My third comment', 'content' => 'This is another comment.', 'created_at' => '2022-11-30 15:58:10', 'updated_at' => '2022-11-30 19:30:01', 'isRejected' => '0'],
            ['userId' => '2', 'imDbId' => 'tt9114286', 'username' => 'test', 'date' => '2022-12-01', 'rate' => '2', 'title' => 'Something bad', 'content' => 'I am saying something bad.', 'created_at' => '2022-11-30 15:58:10', 'updated_at' => '2022-11-30 19:30:01', 'isRejected' => '1'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
