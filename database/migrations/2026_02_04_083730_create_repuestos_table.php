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
        Schema::create('repuestos', function (Blueprint $table) {
            $table->id();
            $table->string('referencia')->unique();
            $table->string('nombre');
            $table->text('description')->nullable();
            $table->string('categoria')->nullable();
            $table->string('ubicacion')->nullable();
            $table->unsignedInteger('stock_actual')->default(0);
            $table->unsignedBigInteger('stock_minimo')->default(0);
            $table->timestamps();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repuestos');
    }
};
