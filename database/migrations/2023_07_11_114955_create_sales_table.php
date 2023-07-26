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
        Schema::connection('sales')->create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->timestamps();
        });
    }

    // public function up()
    // {
    // Schema::connection('sales')->create('salestabel', function (Blueprint $table) {
    //     $table->id();
    //     $table->timestamps();
    // //    $table->foreignId('user_id')->default(1);
    // });
    // }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('sales')->dropIfExists('sales');
    }
    // public function down()
    // {
    // Schema::table('sales', function (Blueprint $table) {
    //     $table->dropColumn('user_id');
    // });
    // }
};
