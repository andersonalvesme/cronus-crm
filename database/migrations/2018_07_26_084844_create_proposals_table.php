<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->integer('contact_id')->unsigned();
            $table->integer('opportunity_id')->nullable();
            $table->integer('template_id')->unsigned();
            $table->string('number');
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->text('custom_values');
            $table->text('custom_values_2');
            $table->integer('status_id')->unsigned();
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);

            $table->unique(['tenant_id', 'number']);

            $table->index(['tenant_id']);
            $table->index(['tenant_id', 'contact_id']);
            $table->index(['tenant_id', 'opportunity_id']);
            $table->index(['tenant_id', 'template_id']);
            $table->index(['tenant_id', 'status_id']);
        });

        Schema::create('proposal_statuses', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->string('name')->unique();
            $table->string('color')->unique();
            $table->boolean('locked')->default(0);
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
        Schema::dropIfExists('proposals');
        Schema::dropIfExists('proposal_statuses');
    }
}
