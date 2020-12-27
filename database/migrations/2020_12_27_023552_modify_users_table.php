<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0)->after('name');
            $table->string('first_name')->after('status');
            $table->string('last_name')->after('first_name');
            $table->string('avatar')->nullable()->after('last_name');
            $table->string('avatar_letter')->after('avatar');
            $table->string('avatar_color')->after('avatar_letter');
            $table->softDeletes($column = 'deleted_at', $precision = 0)->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'first_name', 'last_name', 'avatar', 'avatar_letter', 'avatar_color', 'deleted_at']);
        });
    }
}
