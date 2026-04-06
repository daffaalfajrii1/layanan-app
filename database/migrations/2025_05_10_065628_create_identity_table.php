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
        Schema::create('identity', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Dinas Komunikasi dan Informatika');
            $table->text('description');
            $table->string('favicon')->default('favicon.png');
            $table->string('logo')->default('logo.png');
            $table->string('email')->default('email@email.com');
            $table->string('address')->default('address');
            $table->text('google_maps');
            $table->string('phone')->default('08123456789');
            $table->string('facebook')->default('https://www.facebook.com');
            $table->string('instagram')->default('https://www.instagram.com');
            $table->string('youtube')->default('https://www.youtube.com');
            $table->string('twitter')->default('https://www.x.com');
            $table->text('vision_mission');
            $table->text('task_function');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identity');
    }
};
