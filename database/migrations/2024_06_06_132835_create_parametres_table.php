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
        Schema::create('parametres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('groupe');
            $table->string('categorie');
            $table->timestamps();
        });
        Schema::create('etude_parametre',function(Blueprint $table){
            $table->foreignIdFor(App\Models\Etude::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Parametre::class)->constrained()->cascadeOnDelete();
            $table->primary(['etude_id','parametre_id']);
        });
        Schema::create('parametre_theme',function(Blueprint $table){
            $table->foreignIdFor(App\Models\Theme::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Parametre::class)->constrained()->cascadeOnDelete();
            $table->primary(['theme_id','parametre_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etude_parametre');
        Schema::dropIfExists('parametre_theme');
        Schema::dropIfExists('parametres');
    }
};
