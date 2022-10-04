<?php

use Illuminate\Database\Migrations\Migration;

class CreateEntryTaskInCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tenants = DB::select('SELECT id FROM tenants');

        foreach ($tenants as $tenant) {
            DB::statement('SET @tenant_id=' . $tenant->id);
            DB::statement('INSERT INTO counters (`key`, prefix, value) VALUES("task", "TA-", 10001)');
        }
    }
}
