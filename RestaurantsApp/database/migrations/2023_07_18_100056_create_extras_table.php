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
        Schema::create('extras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('dish_id');
            
            $table->string('name');
            $table->text('description');
            $table->string('photo');
            $table->decimal('price');
            $table->timestamps();

            $table->foreign('menu_id')
            ->references('id')
            ->on('menus')
            ->onDelete('cascade');
            $table->foreign('dish_id')
            ->references('id')
            ->on('dishes')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extras');
    }
};
