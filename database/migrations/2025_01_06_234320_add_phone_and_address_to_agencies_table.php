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
    Schema::table('agencies', function (Blueprint $table) {
        $table->string('phone')->nullable(); // Add phone column
        $table->string('address')->nullable(); // Add address column
    });
}

public function down()
{
    Schema::table('agencies', function (Blueprint $table) {
        $table->dropColumn(['phone', 'address']); // Drop the columns if the migration is rolled back
    });
}

};
