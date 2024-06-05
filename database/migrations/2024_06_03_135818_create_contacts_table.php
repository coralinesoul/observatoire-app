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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('mail');
            $table->boolean('diffusion_mail');
            $table->timestamps();
        });
        Schema::create('contact_etude',function(Blueprint $table){
            $table->foreignIdFor(App\Models\Etude::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\Contact::class)->constrained()->cascadeOnDelete();
            $table->primary(['etude_id','contact_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('contact_etude');
    }
};
