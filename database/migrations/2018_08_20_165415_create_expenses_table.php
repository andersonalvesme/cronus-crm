<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->integer('vendor_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('number');
            $table->date('date');
            $table->string('description');
            $table->double('amount');
            $table->integer('project_id')->nullable();
            $table->integer('opportunity_id')->nullable();
            $table->text('custom_values');
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);

            $table->unique(['tenant_id', 'number']);

            $table->index(['tenant_id']);
        });

        Schema::create('expense_categories', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->string('name');
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);

            $table->unique(['tenant_id', 'name']);

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
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('expense_categories');
    }
}
