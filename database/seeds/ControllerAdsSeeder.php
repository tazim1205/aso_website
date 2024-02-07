<?php

use Illuminate\Database\Seeder;

class ControllerAdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //6 Ads by controller
        //Shopno
        $ads = new \App\ControllerAds();
        $ads->controller_id  = 11;
        $ads->url       = 'https://www.shwapno.com/';
        $ads->starting  = '2020/05/01';
        $ads->ending    = '2021/12/01';
        $ads->status    = 1;
        $ads->image     = 'uploads/images/controller/shwapno.png';
        $ads->save();

        //Teer
        $ads = new \App\ControllerAds();
        $ads->controller_id  = 11;
        $ads->url       = 'https://www.citygroup.com.bd/';
        $ads->starting  = '2020/05/01';
        $ads->ending    = '2021/12/01';
        $ads->status    = 1;
        $ads->image     = 'uploads/images/controller/teer.png';
        $ads->save();

        //Pathao
        $ads = new \App\ControllerAds();
        $ads->controller_id  = 11;
        $ads->url       = 'https://pathao.com/bn/';
        $ads->starting  = '2020/05/01';
        $ads->ending    = '2021/12/01';
        $ads->status    = 1;
        $ads->image     = 'uploads/images/controller/pathao.png';
        $ads->save();

        //Bike
        $ads = new \App\ControllerAds();
        $ads->controller_id  = 11;
        $ads->url       = 'https://www.heromotocorp.com/';
        $ads->starting  = '2020/05/01';
        $ads->ending    = '2021/12/01';
        $ads->status    = 1;
        $ads->image     = 'uploads/images/controller/bike.png';
        $ads->save();

        //Tatch
        $ads = new \App\ControllerAds();
        $ads->controller_id  = 11;
        $ads->url       = 'https://www.tagheuer.com/int/en/';
        $ads->starting  = '2020/05/01';
        $ads->ending    = '2021/12/01';
        $ads->status    = 1;
        $ads->image     = 'uploads/images/controller/tagheuer.png';
        $ads->save();

        //Internet
        $ads = new \App\ControllerAds();
        $ads->controller_id  = 11;
        $ads->url       = '';
        $ads->starting  = '2020/05/01';
        $ads->ending    = '2021/12/01';
        $ads->status    = 1;
        $ads->image     = 'uploads/images/controller/internet.png';
        $ads->save();
    }
}
