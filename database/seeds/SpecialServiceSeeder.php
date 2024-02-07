<?php

use Illuminate\Database\Seeder;

class SpecialServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $special_service = new \App\SpecialService();
        $special_service->name = 'Special service 1';
        $special_service->icon = null;
        $special_service->save();

        $special_service = new \App\SpecialService();
        $special_service->name = 'Special service 2';
        $special_service->icon = null;
        $special_service->save();

        $special_service = new \App\SpecialService();
        $special_service->name = 'Special service 3';
        $special_service->icon = null;
        $special_service->save();
    }
}
