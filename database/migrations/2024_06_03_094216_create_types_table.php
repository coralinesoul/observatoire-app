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
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('etude_type',function(Blueprint $table){
            $table->foreignIdFor(App\Models\Etude::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Type::class)->constrained()->cascadeOnDelete();
            $table->primary(['etude_id','type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types');
        Schema::dropIfExists('etude_type');
    }
};
