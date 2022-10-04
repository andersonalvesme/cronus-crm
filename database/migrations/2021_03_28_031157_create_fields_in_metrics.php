<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldsInMetrics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_metrics', function (Blueprint $table) {
            $table->integer('grid_position_x')->unsigned()->after('color');
            $table->integer('grid_position_y')->unsigned()->after('grid_position_x');
            $table->integer('grid_width')->unsigned()->after('grid_position_y');
            $table->integer('grid_height')->unsigned()->after('grid_width');
        });

        DB::statement('DROP VIEW vw_user_metrics');
        DB::statement('CREATE VIEW vw_user_metrics AS SELECT * FROM user_metrics WHERE tenant_id = getTenant()');
    }
}
