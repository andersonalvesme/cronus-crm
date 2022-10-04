<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTenant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->decimal('price', 15, 2)->nullable()->after('name');
            $table->smallInteger('invoice_period')->unsigned()->default(0)->after('price');
            $table->string('invoice_interval')->default('month')->after('invoice_period');
            $table->dateTime('trial_ends_at')->nullable()->after('invoice_interval');
            $table->dateTime('canceled_at')->nullable()->after('trial_ends_at');
            $table->integer('active_users_limit')->unsigned()->nullable()->after('canceled_at');
            $table->tinyInteger('active')->default('0')->after('active_users_limit');
        });
    }
}
