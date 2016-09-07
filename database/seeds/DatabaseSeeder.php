<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EmailTemplateForgerPasswordSeeder::class);
        $this->call(CompliantsEmailTableSeeder::class);
        $this->call(EmailTemplateSignUpTableSeeder::class);
        //$this->call(AdminTableSeeder::class);
        //$this->call(CategoryTableSeeder::class);
        //$this->call(UserTableSeeder::class);
        //$this->call(StaffTableSeeder::class);
        //$this->call(PickUpNumberTableSeeder::class);
    }
}
