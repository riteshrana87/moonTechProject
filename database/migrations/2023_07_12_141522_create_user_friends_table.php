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
        Schema::create('user_friends', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sender_id')->uniqid()->comment('Foreing key - Users');
            $table->foreign('sender_id')->references('id')->on('Users')->onDelete('Cascade');
            $table->bigInteger('receiver_id')->uniqid()->comment('Foreing key - Users');
            $table->foreign('receiver_id')->references('id')->on('Users')->onDelete('Cascade');
            $table->addColumn('tinyInteger','status',['length' =>1,'default' => 0])->comment('0-pending','1-Approved','2-cancelled');
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
        Schema::dropIfExists('user_friends');
    }
};
