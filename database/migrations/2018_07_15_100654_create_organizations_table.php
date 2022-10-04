<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->integer('organization_category_id')->unsigned();
            $table->string('number')->unique();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('primary_address')->nullable();
            $table->text('other_address')->nullable();
            $table->text('primary_contact_id')->nullable();
            $table->text('custom_values');
            $table->double('total_revenue')->default(0);
            $table->double('amount_receivable')->default(0);
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);
            $table->index(['tenant_id']);
        });

        Schema::create('organization_categories', function(Blueprint $table) {
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
        Schema::dropIfExists('organizations');
        Schema::dropIfExists('organization_categories');
    }
}
