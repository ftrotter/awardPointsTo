<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('point_transactions', function (Blueprint $table) {
        $table->id();
        $table->integer('points');
        $table->text('reason')->nullable();
        $table->unsignedBigInteger('team_member_id');
        $table->unsignedBigInteger('house_team_id');
        $table->timestamps();

        $table->foreign('team_member_id')->references('id')->on('team_members')->onDelete('cascade');
        $table->foreign('house_team_id')->references('id')->on('house_teams')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_transactions');
    }
};
