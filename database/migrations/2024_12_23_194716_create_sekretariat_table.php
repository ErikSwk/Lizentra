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
        Schema::create('sekretariat', function (Blueprint $table) {
            $table->string('SekretariatID')->primary();// SekretariatID eindeutig
            $table->string('Lehrstuhl');
            $table->string('Email');
            $table->string('Fakultät');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekretariat');
    }
};
