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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_code')->unique();
            $table->boolean('activated')->default(false);
            $table->dateTime('activation_date')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // Add this line
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Add this line
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
