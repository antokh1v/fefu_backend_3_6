<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('password')->nullable()->change();
                $table->string('github_id')->nullable()->unique();
            $table->dateTime('github_logged_in_at')->nullable();
            $table->dateTime('github_registered_at')->nullable();
            $table->dateTime('app_logged_in_at')->nullable();
            $table->dateTime('app_registered_at')->nullable();
            $table->string('vk_id')->nullable()->unique();
            $table->dateTime('vk_logged_in_at')->nullable();
            $table->dateTime('vk_registered_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
            $table->dropColumn(['github_id', 'github_logged_in_at', 'github_registered_at', 'vk_id',
                'vk_logged_in_at', 'vk_registered_at', 'app_logged_in_at', 'app_registered_at']);
        });
    }
};
