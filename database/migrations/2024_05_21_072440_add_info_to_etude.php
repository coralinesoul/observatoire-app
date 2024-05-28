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
        Schema::table('etudes', function (Blueprint $table) {
            Schema::table('etudes', function (Blueprint $table) {
                $table->string('longtitle')->default('');
                $table->boolean('active')->default(false);
                $table->smallInteger('startyear')->default(0);
                $table->smallInteger('stopyear')->default(0);
                $table->string('frequence')->default('');
                $table->boolean('reglementaire')->default(false);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('etudes', function (Blueprint $table) {
            Schema::table('etudes', function($table) {
                $table->dropColumn('longtitle');
                $table->dropColumn('active');
                $table->dropColumn('startyear');
                $table->dropColumn('stopyear');
                $table->dropColumn('frequence');
                $table->dropColumn('reglementaire');
            });
        });
    }
};

