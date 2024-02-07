<?php

use Illuminate\Database\Seeder;

class UpazilaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 10 Worker service each of 25 category
        for ($district_count = 1; $district_count <= 25; $district_count ++) {
            for ($upazila_count = 1; $upazila_count <= 10; $upazila_count ++) {
                $upazila = new \App\Upazila();
                $upazila->name = 'Upazila-'.$upazila_count;
                $upazila->district_id = $district_count;
                $upazila->save();
            }
        }
    }
}
