<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lizenzen', function (Blueprint $table) {
            $table->string('Lizenzschluessel')->primary();
            $table->integer('MaxAnzahl');
            $table->integer('Anzahl')->default(0);
            $table->date('Lizenzbeginn');
            $table->date('Lizenzende');
            $table->string('Software');
            $table->string('Lizenzstatus');
            $table->string('Rechnungs_Pfad')->nullable();
            $table->timestamps();

            // Fremdschlüssel hinzufügen
            $table->string('sekretariat_id')->nullable(); 
            $table->foreign('sekretariat_id') 
                    ->references('SekretariatID') 
                    ->on('sekretariat')
                    ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lizenzen');
    }
};

