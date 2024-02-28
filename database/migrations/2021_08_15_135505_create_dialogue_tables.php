<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDialogueTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dialogues', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->text('dialogue')->default(null)->nullable()->string('dialogue', 191)->index();
            //
            $table->string('speaker_name')->default(null)->nullable();
            $table->integer('speaker_id')->default(null)->nullable();
            $table->string('speaker_type')->default(null)->nullable();
            //
            $table->integer('parent_id')->unsigned()->default(null)->nullable()->index();

            $table->foreign('parent_id')->references('id')->on('dialogues')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dialogues');
    }
}
