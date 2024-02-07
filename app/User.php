<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'user_name',
        'phone',
        'image',
        'gender',
        'worker_service',
        'upazila_id',
        'role',
        'phone_verified_at',
        'last_login_at',
        'password',
        'status',
        'address',
        'email',
        'recharge_amount'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'phone_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    public function district(){
        return $this->belongsTo(District::class,'district_id','id');
    }
    //Upazila
    public function upazila(){
        return $this->belongsTo(Upazila::class,'upazila_id','id');
    }

    public function pouroshova(){
        return $this->belongsTo(Puroshova::class,'pouroshova_union_id','id');
    }

    public function word(){
        return $this->belongsTo(Word::class,'word_road_id','id');
    }

    //Referral
    public function referral(){
        return $this->hasOne(Referral::class,'user_id','id');
    }

    //AdminNotice
    public function adminNotice(){
        return $this->hasMany(AdminNotice::class,'admin_id','id')
            ->orderBy('id', 'desc')
            ->take(1);  //For latest one taking
    }

    //ControllerNotice
    public function controllerNotice(){
        return $this->hasMany(ControllerNotice::class,'controller_id','id')
            ->orderBy('id', 'desc')
            ->take(1);  //For latest one taking
    }

    //ControllerNotice
    public function controllerActiveNoticeForController(){
        return $this->hasMany(ControllerNotice::class,'controller_id','id')
            ->where('is_active', 1)
            ->orderBy('id', 'desc')
            ->take(500);  //For latest one taking
    }
    public function controllerInActiveNoticeForController(){
        return $this->hasMany(ControllerNotice::class,'controller_id','id')
            ->where('is_active', 0)
            ->orderBy('id', 'desc')
            ->take(500);  //For latest one taking
    }

    //AdminAds
    public function adminAds(){
        return $this->hasMany(AdminAds::class,'admin_id','id');
    }

    //ControllerAds
    public function controllerActiveAds(){
        return $this->hasMany(ControllerAds::class,'controller_id','id')
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->take(500);  //For latest one taking
    }

    public function controllerInactiveAds(){
        return $this->hasMany(ControllerAds::class,'controller_id','id')
            ->where('status', 0)
            ->orderBy('id', 'desc')
            ->take(500);  //For latest one taking
    }



    //customerGigs
    public function customerGigs(){
        return $this->hasMany(CustomerGig::class,'customer_id','id');
    }

    //cancelInfo
    public function cancelInfo(){
        return $this->hasMany(CancelJob::class,'canceller_id','id');
    }

    //workerBids
    public function workerBids(){
        return $this->hasMany(WorkerBid::class,'worker_id','id')->orderBy('id','desc');
    }

    //workerGigs
    public function workerGigs(){
        return $this->hasMany(WorkerGig::class,'worker_id','id')->orderBy('id','desc');
    }

    //pageServices
    public function pageServices(){
        return $this->hasMany(PageService::class,'worker_id','id')->orderBy('id','desc');
    }

    //workerPages
    public function workerPages(){
        return $this->hasMany(WorkerPage::class,'worker_id','id')->orderBy('id','desc');
    }

    //customerBids
    public function customerBids(){
        return $this->hasMany(CustomerBid::class,'customer_id','id')->orderBy('id','desc');
    }

    //worerBids
    public function workerGigBids(){
        return $this->hasMany(CustomerBid::class,'customer_id','id')->orderBy('id','desc');
    }

    //serviceBids
    public function serviceBids(){
        return $this->hasMany(ServiceBid::class,'customer_id','id')->orderBy('id','desc');
    }
    //workerserviceBids
    public function workerServiceBids(){
        return $this->hasMany(ServiceBid::class,'worker_id','id')->orderBy('id','desc');
    }

  /*
    //jobsOfCustomer
    public function jobsOfCustomer(){
        return $this->hasMany(Job::class,'customer_id','id');
    }

    //jobsOfWorker
    public function jobsOfWorker(){
        return $this->hasMany(Job::class,'worker_id','id');
    }
*/
    //Nid
    public function nid(){
        return $this->hasOne(Nid::class,'user_id','id');
    }

    //Worker Service
    public function workerService(){
        return $this->hasMany(WorkerAndService::class,'worker_id','id');
    }

    public function workerServicem(){
        return $this->hasMany(WorkerAndService::class,'worker_id','id')->pluck('service_id');
    }

    //Membership Service
    public function membershipService(){
        return $this->hasMany(MembershipAndService::class,'membership_id','id');
    }

    //Membership
    public function membership(){
        return $this->hasOne(Membership::class,'user_id','id')->orderBy('id', 'desc');
    }


    public function membershipActive(){
        return $this->hasOne(Membership::class,'user_id','id')->whereDate('ending_at', '>', \Carbon\Carbon::today()->addDays(-1))->orderBy('id', 'desc');
    }

    //MembershipServicePage
    public function membershipPages(){
        return $this->hasMany(MembershipServiceProfile::class, 'member_id', 'id');
    }

    //Rating
    public function rating(){
        return $this->hasOne(Rating::class,'user_id','id');
    }

    //Balance
    public function balance(){
        return $this->hasOne(Balance::class,'user_id','id');
    }

    //Payments
    public function payments(){
        return $this->hasOne(Payment::class,'user_id','id');
    }

    //complains
    public function complains(){
        return $this->hasMany(Complain::class,'complainer_id','id');
    }

    //service order

    public function serviceOrder()
    {
        return $this->hasMany(ServiceBid::class, 'customer_id', 'id');
    }

    //Special service order

    public function specialServiceOrder()
    {
        return $this->hasMany(SpecialServiceOrder::class, 'customer_id', 'id');
    }


    //:::::: For affiliate user
    public function affiliate_user()
    {
    return $this->hasOne(AffiliateUser::class,'user_id');
    }

    //::::::::Withdraw requests
    public function withdraw_requests(){
        return $this->hasMany(WithdrawRequest::class,'user_id');
    }


    public static function worker_bid_gig_limit($worker_id){
        $worker = User::find($worker_id);
        $running = UserAccountHistory::where('user_id', $worker->id)->where(function($query) {
                                            $query->where('status', 'running')
                                            ->orWhere('status', 'pending');
                                        })->get();

        $amount = 0;

        foreach ($running as $row) {
            if ($row->service_type != 'page') {
                $amount += $row->budget;
            }
        }

        $limit = ($worker->recharge_amount  * get_static_option('order_bid_limit_amount')) - $amount;

        return $limit;
    }

    public function scopeWorker($query)
    {
        return $query->where('role', 'worker')->where('status', 1);
    }

    //scope district_id filter query
    public function scopeDistrict($query, $district_id)
    {
        if ($district_id && $district_id != 'All') {
            return $query->where('district_id', $district_id);
        }
        return $query;
    }

    //scope upazila_id filter query
    public function scopeUpazila($query, $upazila_id)
    {
        if ($upazila_id && $upazila_id != 'All') {
            return $query->where('upazila_id', $upazila_id);
        }
        return $query;
    }

    //scope month filter query
    public function scopeMonth($query, $month)
    {
        if ($month && $month != 'All') {
            return $query->whereMonth('created_at', $month);
        }
        return $query;
    }

    //scope year filter query
    public function scopeYear($query, $year)
    {
        if ($year && $year != 'All') {
            return $query->whereYear('created_at', $year);
        }
        return $query;
    }

    public function scopeController($query)
    {
        return $query->where('role','controller')->where('status',1);
    }

    public function scopeCustomer($query)
    {
        return $query->where('role', 'customer')->where('status', 1);
    }
}
