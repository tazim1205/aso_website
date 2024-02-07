<?php

use App\AffiliateUser;
use App\Balance;
use App\Rating;
use App\Referral;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =Faker\Factory::create();

        // 10 Admin
        for ($admin = 0; $admin < 10; $admin ++) {
            $user = new \App\User();
            $user->full_name = $faker->name;
            $user->user_name = $faker->unique()->userName;
            $user->phone = '0157545400'.$admin;
            $user->email = 'm.sakirahmed@gmail.com';
            $user->gender = 'male';
            $user->role = 'admin';
            $user->upazila_id = '1';
            $user->password = Hash::make('password');
            $user->save();

            //Rating
            $rating = new Rating();
            $rating->user_id  = $user->id;
            $rating->save();

            //Balance
            $rating = new Balance();
            $rating->user_id  = $user->id;
            $rating->save();

            //Referral
            do {
                $referral_code = mt_rand( 000001, 999999 );
            } while ( Referral::where( 'own', $referral_code )->exists() );

            $referral= new \App\Referral();
            $referral->user_id  = $user->id;
            $referral->own  = $referral_code;
            $referral->save();

        }

        // 10 Controller
        for ($controller = 0; $controller < 10; $controller ++) {
            $user = new \App\User();
            $user->full_name = $faker->name;
            $user->user_name = $faker->unique()->userName;
            $user->phone = '0130473463'.$controller;
            $user->email = 'm.sakirahmed@gmail.com';
            $user->gender = 'male';
            $user->role = 'controller';
            $user->upazila_id = '1';
            $user->password = Hash::make('password');
            $user->save();

            //Rating
            $rating = new Rating();
            $rating->user_id  = $user->id;
            $rating->save();

            //Balance
            $rating = new Balance();
            $rating->user_id  = $user->id;
            $rating->save();

            //Referral
            do {
                $referral_code = mt_rand( 000001, 999999 );
            } while ( Referral::where( 'own', $referral_code )->exists() );

            $referral= new \App\Referral();
            $referral->user_id  = $user->id;
            $referral->own  = $referral_code;
            $referral->save();

        } 
        
         //::::::::::::::::::::: 10 Marketing Panel User
         for ($marketing_panel = 0; $marketing_panel < 10; $marketing_panel ++) {
            $user = new \App\User();
            $user->full_name = $faker->name;
            $user->user_name = $faker->unique()->userName;
            $user->phone = '01867734016'.$marketing_panel;
            $user->email = 'm.sakirahmed@gmail.com';
            $user->gender = 'male';
            $user->role = 'marketing_panel';
            $user->upazila_id = '1';
            $user->password = Hash::make('password');
            $user->save();

           
 

        }
        //::::::::::::::::::::: 10 Marketing Panel User

         //::::::::::::::::::::: 10 Marketer User
         for ($marketing = 0; $marketing < 10; $marketing ++) {
            $user = new \App\User();
            $user->full_name = $faker->name;
            $user->user_name = $faker->unique()->userName;
            $user->phone = '01799025247'.$marketing;
            $user->email = 'm.sakirahmed@gmail.com';
            $user->gender = 'male';
            $user->role = 'marketer';
            $user->upazila_id = '1';
            $user->password = Hash::make('password');
            $user->save();

             
            //Create Affiliate Account
            $affiliate_user = new AffiliateUser(); 
            $affiliate_user->user_id = $user->id;
            $affiliate_user->status = 1;
            $affiliate_user->save();  

            // New Comment
        }
        //::::::::::::::::::::: 10 10 Marketer User

        // 10 Worker
        for ($worker = 0; $worker < 10; $worker ++) {
            $user = new \App\User();
            $user->full_name = $faker->name;
            $user->user_name = $faker->unique()->userName;
            $user->phone = '0130473464'.$worker;
            $user->email = 'm.sakirahmed@gmail.com';
            $user->gender = 'male';
            $user->role = 'worker';
            $user->upazila_id = '1';
            $user->password = Hash::make('password');
            $user->save();

            //Rating
            $rating = new Rating();
            $rating->user_id  = $user->id;
            $rating->save();

            //Balance
            $rating = new Balance();
            $rating->user_id  = $user->id;
            $rating->save();

            //Referral
            do {
                $referral_code = mt_rand( 000001, 999999 );
            } while ( Referral::where( 'own', $referral_code )->exists() );

            $referral= new \App\Referral();
            $referral->user_id  = $user->id;
            $referral->own  = $referral_code;
            $referral->save();

        }

        // 10 Membership
        for ($membership = 0; $membership < 10; $membership ++) {
            $user = new \App\User();
            $user->full_name = $faker->name;
            $user->user_name = $faker->unique()->userName;
            $user->phone = '0130473465'.$membership;
            $user->email = 'm.sakirahmed@gmail.com';
            $user->gender = 'male';
            $user->role = 'membership';
            $user->upazila_id = '1';
            $user->password = Hash::make('password');
            $user->save();

            //Rating
            $rating = new Rating();
            $rating->user_id  = $user->id;
            $rating->save();

            //Balance
            $rating = new Balance();
            $rating->user_id  = $user->id;
            $rating->save();

            //Referral
            do {
                $referral_code = mt_rand( 000001, 999999 );
            } while ( Referral::where( 'own', $referral_code )->exists() );

            $referral= new \App\Referral();
            $referral->user_id  = $user->id;
            $referral->own  = $referral_code;
            $referral->save();
        }

        // 10 Customer
        for ($customer = 0; $customer < 10; $customer ++) {
            $user = new \App\User();
            $user->full_name = $faker->name;
            $user->user_name = $faker->unique()->userName;
            $user->phone = '0130473466'.$customer;
            $user->email = 'm.sakirahmed@gmail.com';
            $user->gender = 'male';
            $user->role = 'customer';
            $user->upazila_id = '1';
            $user->password = Hash::make('password');
            $user->save();

            //Rating
            $rating = new Rating();
            $rating->user_id  = $user->id;
            $rating->save();

            //Balance
            $rating = new Balance();
            $rating->user_id  = $user->id;
            $rating->save();

            //Referral
            do {
                $referral_code = mt_rand( 000001, 999999 );
            } while ( Referral::where( 'own', $referral_code )->exists() );

            $referral= new \App\Referral();
            $referral->user_id  = $user->id;
            $referral->own  = $referral_code;
            $referral->save();
        }
    }
}
