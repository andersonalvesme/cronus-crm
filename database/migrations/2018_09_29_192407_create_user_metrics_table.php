<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMetricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_metrics', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->integer('user_id');
            $table->string('filter_match');
            $table->string('resource');
            $table->string('model');
            $table->string('card_label');
            $table->string('metric_type');
            $table->text('params');
            $table->string('time_peroid')->nullable();
            $table->string('chart_type')->nullable();
            $table->string('group_by')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);

            $table->index(['tenant_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_metrics');
    }
}
