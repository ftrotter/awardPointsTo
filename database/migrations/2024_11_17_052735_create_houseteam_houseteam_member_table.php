<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('houseteam_houseteam_member', function (Blueprint $table) {
            $table->id();
            $table->foreignId('houseteam_id');
            $table->foreignId('houseteam_member_id');
            $table->timestamps();

            $table->foreign('houseteam_id')->references('id')->on('houseteams')->onDelete('cascade');
            $table->foreign('houseteam_member_id')->references('id')->on('houseteam_members')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('houseteam_houseteam_member');
    }
};
