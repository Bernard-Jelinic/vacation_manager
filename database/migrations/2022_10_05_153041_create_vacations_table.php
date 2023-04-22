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
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->date('depart');
            $table->date('return');
            $table->integer('status')->nullable();
            $table->integer('admin_read')->nullable();
            $table->integer('manager_read')->nullable();
            $table->integer('employee_read')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vacations', function (Blueprint $table) {
            $table->dropForeign('vacations_user_id_foreign');
        });
        Schema::dropIfExists('vacations');
    }
};
