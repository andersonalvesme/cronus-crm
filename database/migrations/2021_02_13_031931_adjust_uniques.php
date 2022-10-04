<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdjustUniques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropUnique('contacts_number_unique');
            $table->unique(['tenant_id', 'number']);
        });

        Schema::table('contract_statuses', function (Blueprint $table) {
            $table->dropUnique('contract_statuses_name_unique');
            $table->unique(['tenant_id', 'name']);

            $table->dropUnique('contract_statuses_color_unique');
            $table->unique(['tenant_id', 'color']);
        });

        Schema::table('contract_types', function (Blueprint $table) {
            $table->dropUnique('contract_types_name_unique');
            $table->unique(['tenant_id', 'name']);
        });

        Schema::table('contracts', function (Blueprint $table) {
            $table->dropUnique('contracts_number_unique');
            $table->unique(['tenant_id', 'number']);
        });

        Schema::table('images', function (Blueprint $table) {
            $table->dropUnique('images_filename_unique');
            $table->unique(['tenant_id', 'filename']);
        });

        Schema::table('item_categories', function (Blueprint $table) {
            $table->dropUnique('item_categories_name_unique');
            $table->unique(['tenant_id', 'name']);
        });

        Schema::table('item_uoms', function (Blueprint $table) {
            $table->dropUnique('item_uoms_name_unique');
            $table->unique(['tenant_id', 'name']);
        });

        Schema::table('items', function (Blueprint $table) {
            $table->dropUnique('items_code_unique');
            $table->unique(['tenant_id', 'code']);
        });

        Schema::table('lead_statuses', function (Blueprint $table) {
            $table->dropUnique('lead_statuses_name_unique');
            $table->unique(['tenant_id', 'name']);

            $table->dropUnique('lead_statuses_color_unique');
            $table->unique(['tenant_id', 'color']);
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->dropUnique('leads_number_unique');
            $table->unique(['tenant_id', 'number']);
        });

        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropUnique('opportunities_number_unique');
            $table->unique(['tenant_id', 'number']);
        });

        Schema::table('opportunity_categories', function (Blueprint $table) {
            $table->dropUnique('opportunity_categories_name_unique');
            $table->unique(['tenant_id', 'name']);
        });

        Schema::table('opportunity_sources', function (Blueprint $table) {
            $table->dropUnique('opportunity_sources_name_unique');
            $table->unique(['tenant_id', 'name']);
        });

        Schema::table('opportunity_stages', function (Blueprint $table) {
            $table->dropUnique('opportunity_stages_name_unique');
            $table->unique(['tenant_id', 'name']);

            $table->dropUnique('opportunity_stages_color_unique');
            $table->unique(['tenant_id', 'color']);
        });

        Schema::table('organization_categories', function (Blueprint $table) {
            $table->dropUnique('organization_categories_name_unique');
            $table->unique(['tenant_id', 'name']);
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->dropUnique('organizations_number_unique');
            $table->unique(['tenant_id', 'number']);
        });

        Schema::table('project_categories', function (Blueprint $table) {
            $table->dropUnique('project_categories_name_unique');
            $table->unique(['tenant_id', 'name']);
        });

        Schema::table('project_stages', function (Blueprint $table) {
            $table->dropUnique('project_stages_name_unique');
            $table->unique(['tenant_id', 'name']);

            $table->dropUnique('project_stages_color_unique');
            $table->unique(['tenant_id', 'color']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropUnique('projects_number_unique');
            $table->unique(['tenant_id', 'number']);
        });

        Schema::table('proposal_statuses', function (Blueprint $table) {
            $table->dropUnique('proposal_statuses_name_unique');
            $table->unique(['tenant_id', 'name']);

            $table->dropUnique('proposal_statuses_color_unique');
            $table->unique(['tenant_id', 'color']);
        });

        Schema::table('templates', function (Blueprint $table) {
            $table->dropUnique('templates_name_unique');
            $table->unique(['tenant_id', 'name']);
        });

        Schema::table('user_invites', function (Blueprint $table) {
            $table->dropUnique('user_invites_token_unique');
            $table->unique(['tenant_id', 'token']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
