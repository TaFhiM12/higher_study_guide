<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // Foreign key to users table
        $table->string('title');
        $table->string('image');
        $table->string('country_name');
        $table->enum('degree_type', ['Undergraduate', 'Masters', 'PhD']);
        $table->text('content');
        $table->string('publishers');
        $table->boolean('is_approved')->default(false);
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    public function down()
    {
        Schema::dropIfExists('posts');
    }
}

