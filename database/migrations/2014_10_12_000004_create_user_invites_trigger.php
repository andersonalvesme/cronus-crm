<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInvitesTrigger extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'user_invites';

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
                SET NEW.id=(select IFNULL(max(id)+1,1) from ' . $this->set_schema_table . ' where tenant_id=NEW.tenant_id);
                SET @lastInsertId_' . $this->set_schema_table . '=NEW.id;
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
