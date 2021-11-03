<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_pictures', function (Blueprint $table) {
            $table->id();
            $table->string('path', 255);
            $table->foreignId('event_id')->constrained('events');
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
        Schema::dropIfExists('event_pictures');
        Schema::table('event_pictures', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn(['event_id']);
        });
    }
}
