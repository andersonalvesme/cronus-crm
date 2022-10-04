<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTasksTable extends Migration
{
    private $set_schema_table = 'tasks';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->set_schema_table, function (Blueprint $table) {
            $table->integer('type_id')->integer()->after('priority');
            $table->integer('status_id')->unsigned()->after('priority');
            $table->text('description')->after('subject');
            $table->string('number')->after('id');

            $table->dropColumn('taskable_type');
            $table->dropColumn('taskable_id');
        });

        DB::statement('DROP VIEW vw_' . $this->set_schema_table);
        DB::statement('CREATE VIEW vw_' . $this->set_schema_table . ' AS SELECT * FROM ' . $this->set_schema_table . ' WHERE tenant_id = getTenant()');
    }
}
