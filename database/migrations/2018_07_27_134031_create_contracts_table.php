<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->integer('contact_id')->unsigned();
            $table->integer('proposal_id')->nullable();
            $table->integer('template_id')->unsigned();
            $table->string('number')->unique();
            $table->string('title');
            $table->date('start_date');
            $table->date('expiry_date')->nullable();
            $table->boolean('auto_renewal')->default(0);
            $table->integer('no_of_months')->default(0); // months
            $table->integer('type_id');
            $table->double('value');
            $table->text('custom_values');
            $table->text('custom_values_2');
            $table->integer('status_id')->unsigned();
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);

            $table->index(['tenant_id']);
            $table->index(['tenant_id', 'contact_id']);
            $table->index(['tenant_id', 'proposal_id']);
            $table->index(['tenant_id', 'template_id']);
            $table->index(['tenant_id', 'status_id']);
        });

        Schema::create('contract_statuses', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->string('name')->unique();
            $table->string('color')->unique();
            $table->boolean('locked')->default(0);
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);

            $table->index(['tenant_id']);
        });

        Schema::create('contract_types', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->string('name')->unique();
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
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('contract_statuses');
        Schema::dropIfExists('contract_types');
    }
}
