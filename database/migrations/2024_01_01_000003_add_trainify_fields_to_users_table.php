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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'trainer', 'user'])->default('user')->after('email');
            $table->string('phone')->nullable()->after('password');
            $table->text('bio')->nullable()->after('phone');
            $table->integer('height')->nullable()->after('bio')->comment('in cm');
            $table->integer('weight')->nullable()->after('height')->comment('in kg');
            $table->integer('age')->nullable()->after('weight');
            $table->string('avatar')->nullable()->after('age');
            $table->string('specialization')->nullable()->after('avatar')->comment('for trainers');
            $table->string('certifications')->nullable()->after('specialization')->comment('for trainers');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'phone', 'bio', 'height', 'weight', 'age', 
                'avatar', 'specialization', 'certifications'
            ]);
            $table->dropSoftDeletes();
        });
    }
};
