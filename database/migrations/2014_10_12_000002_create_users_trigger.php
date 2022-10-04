<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTrigger extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER trix_' . $this->set_schema_table . ' BEFORE INSERT ON ' . $this->set_schema_table . '
            FOR EACH ROW
            BEGIN
                SET NEW.tenant_id=(SELECT getTenant());
            END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER trix_' . $this->set_schema_table);
    }
}
