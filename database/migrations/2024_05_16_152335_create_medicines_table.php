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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();

            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();

            $table->string('commercial_name');
            $table->unique(['warehouse_id', 'commercial_name']);

            $table->string('scientific_name');
            $table->string('factory_name');
            $table->integer('quantity')->default(0);
            $table->float('price');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
