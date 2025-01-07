<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleToVisaPacksTable extends Migration
{
    public function up()
    {
        Schema::table('visa_packs', function (Blueprint $table) {
            $table->string('title')->nullable()->after('agency_id'); // Add title column
        });
    }

    public function down()
    {
        Schema::table('visa_packs', function (Blueprint $table) {
            $table->dropColumn('title'); // Remove title column if rolled back
        });
    }
}
