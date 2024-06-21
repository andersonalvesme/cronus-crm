<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(OpportunitiesTableSeeder::class);
        $this->call(TemplatesTableSeeder::class);
        $this->call(ProposalsTableSeeder::class);
        $this->call(ContractsTableSeeder::class);
        $this->call(CustomFieldsTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(TasksTableSeeder::class);
        $this->call(ActivitiesTableSeeder::class);
        $this->call(PaymentsTableSeeder::class);
        $this->call(ExpensesTableSeeder::class);
        $this->call(VendorsTableSeeder::class);
        $this->call(InvoicesTableSeeder::class);
        $this->call(LeadsTableSeeder::class);
        $this->call(OrganizationsTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
    }
}
