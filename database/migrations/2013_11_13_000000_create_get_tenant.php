<?php

use Illuminate\Database\Migrations\Migration;

class CreateGetTenant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE FUNCTION getTenant() RETURNS INTEGER DETERMINISTIC NO SQL RETURN @tenant_id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION getTenant()');
    }
}
