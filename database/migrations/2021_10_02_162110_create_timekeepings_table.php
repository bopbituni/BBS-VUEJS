<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimekeepingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timekeepings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->dateTime('checkin');
            $table->dateTime('checkout');
            $table->integer('late_work')->comment('Số lần đi muộn trong tháng');
            $table->integer('late_work_total')->comment('Tổng số lần đi muộn');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timekeepings');
    }
}
