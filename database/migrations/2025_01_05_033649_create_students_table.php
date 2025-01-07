<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique(); // Relates to the User model
            $table->json('academic')->nullable(); // Academic details as JSON
            $table->json('language')->nullable(); // Language proficiency as JSON
            $table->string('image')->nullable(); // Profile image
            $table->decimal('fund', 10, 2)->default(0); // Available funds
            $table->string('study_interest')->nullable(); // Field of interest for higher study
            $table->boolean('eligibility')->default(false); // Eligibility flag
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}


