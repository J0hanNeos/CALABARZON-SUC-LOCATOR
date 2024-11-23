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
        Schema::create('colleges', function (Blueprint $table) {
            $table->id(); // auto-incrementing primary key
            $table->string('name'); // Name of SUC
            $table->string('address'); // Address
            $table->decimal('latitude', 10, 7); // Latitude with precision
            $table->decimal('longitude', 10, 7); // Longitude with precision
            $table->string('website')->nullable(); // Optional website
            $table->string('contact_number')->nullable(); // Optional contact number
            $table->string('avatar_url')->nullable(); // Optional avatar URL
            $table->timestamps(); // Timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colleges');
    }
};
