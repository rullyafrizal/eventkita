<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('event_id')->constrained('events');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status', ['PRESENT', 'ABSENT']);
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
        Schema::table('participations', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn(['event_id']);

            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id']);
        });
        Schema::dropIfExists('participations');
    }
}
