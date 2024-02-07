<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $page = new \App\Page();
        $page->bn_name = 'Service Details';
        $page->en_name = 'Service Details';
        $page->slug = Str::slug('Service Details', '-');
        $page->save();

        $page = new \App\Page();
        $page->bn_name = 'Video training';
        $page->en_name = 'Video training';
        $page->slug = Str::slug('Video training', '-');
        $page->save();

        $page = new \App\Page();
        $page->bn_name = 'Help line';
        $page->en_name = 'Help line';
        $page->slug = Str::slug('Help line', '-');
        $page->save();

        $page = new \App\Page();
        $page->bn_name = 'About';
        $page->en_name = 'About';
        $page->slug = Str::slug('About', '-');
        $page->save();

        $page = new \App\Page();
        $page->bn_name = 'FAQ';
        $page->en_name = 'FAQ';
        $page->slug = Str::slug('FAQ', '-');
        $page->save();

        $page = new \App\Page();
        $page->bn_name = 'Terms and condition';
        $page->en_name = 'Terms and condition';
        $page->slug = Str::slug('Terms and condition', '-');
        $page->save();

        $page = new \App\Page();
        $page->bn_name = 'Privacy policy';
        $page->en_name = 'Privacy policy';
        $page->slug = Str::slug('Privacy policy', '-');
        $page->save();
    }
}
