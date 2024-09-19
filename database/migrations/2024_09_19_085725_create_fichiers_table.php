<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichiersTable extends Migration
{
    public function up()
    {
        Schema::create('fichiers', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('chemin'); // pour stocker le chemin du fichier
            $table->timestamps();
        });

        Schema::create('etude_fichier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etude_id')->constrained()->onDelete('cascade');
            $table->foreignId('fichier_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('etude_fichier');
        Schema::dropIfExists('fichiers');
    }
}
