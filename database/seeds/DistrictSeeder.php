<?php

use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 25 District seed
        for ($count = 1; $count <= 25; $count ++) {
            $district = new \App\District();
            $district->name = 'District-'.$count;
            $district->save();
        }
    }
}
