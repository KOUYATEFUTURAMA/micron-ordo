<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHopitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hopitals', function (Blueprint $table) {
            $table->id();
            $table->string('nom_hopital');
            $table->string('contact_hopital');
            $table->string('adresse_hopital');
            $table->integer('localite_id')->unsigned();
            $table->string('contact2')->nullable();
            $table->string('faxe')->nullable();
            $table->string('boite_postale')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
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
        Schema::dropIfExists('hopitals');
    }
}
