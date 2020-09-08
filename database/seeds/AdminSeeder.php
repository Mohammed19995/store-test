<?php

use Illuminate\Database\Seeder;

// models
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        Admin::create([
            'name' => "Admin" ,
            'email' => "admin@admin.com" ,
            'phone_code' => '0972' ,
            'phone' => '598149450' ,
            'password' => bcrypt("123456") ,
            'image_id' => null,
            'is_super' => 1
        ]);

    }
}
