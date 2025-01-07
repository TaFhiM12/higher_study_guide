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
        Schema::create('visa_packs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agency_id'); // Relates to the Agency model
            $table->enum('status', ['active', 'expired', 'deactivated'])->default('active'); // Visa pack status
            $table->string('country_name'); // Target country
            $table->string('degree')->nullable(); // Degree type (optional)
            $table->integer('processing_time')->nullable(); // Processing time in weeks
            $table->decimal('cost', 10, 2)->nullable(); // Cost in decimal
            $table->text('details')->nullable(); // Detailed description
            $table->string('image')->nullable(); // Path to the image
            $table->boolean('is_approved')->default(false); // Approval status
            $table->boolean('is_featured')->default(false); // Featured status
            $table->date('expire_date')->nullable(); // Expiration date
            $table->timestamps();

            // Foreign key relationship
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('visa_packs');
    }
};
