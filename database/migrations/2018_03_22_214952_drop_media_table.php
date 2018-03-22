<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['thumbnail_id']);
            $table->dropColumn('thumbnail_id');
        });

        Schema::dropIfExists('media');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');

            $table->string('filename');
            $table->string('original_filename');
            $table->string('mime_type');
            $table->nullableMorphs('mediable');

            $table->timestamps();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->integer('thumbnail_id')->unsigned()->nullable();
            $table->foreign('thumbnail_id')->references('id')->on('media');
        });
    }
}
