<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name', 80)->default('My Favourites');
            $table->boolean('is_public')->default(false);
            $table->string('share_token', 32)->nullable()->unique();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('collections');
    }
};