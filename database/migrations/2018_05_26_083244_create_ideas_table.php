<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 150);
            $table->string('description', 500);
            $table->integer('owner_id');
            $table->timestamps();
        });

        Schema::create('idea_user', function (Blueprint $table) {
           $table->integer('idea_id');
           $table->integer('user_id');
           $table->boolean('accepted')->default(false);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ideas');
        Schema::dropIfExists('idea_user');
    }
}
