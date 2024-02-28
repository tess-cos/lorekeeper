<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCharacterEmotionsToDialogue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_dialogue_images', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->unsignedInteger('character_id');
            $table->text('emotion');
        });

        Schema::table('dialogues', function (Blueprint $table) {
            $table->integer('image_id')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('character_dialogue_images');

        Schema::table('dialogues', function (Blueprint $table) {
            $table->dropColumn('image_id');
        });
    }
}
