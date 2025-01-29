<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('computer_lizenz', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Fremdschlüssel hinzufügen
            $table->unsignedBigInteger('computer_id')->nullable();

            $table->foreign('computer_id')
                  ->references('id')
                  ->on('computer')
                  ->onDelete('set null');


            $table->string('lizenzschluessel')->nullable();

            $table->foreign('lizenzschluessel')
                  ->references('Lizenzschluessel')
                  ->on('lizenzen')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('computer_lizenz');
    }
};
