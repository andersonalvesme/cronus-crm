<?php

use Illuminate\Database\Migrations\Migration;

class CreateTaskStatusesView extends Migration
{
    public $set_schema_table = 'task_statuses';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE VIEW vw_' . $this->set_schema_table . ' AS SELECT * FROM ' . $this->set_schema_table . ' WHERE tenant_id = getTenant()');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW vw_' . $this->set_schema_table);
    }
}
