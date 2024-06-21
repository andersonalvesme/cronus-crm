<?php

use App\Models\UserMetric;
use Illuminate\Database\Seeder;

class UserMetricsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metrics = [
            [
                "user_id" => auth()->user()->id,
                "filter_match" => "and",
                "resource" => "organizations",
                "model" => "App\\Models\\Organization\\Organization",
                "card_label" => __("lang.organizations"),
                "metric_type" => "value",
                "params" => "{\"filter_match\":\"and\"}",
                "time_peroid" => "this_month",
                "chart_type" => "line",
                "group_by" => "created_at",
                "color" => "#3fb1e3",
                "grid_position_x" => 0,
                "grid_position_y" => 0,
                "grid_width" => 2,
                "grid_height" => 2,
            ],
            [
                "user_id" => auth()->user()->id,
                "filter_match" => "and",
                "resource" => "contacts",
                "model" => "App\\Models\\Contact\\Contact",
                "card_label" => __("lang.contacts"),
                "metric_type" => "value",
                "params" => "{\"filter_match\":\"and\"}",
                "time_peroid" => null,
                "chart_type" => null,
                "group_by" => null,
                "color" => null,
                "grid_position_x" => 2,
                "grid_position_y" => 0,
                "grid_width" => 2,
                "grid_height" => 2,
            ],
            [
                "user_id" => auth()->user()->id,
                "filter_match" => "and",
                "resource" => "leads",
                "model" => "App\\Models\\Lead\\Lead",
                "card_label" => __("lang.leads"),
                "metric_type" => "value",
                "params" => "{\"filter_match\":\"and\",\"f\":[{\"column\":\"status.name\",\"operator\":\"includes\",\"query_2\":null,\"query_1\":\"New\"}]}",
                "time_peroid" => null,
                "chart_type" => null,
                "group_by" => null,
                "color" => null,
                "grid_position_x" => 4,
                "grid_position_y" => 0,
                "grid_width" => 2,
                "grid_height" => 2,
            ],
            [
                "user_id" => auth()->user()->id,
                "filter_match" => "and",
                "resource" => "opportunities",
                "model" => "App\\Models\\Opportunity\\Opportunity",
                "card_label" => __("lang.opportunities"),
                "metric_type" => "value",
                "params" => "{\"filter_match\":\"and\"}",
                "time_peroid" => "this_month",
                "chart_type" => "line",
                "group_by" => "created_at",
                "color" => "#3fb1e3",
                "grid_position_x" => 6,
                "grid_position_y" => 0,
                "grid_width" => 2,
                "grid_height" => 2,
            ],
            [
                "user_id" => auth()->user()->id,
                "filter_match" => "and",
                "resource" => "proposals",
                "model" => "App\\Models\\Proposal\\Proposal",
                "card_label" => __("lang.proposals"),
                "metric_type" => "value",
                "params" => "{\"filter_match\":\"and\"}",
                "time_peroid" => "this_month",
                "chart_type" => "line",
                "group_by" => "created_at",
                "color" => "#3fb1e3",
                "grid_position_x" => 8,
                "grid_position_y" => 0,
                "grid_width" => 2,
                "grid_height" => 2,
            ],
            [
                "user_id" => auth()->user()->id,
                "filter_match" => "and",
                "resource" => "contracts",
                "model" => "App\\Models\\Contract\\Contract",
                "card_label" => __("lang.contracts"),
                "metric_type" => "value",
                "params" => "{\"filter_match\":\"and\"}",
                "time_peroid" => "this_month",
                "chart_type" => "line",
                "group_by" => "created_at",
                "color" => "#3fb1e3",
                "grid_position_x" => 10,
                "grid_position_y" => 0,
                "grid_width" => 2,
                "grid_height" => 2,
            ],
            [
                "user_id" => auth()->user()->id,
                "filter_match" => "and",
                "resource" => "opportunities",
                "model" => "App\\Models\\Opportunity\\Opportunity",
                "card_label" => __("lang.months_opportunities"),
                "metric_type" => "chart",
                "params" => "{\"filter_match\":\"and\"}",
                "time_peroid" => "this_month",
                "chart_type" => "bar",
                "group_by" => "start_date",
                "color" => "#6be6c1",
                "grid_position_x" => 0,
                "grid_position_y" => 2,
                "grid_width" => 6,
                "grid_height" => 5,
            ],
            [
                "user_id" => auth()->user()->id,
                "filter_match" => "and",
                "resource" => "proposals",
                "model" => "App\\Models\\Proposal\\Proposal",
                "card_label" => __("lang.months_proposals"),
                "metric_type" => "chart",
                "params" => "{\"filter_match\":\"and\"}",
                "time_peroid" => "this_month",
                "chart_type" => "bar",
                "group_by" => "issue_date",
                "color" => "#626c91",
                "grid_position_x" => 6,
                "grid_position_y" => 2,
                "grid_width" => 6,
                "grid_height" => 5,
            ],
            [
                "user_id" => auth()->user()->id,
                "filter_match" => "and",
                "resource" => "payments",
                "model" => "App\\Models\\Payment\\Payment",
                "card_label" => __("lang.months_payments"),
                "metric_type" => "chart",
                "params" => "{\"filter_match\":\"and\"}",
                "time_peroid" => "this_month",
                "chart_type" => "bar",
                "group_by" => "payment_date",
                "color" => "#96dee8",
                "grid_position_x" => 0,
                "grid_position_y" => 7,
                "grid_width" => 6,
                "grid_height" => 5,
            ],
            [
                "user_id" => auth()->user()->id,
                "filter_match" => "and",
                "resource" => "expenses",
                "model" => "App\\Models\\Expense\\Expense",
                "card_label" => __("lang.months_expenses"),
                "metric_type" => "chart",
                "params" => "{\"filter_match\":\"and\"}",
                "time_peroid" => "this_month",
                "chart_type" => "bar",
                "group_by" => "date",
                "color" => null,
                "grid_position_x" => 6,
                "grid_position_y" => 7,
                "grid_width" => 6,
                "grid_height" => 5,
            ]
        ];

        foreach ($metrics as $metric) {
            UserMetric::create($metric);
        }
    }
}
