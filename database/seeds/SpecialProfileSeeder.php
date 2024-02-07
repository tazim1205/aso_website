<?php

use Illuminate\Database\Seeder;

class SpecialProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $special_profile = new \App\SpecialProfile();
        $special_profile->special_service_id = 1;
        $special_profile->controller_id = 1;
        $special_profile->upazila_id = 2;
        $special_profile->name = 'Asdsdcsd';
        $special_profile->phone = '3245236346';
        $special_profile->is_free = 1;
        $special_profile->save();

        $special_profile = new \App\SpecialProfile();
        $special_profile->special_service_id = 2;
        $special_profile->controller_id = 2;
        $special_profile->upazila_id = 3;
        $special_profile->name = 'Khan';
        $special_profile->phone = '3254235';
        $special_profile->is_free = 1;
        $special_profile->save();

        $special_profile = new \App\SpecialProfile();
        $special_profile->special_service_id = 3;
        $special_profile->controller_id = 3;
        $special_profile->upazila_id = 1;
        $special_profile->name = 'demodcs';
        $special_profile->phone = '2342462362456';
        $special_profile->is_free = 0;
        $special_profile->save();
    }
}
