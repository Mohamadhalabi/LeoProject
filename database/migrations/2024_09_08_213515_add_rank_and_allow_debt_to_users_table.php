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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('rank')->nullable(); // Add 'rank' column
            $table->boolean('allow_debt')->default(false);   // Add 'allow_debt' column
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
            $table->dropColumn('rank');         // Drop 'rank' column
            $table->dropColumn('allow_debt');   // Drop 'allow_debt' column
       });
    }
};
