<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('county');
            $table->string('country');
            $table->string('town');
            $table->longText('description');
            $table->string('displayable_address');
            $table->longText('image');
            $table->longText('thumbnail');
            $table->text('latitude');
            $table->text('longitude');
            $table->integer('number_of_bedrooms');
            $table->integer('number_of_bathrooms');
            $table->string('price');
            $table->unsignedBigInteger('property_type_id')->nullable();
            $table->string('type');
            $table->timestamps();

            $table->foreign('property_type_id')->references('id')->on('property_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
