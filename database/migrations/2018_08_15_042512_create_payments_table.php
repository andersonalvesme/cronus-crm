<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->integer('contact_id')->unsigned();
            $table->string('number');
            $table->date('payment_date');
            $table->integer('method_id')->unsigned();
            $table->string('reference');
            $table->integer('deposit_id')->unsigned();
            $table->double('amount_received');
            $table->double('amount_applied');
            $table->double('bank_fees');
            $table->double('net_amount');
            $table->text('note')->nullable();
            $table->text('custom_values');
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);

            $table->unique(['tenant_id', 'number']);

            $table->index(['tenant_id']);
        });


        Schema::create('payment_lines', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->integer('payment_id')->unsigned();
            $table->integer('invoice_id')->unsigned();
             $table->double('amount_applied');
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);

            $table->index(['tenant_id']);
        });

        Schema::create('payment_methods', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->string('name');
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);

            $table->unique(['tenant_id', 'name']);

            $table->index(['tenant_id']);
        });

        Schema::create('payment_deposits', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->string('name');
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);

            $table->unique(['tenant_id', 'name']);

            $table->index(['tenant_id']);
        });

        Schema::create('payment_requests', function (Blueprint $table) {
            $table->unsignedInteger('tenant_id');
            $table->unsignedInteger('id');
            $table->integer('contact_id')->unsigned();
            $table->integer('invoice_id')->unsigned();
            $table->string('email');
            $table->string('number');
            $table->string('uuid');
            $table->timestamp('expiry_at');
            $table->timestamp('payment_received_at')->nullable();
            $table->timestamps();

            $table->primary(['tenant_id', 'id']);

            $table->unique(['tenant_id', 'number']);
            $table->unique(['tenant_id', 'uuid']);

            $table->index(['tenant_id']);
        });

         Schema::create('payment_tokens', function (Blueprint $table) {
             $table->unsignedInteger('tenant_id');
             $table->unsignedInteger('id');
            $table->integer('request_id')->unsigned();
            $table->string('gateway');
            $table->string('value');
            $table->string('type')->nullable();
            $table->string('email')->nullable();
            $table->text('other')->nullable();
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
        Schema::dropIfExists('payments');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('payment_deposits');
        Schema::dropIfExists('payment_lines');
        Schema::dropIfExists('payment_requests');
        Schema::dropIfExists('payment_tokens');
    }
}
