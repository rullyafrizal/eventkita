<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStatusColumnInParticipationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participations', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('participations', function (Blueprint $table) {
            $table->enum('status', ['PRESENT', 'ABSENT'])
                ->after('user_id')
                ->nullable(true);
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
            $table->dropColumn('status');
        });
    }
}
