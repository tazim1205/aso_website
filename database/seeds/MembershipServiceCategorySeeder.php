<?php

use Illuminate\Database\Seeder;

class MembershipServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 25 Membership service category
        for ($category_count = 1; $category_count <= 25; $category_count ++) {
            $category = new \App\MembershipServiceCategory();
            $category->name = 'M Service Category-'.$category_count;
            $category->save();
        }
    }
}
