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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('restaurant_name');
            $table->string('email')->uniqid();
            $table->string('password');
            $table->string('phone');
            $table->string('address');
            $table->string('restaurant_photo');
            $table->timestamp('email_verified_at')->nullable(); // verify email
            $table->boolean('verified'); // verify restaurant from admin
            $table->string('status'); // open | closed | maintenance 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
