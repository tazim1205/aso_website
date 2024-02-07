<?php

use App\AdminNotice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class AdminNoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notice = new AdminNotice();
        $notice->admin_id    = '1';
        $notice->title       = 'Admin notice';
        $notice->detail      = '"This is admin notice ...
        lorem ipsum dolor sit amet,
        consectetur adipiscing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip
        ex ea commodo consequat. Duis aute irure dolor in reprehenderit
        in voluptate velit esse cillum dolore eu fugiat
        nulla pariatur. Excepteur sint occaecat cupidatat non proident,
        sunt in culpa qui officia deserunt mollit anim id est laborum."';
        $notice->save();
    }
}
