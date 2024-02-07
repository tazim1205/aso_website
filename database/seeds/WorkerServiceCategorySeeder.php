<?php

use Illuminate\Database\Seeder;

class WorkerServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 25 Worker service category
        for ($category_count = 1; $category_count <= 25; $category_count ++) {
            $category = new \App\WorkerServiceCategory();
            $category->name = 'W Service Category-'.$category_count;
            $category->save();
        }
    }
}
