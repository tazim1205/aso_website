<?php

use Illuminate\Database\Seeder;

class StaticOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        set_static_option('name', 'ashooo');

        set_static_option('logo', null);
        set_static_option('logo_white', null);
        set_static_option('header_logo', null);
        set_static_option('header_logo_white', null);
        set_static_option('fav', null);

        set_static_option('motto', 'service marketplace');
        set_static_option('sms_username', '');
        set_static_option('sms_key', 'ab5821e83a99eb9ec4774c962cb768a0');
        set_static_option('reset_sms_count', null);
        set_static_option('reset_sms_template', null);
        set_static_option('welcome_sms_template', null);
        set_static_option('worker_activation_price', null);
        set_static_option('worker_maximum_due_permission', null); //************* */
        set_static_option('per_customer_referral_price', null);
        set_static_option('per_worker_referral_price', null);
        set_static_option('per_membership_referral_price', null);
        set_static_option('admin_percent_on_worker_job', null);

        set_static_option('session_lifetime', '');

        set_static_option('smtp_email_host', '');
        set_static_option('smtp_email_port', '');
        set_static_option('smtp_email_username', '');
        set_static_option('smtp_email_password', '');
        set_static_option('smtp_email_encryption', '');
        set_static_option('smtp_email_from_name', '');
        set_static_option('smtp_email_from_email', '');

        set_static_option('author_name', '');
        set_static_option('author_description', '');
        set_static_option('meta_image', '');

        set_static_option('company_main_email', '');
        set_static_option('company_main_phone', '');

        set_static_option('website_footer_credit', '');

        set_static_option('google_client_id', '');          //google
        set_static_option('google_client_secret', '');
        set_static_option('google_o_auth_status', '');      //Enable/Disable
        set_static_option('facebook_client_id', '');        //facebook
        set_static_option('facebook_client_secret', '');
        set_static_option('facebook_o_auth_status', '');
        set_static_option('instagram_client_id', '');       //instagram
        set_static_option('instagram_client_secret', '');
        set_static_option('instagram_o_auth_status', '');
        set_static_option('twitter_client_id', '');         //twitter
        set_static_option('twitter_client_secret', '');
        set_static_option('twitter_o_auth_status', '');
        set_static_option('github_client_id', '');          //github
        set_static_option('github_client_secret', '');
        set_static_option('github_o_auth_status', '');
        set_static_option('linkedin_client_id', '');        //linkedin
        set_static_option('linkedin_client_secret', '');
        set_static_option('static_available_survice', '#');
        set_static_option('static_customer_survice', '#');
        set_static_option('static_worker_survice', '#');
        set_static_option('static_provider_survice', '#');
        set_static_option('no_image', 'uploads/images/defaults/no-image.png');   //no_image
    }
}
