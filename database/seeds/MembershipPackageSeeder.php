<?php

use Illuminate\Database\Seeder;

class MembershipPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =Faker\Factory::create();

        // 5 Package
        for ($i = 0; $i < 4; $i ++) {
            $package = new \App\MembershipPackage();
            $package->name =  $faker->name;
            $package->three_month_price = '1';
            $package->six_month_price = '20';
            $package->twelve_month_price = '30';
            $package->mobile_availability = $faker->boolean;
            $package->description_availability = $faker->boolean;
            $package->image_count = $i;
            $package->position = $i;
            $package->save();
        }
    }
}
