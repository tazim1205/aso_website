<?php

use Illuminate\Database\Seeder;

class AdminAdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //5 Ads by admin
        //HP
        $ads = new \App\AdminAds();
        $ads->admin_id  = 1;
        $ads->url       = 'https://www8.hp.com/us/en/home.html';
        $ads->starting  = '2020/05/01';
        $ads->ending    = '2021/02/01';
        $ads->status    = 1;
        $ads->image     = 'uploads/images/admin/hp.png';
        $ads->save();

        //Samsung
        $ads = new \App\AdminAds();
        $ads->admin_id  = 1;
        $ads->url       = 'https://www.samsung.com/';
        $ads->starting  = '2020/05/01';
        $ads->ending    = '2021/02/01';
        $ads->status    = 1;
        $ads->image     = 'uploads/images/admin/samsung.png';
        $ads->save();

        //Bikroy
        $ads = new \App\AdminAds();
        $ads->admin_id  = 1;
        $ads->url       = 'https://bikroy.com/bn/ads';
        $ads->starting  = '2020/05/01';
        $ads->ending    = '2021/02/01';
        $ads->status    = 1;
        $ads->image     = 'uploads/images/admin/bikroy.png';
        $ads->save();

        //Walton
        $ads = new \App\AdminAds();
        $ads->admin_id  = 1;
        $ads->url       = 'https://waltonbd.com/Split-ac';
        $ads->starting  = '2020/05/01';
        $ads->ending    = '2021/02/01';
        $ads->status    = 1;
        $ads->image     = 'uploads/images/admin/walton.png';
        $ads->save();

        //Robi
        $ads = new \App\AdminAds();
        $ads->admin_id  = 1;
        $ads->url       = 'https://www.robi.com.bd/';
        $ads->starting  = '2020/05/01';
        $ads->ending    = '2021/02/01';
        $ads->status    = 1;
        $ads->image     = 'uploads/images/admin/robi.png';
        $ads->save();


    }
}
