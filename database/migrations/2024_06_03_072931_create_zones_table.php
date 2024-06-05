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
        Schema::create('zones', function (Blueprint $table) {
            $table->string('name');
            $table->id();
            $table->timestamps();
        });
        Schema::create('etude_zone',function(Blueprint $table){
            $table->foreignIdFor(App\Models\Etude::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Zone::class)->constrained()->cascadeOnDelete();
            $table->primary(['etude_id','zone_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zones');
        Schema::dropIfExists('etude_zone');
    }
};
