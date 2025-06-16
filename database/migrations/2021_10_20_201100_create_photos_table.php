<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id');
            $table->foreignId('categories_id');
            $table->integer('sub_categories')->nullable();
            $table->string('post_title');
            $table->string('post_teaser');
            $table->longText('post_content');
            $table->string('slug')->unique();
            $table->string('post_source');
            $table->string('post_photographer');
            $table->string('post_caption');
            $table->string('post_status');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
