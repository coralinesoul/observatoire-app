<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matrices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('groupe');
            $table->string('categorie');
            $table->timestamps();
        });
        Schema::create('etude_matrice',function(Blueprint $table){
            $table->foreignIdFor(App\Models\Etude::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Matrice::class)->constrained()->cascadeOnDelete();
            $table->primary(['etude_id','matrice_id']);
        });
        Schema::create('matrice_theme',function(Blueprint $table){
            $table->foreignIdFor(App\Models\Theme::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Matrice::class)->constrained()->cascadeOnDelete();
            $table->primary(['theme_id','matrice_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etude_matrice');
        Schema::dropIfExists('matrice_theme');
        Schema::dropIfExists('matrices');
    }
};
