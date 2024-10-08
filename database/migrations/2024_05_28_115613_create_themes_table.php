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
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('etude_theme',function(Blueprint $table){
            $table->foreignIdFor(App\Models\Etude::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Theme::class)->constrained()->cascadeOnDelete();
            $table->primary(['etude_id','theme_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
        Schema::dropIfExists('etude_theme');
    }
};
