<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrideAgencyInstitutionCountryToStudentsTable extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->boolean('pride')->default(false)->after('eligibility'); // Represents success status
            $table->unsignedBigInteger('agency_id')->nullable()->after('pride'); // Agency that facilitated success
            $table->string('current_institution')->nullable()->after('agency_id'); // Current institution of the student
            $table->string('country')->nullable()->after('current_institution'); // Country of the student

            // Add a foreign key for agency_id
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('pride');
            $table->dropForeign(['agency_id']);
            $table->dropColumn('agency_id');
            $table->dropColumn('current_institution');
            $table->dropColumn('country');
        });
    }
}
