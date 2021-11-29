<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100)->nullable(false);
            $table->string('location', 100)->nullable(false);
            $table->text('description')->nullable(true);
            $table->unsignedInteger('quota')->nullable(false);
            $table->dateTime('start_date')->nullable(false);
            $table->dateTime('end_date')->nullable(false);
            $table->enum('status', ['OPEN', 'CLOSED'])->nullable(false)->default('CLOSED');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('event_type_id')->constrained('event_types');
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
        Schema::dropIfExists('events');
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['event_type_id']);
            $table->dropColumn(['user_id', 'event_type_id']);
        });
    }
}
