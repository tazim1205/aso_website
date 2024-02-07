<?php

use Illuminate\Database\Seeder;

class WorkerServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 10 Worker service each of 25 category
        for ($category_count = 1; $category_count <= 25; $category_count ++) {
            for ($service_count = 1; $service_count <= 10; $service_count ++) {
                $category = new \App\WorkerService();
                $category->name = 'W Service-'.$service_count;
                $category->category_id = $category_count;
                $category->save();
            }
        }
    }
}
