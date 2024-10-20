<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_wallet', function (Blueprint $table) {
            $table->unsignedInteger('create_by_id')->after('user_id')->change();
            $table->string('create_by_type')->after('user_id')->change();
        });
        Schema::table('user_wallet', function (Blueprint $table) {
            $table->text('files')->after('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_wallet', function (Blueprint $table) {
            //
        });
    }
};