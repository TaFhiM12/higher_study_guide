<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relates to the User model
            $table->string('website')->nullable(); // Agency's website
            $table->string('logo')->nullable(); // Agency's logo
            $table->string('TIN')->nullable(); // Government approval ID
            $table->text('bio')->nullable(); // Agency's biography
            $table->boolean('is_featured')->default(false); // Featured flag
            $table->timestamps();

            // Foreign key relationship
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('agencies');
    }
};
