<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('computer', function (Blueprint $table) {
            $table->id();
            $table->string('PCID');
            $table->string('Büronummer')->nullable();

            //Fremdschlüssel
            $table->string('sekretariat_id')->nullable(); 
            $table->foreign('sekretariat_id') 
                    ->references('SekretariatID') 
                    ->on('sekretariat')
                    ->onDelete('set null');
            $table->timestamps(); 
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computer');
    }
};
