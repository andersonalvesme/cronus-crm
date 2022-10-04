<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdjustUniqueForTasksAuxiliarsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_statuses', function (Blueprint $table) {
            $table->dropUnique('task_statuses_name_unique');
            $table->dropUnique('task_statuses_color_unique');

            $table->unique(['tenant_id', 'name']);
            $table->unique(['tenant_id', 'color']);
        });
    }
}
