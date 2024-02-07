<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserSeeder::class);
         //$this->call(SettingSeeder::class);
         $this->call(WorkerServiceCategorySeeder::class);
         $this->call(WorkerServiceSeeder::class);
         $this->call(MembershipServiceCategorySeeder::class);
         $this->call(MembershipServiceSeeder::class);
         $this->call(DistrictSeeder::class);
         $this->call(UpazilaSeeder::class);
         $this->call(AdminAdsSeeder::class);
         $this->call(ControllerAdsSeeder::class);
         $this->call(AdminNoticeSeeder::class);
         $this->call(ControllerNoticeSeeder::class);
         $this->call(JobSeeder::class);
         $this->call(MembershipPackageSeeder::class);
         $this->call(StaticOptionSeeder::class);
         $this->call(PaseSeeder::class);
         $this->call(SpecialServiceSeeder::class);
         $this->call(SpecialProfileSeeder::class);
    }
}
