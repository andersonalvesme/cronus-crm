<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->integer('contact_id')->unsigned();
            $table->string('number')->unique();
            $table->string('title');
            $table->text('description');
            $table->integer('source_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('stage_id')->unsigned();
            $table->string('status_id'); // won or lost
            $table->tinyInteger('probability')->default(0);
            $table->date('start_date');
            $table->date('close_date');
            $table->double('value');
            $table->text('custom_values');
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);

            $table->index(['tenant_id']);
            $table->index(['tenant_id', 'contact_id']);
            $table->index(['tenant_id', 'category_id']);
            $table->index(['tenant_id', 'source_id']);
            $table->index(['tenant_id', 'stage_id']);
            $table->index(['tenant_id', 'status_id']);
        });

        Schema::create('opportunity_categories', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->string('name')->unique();
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);
        });

        Schema::create('opportunity_sources', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->string('name')->unique();
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);
        });

        Schema::create('opportunity_stages', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->string('name')->unique();
            $table->string('color')->unique();
            $table->boolean('locked')->default(0);
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opportunities');
        Schema::dropIfExists('opportunity_categories');
        Schema::dropIfExists('opportunity_sources');
        Schema::dropIfExists('opportunity_stages');
    }
}
