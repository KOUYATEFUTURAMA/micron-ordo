<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicaments', function (Blueprint $table) {
            $table->id();
            $table->string('denomination');
            $table->string('composition_quantitative');
            $table->integer('categorie_id');
            $table->integer('forme_id');
            $table->integer('emballage_id');
            $table->integer('mode_administration_id');
             $table->text('description')->nullable();
            $table->string('numero_autorisation')->nullable();
            $table->integer('sous_categorie_id')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('medicaments');
    }
}
