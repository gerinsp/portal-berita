<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id');
            $table->foreignId('categories_id');
            $table->integer('sub_categories')->nullable();
            $table->string('post_title');
            $table->string('post_teaser');
            $table->longText('post_content');
            $table->string('slug')->unique();
            $table->string('post_status');
            $table->string('post_image');
            $table->text('post_image_description');
            $table->string('published_at');

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
        Schema::dropIfExists('posts');
    }
}
