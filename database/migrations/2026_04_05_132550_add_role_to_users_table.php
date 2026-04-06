<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user'])->default('user')->after('email');
            $table->boolean('is_premium')->default(false)->after('role');
            $table->timestamp('premium_since')->nullable()->after('is_premium');
            $table->timestamp('premium_expires')->nullable()->after('premium_since');
            $table->string('avatar')->nullable()->after('premium_expires');
            $table->text('bio')->nullable()->after('avatar');
            $table->unsignedInteger('contributions')->default(0)->after('bio');
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'is_premium',
                'premium_since',
                'premium_expires',
                'avatar',
                'bio',
                'contributions'
            ]);
        });
    }
};