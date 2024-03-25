<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use smasif\ShurjopayLaravelPackage\ShurjopayService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();



Route::get('/home', 'HomeController@index')->name('home');
Route::post('/authed-user-passeword-change', 'HomeController@authedUserPasswordChange')->name('authedUserPasswordChange');



Route::get('/controller-list/{upazila_id}', function ($upazila_id) {
    $upazila = \App\Upazila::find($upazila_id);
    return view('guest.controller', compact('upazila'));
})->name('controller-list');

Route::get('/language', function () {
    if (Session::get('language') == 'en') {
        Session::put('language', 'bn');
    } else {
        Session::put('language', 'en');
    }
    //App::setLocale(Session::get('language'));
    App::setLocale('bn');
    return redirect()->back();
})->name('language');

//Guest Routes //,
Route::group(['namespace' => 'Guest'], function () {
    Route::post('/guest/get/upazila-of-a-district', 'AjaxController@getUpazilaOfDistrict')->name('getUpazilaOfDistrict');
    Route::post('/guest/get/pouroshava-of-a-upazila', 'AjaxController@getpouroshavaofupazila')->name('getpouroshavaofupazila');
    Route::post('/guest/get/pouroshava-of-a-upazila-html', 'AjaxController@getpouroshavaofupazilaHtml')->name('getpouroshavaofupazila.html');
    Route::post('/guest/get/word-of-a-pouroshava', 'AjaxController@getwordofpouroshava')->name('getwordofpouroshava');
    Route::get('/guest/worker/payment/{worker}', 'AjaxController@guestWorkerPayment')->name('guestWorkerPayment');
    Route::get('/guest/worker/payment/{user}', 'AjaxController@guestWorkerPaymentResponse')->name('guestWorkerPaymentResponse');
    Route::get('/otp-check', 'PasswordController@otpCheck')->name('otp.check');
    Route::post('/otp-check-post', 'PasswordController@otpCheckPost')->name('otp.check.post');
    Route::post('/submit/worker-register', 'RegisterController@submitWorkerRegister')->name('submitWorkerRegisterGeneral');
});


Route::group(['namespace' => 'Guest'], function () {
    Route::get('/', 'WelcomeController@index')->name('welcome');
});

Route::group(['namespace' => 'Guest', 'middleware' => ['guest']], function () {
    Route::get('/get-started', 'WelcomeController@Getstarted')->name('getstart');
    Route::get('/jobpost', 'WelcomeController@jobpost')->name('jobpost');
    Route::get('/service/{id}', 'WelcomeController@showService')->name('showService');
    Route::get('/gig/{id}', 'WelcomeController@showGig')->name('showGig');
    Route::get('/gig-details/{id}', 'WelcomeController@showGigDetails')->name('showGigDetails');
    Route::get('/gig-details/order/{id}', 'WelcomeController@showOrderForms')->name('showGigOrderForms');
    Route::post('/', 'WelcomeController@store')->name('storeGuestGig');


    Route::get('/page/{id}', 'WelcomeController@show')->name('showPages');
    Route::post('/page/click/increase', 'WelcomeController@pageClick')->name('pageClick');

    // Get Started
    Route::get('/get-started', 'WelcomeController@getStarted')->name('get.started');
    Route::get('/change-area', 'WelcomeController@changeArea')->name('change.area');
    Route::post('/store-area', 'WelcomeController@setAreaInCookie')->name('store.area');

    Route::get('/special-service/{id}', 'WelcomeController@showSpecialProfiles')->name('showSpecialProfiles');

    Route::post('/guest/submit/customer-register', 'RegisterController@submitCustomerRegister')->name('submitCustomerRegister');

    Route::get('/final-register', 'RegisterController@customerFinalRegistration')->name('getCustomerRegisterForm');
    Route::get('/final-worker-register', 'RegisterController@workerFinalRegistration')->name('getWorkerFinalRegisterForm');

    Route::get('/sp-signup', 'RegisterController@getWorkerRegisterForm')->name('getWorkerRegisterForm');
    Route::post('/guest/get/services-of-a-category', 'AjaxController@getServicesOfCategory')->name('getWorkerServicesOfCategory');
    Route::post('/guest/submit/worker-register', 'RegisterController@submitWorkerRegister')->name('submitWorkerRegister');

    Route::get('/membership-signup', 'RegisterController@getMembershipRegisterForm')->name('getMembershipRegisterForm');
    Route::post('/guest/get/membership-services-of-a-category', 'AjaxController@getMembershipServicesOfCategory')->name('getMembershipServicesOfCategory');
    Route::post('/guest/submit/membership-register', 'RegisterController@submitMembershipRegister')->name('submitMembershipRegister');

    Route::post('/reset-password', 'PasswordController@resetPassword')->name('resetPassword');
    Route::get('/privacy-policy', 'WelcomeController@privacyPolicy')->name('privacyPolicy');
    Route::get('/terms-and-conditions', 'WelcomeController@termsAndConditions')->name('termsAndConditions');


    //----------------- ::::::::::::::::::::::: Marketer Registration

    Route::get('/marketer-signup', 'RegisterController@getMarketerRegisterForm')->name('getMarketerRegisterForm');
    Route::get('/marketer-finel-register', 'RegisterController@marketerFinalRegistration')->name('marketerFinalRegistration');

    Route::post('/guest/submit/marketer-register', 'RegisterController@submitMarketerRegister')->name('submitMarketerRegister');

    //----------------- ::::::::::::::::::::::: Marketer Registration  END

});
Route::get('get/guest/gig-list/{service_id}/{budget}/{min_budget}/{max_budget}/{delivery_time}/{rating}/{timely_delivery_rate}/{order_complete_rate}/{now_online}/{recent_online}/{recent_order_delivery}', 'Guest\WelcomeController@gigList');
Route::get('get/guest/gig-questions/{gig_id}/{show}', 'Guest\WelcomeController@gigQuestions');

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard.index');
});
//Admin Routes
Route::group(['namespace' => 'Admin', 'as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['admin', 'auth']], function () {
    Route::resource('dashboard', 'DashboardController')->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);
    Route::resource('district', 'DistrictController')->except(['create', 'show', 'edit', 'destroy']);
    Route::resource('upazila', 'UpazilaController')->except(['create', 'show', 'edit', 'destroy']);

    Route::post('admin/district/destroy/{id}', 'DistrictController@destroy')->name('district.destroy');
    Route::get('admin/district/district_delete/{id}', 'DistrictController@deletedListIndex')->name('district.district_delete');
    Route::get('admin/district/district_restore/{id}', 'DistrictController@restore')->name('district.district_restore');
// District End
    Route::post('admin/upazila/destroy/{id}', 'UpazilaController@destroy')->name('upazila.destroy');
    Route::get('admin/upazila/upazila_delete/{id}', 'UpazilaController@deletedListIndex')->name('upazila.upazila_delete');
    Route::get('admin/upazila/upazila_restore/{id}', 'UpazilaController@restore')->name('upazila.upazila_restore');
// Upazila End

    Route::get('users/create', 'UserController@userCreate')->name('users.create');
    Route::get('profile', 'ProfileController@index')->name('profile.index');
    Route::post('users/store', 'UserController@userStore')->name('users.store');
    Route::get('administrative/index', 'UserController@administrativeIndex')->name('administrative.index');
    Route::get('administrative/profile/{id}', 'UserController@administrativeProfile')->name('administrative.profile');
    Route::post('users/profile-update', 'UserController@userProfileUpdate')->name('users.profile.update');
    Route::post('special/profile-update', 'UserController@specialProfileUpdate')->name('special.profile.update');
    Route::post('users/destroy/{id}', 'UserController@destroy')->name('users.destroy');
    
    Route::get('admin/users/users_information_status/{id}', 'UserController@status')->name('users.status');
    Route::get('admin/users/users_information_delete/{id}', 'UserController@deletedListIndex')->name('users.users_information_delete');
    Route::get('admin/users/users_information_restore/{id}', 'UserController@restore')->name('users.users_information_restore');
    
    // Route::get('game_setup_status/{id}',[GameSetupController::class,'status'])->name('game_setup.status');
    // Route::get('/users/restore/{id}', 'UserController@restore')->name('users_information_restore');
    // Route::get('/users/trash/{id}', 'UserController@deletedListIndex')->name('users_information_delete');

    Route::get('controller/profile/{id}', 'UserController@controllerProfile')->name('controller.profile');
    Route::get('controller/index', 'UserController@controllerIndex')->name('controller.index');
    Route::get('worker/profile/{id}', 'UserController@workerProfile')->name('worker.profile');
    Route::get('worker/index', 'UserController@workerIndex')->name('worker.index');
    Route::get('membership/profile/{id}', 'UserController@membershipProfile')->name('membership.profile');
    Route::get('membership/index', 'UserController@membershipIndex')->name('membership.index');
    Route::get('customer/profile/{id}', 'UserController@customerProfile')->name('customer.profile');
    Route::get('customer/index', 'UserController@customerIndex')->name('customer.index');
    Route::get('special/index', 'UserController@specialIndex')->name('special.index');
    Route::get('special/profile/{id}', 'UserController@specialProfile')->name('special.profile');

    Route::get('administrative/index/ajax', 'UserController@administrativeIndexAjax')->name('administrative.index.ajax');
    Route::get('controller/index/ajax', 'UserController@controllerIndexAjax')->name('controller.index.ajax');
    Route::get('worker/index/ajax', 'UserController@workerIndexAjax')->name('worker.index.ajax');
    Route::get('membership/index/ajax', 'UserController@membershipIndexAjax')->name('membership.index.ajax');
    Route::get('customer/index/ajax', 'UserController@customerIndexAjax')->name('customer.index.ajax');
    Route::get('special/index/ajax', 'UserController@specialIndexAjax')->name('special.index.ajax');

    Route::resource('worker-service-category', 'WorkerServiceCategoryController')->except(['create', 'show', 'edit', 'update', 'destroy']);
    Route::post('worker-service-category/update', 'WorkerServiceCategoryController@update');
    Route::get('/worker-service-category/delete/{id}', 'WorkerServiceCategoryController@destroy')->name('destroyWorkerCategory');
    Route::resource('worker-service', 'WorkerServiceController')->except(['create', 'show', 'edit', 'update', 'destroy']);
    Route::get('/worker-service/delete/{id}', 'WorkerServiceController@destroy')->name('destroyWorkerService');
    Route::post('worker-service/update', 'WorkerServiceController@update');

    Route::resource('membership-service-category', 'MembershipServiceCategoryController')->except(['create', 'show', 'edit', 'update', 'destroy']);
    Route::post('membership-service-category/update', 'MembershipServiceCategoryController@update');
    Route::resource('membership-service', 'MembershipServiceController')->except(['create', 'show', 'edit', 'update', 'destroy']);
    Route::post('membership-service/update', 'MembershipServiceController@update');

    Route::resource('special-service', 'SpecialServiceController')->except(['create', 'show', 'edit', 'update', 'destroy']);
    Route::get('complain/customer-complain', 'ComplainController@customerComplain')->name('complain.customer-complain');
    Route::get('/complain/customer-complain/update/{complain_id}', 'ComplainController@customerComplainUpdate')->name('complain.customer.complain.update');
    Route::post('special-service/update', 'SpecialServiceController@update');

    Route::resource('admin-notice', 'AdminNoticeController');
    Route::post('admin-notice/update', 'AdminNoticeController@update')->name('updateAdminNotice');
    Route::get('/admin-notice/delete/{id}', 'AdminNoticeController@destroy')->name('destroyAdminNotice');
    Route::get('/admin-notice/status/{id}', 'AdminNoticeController@status')->name('statusAdminNotice');
    Route::resource('controller-notice', 'ControllerNoticeController');
    Route::get('/controller-notice/delete/{id}', 'ControllerNoticeController@destroy')->name('destroyControllerNotice');
    Route::get('/controller-notice/status/{id}', 'ControllerNoticeController@status')->name('statusControllerNotice');
    Route::post('controller-notice/update', 'ControllerNoticeController@update')->name('updateControllerNotice');

    Route::resource('admin-ads', 'AdminAdsController');
    Route::delete('/admin-ads/delete/{id}','AdminAdsController@destroy');
    Route::post('admin-ads/update', 'AdminAdsController@update')->name('updateAdminAds');
    Route::get('/admin-ads/delete/{id}', 'AdminAdsController@destroy')->name('destroyAdminAds');
    Route::get('/admin-ads/restore/{id}', 'AdminAdsController@restore')->name('restoreAdminAds');
    Route::get('/admin-ads/trash/{id}', 'AdminAdsController@deletedListIndex')->name('trashAdminAds');

    Route::resource('controller-ads', 'ControllerAdsController');
    Route::get('/controller-ads/delete/{id}', 'ControllerAdsController@destroy')->name('destroyControllerAds');
    Route::post('controller-ads/update', 'ControllerAdsController@update')->name('updateControllerAds');

    //Membership Package
    Route::resource('membership-package', 'MembershipPackageController')->except(['create', 'show', 'edit', 'update', 'destroy']);
    Route::post('membership-package/update', 'MembershipPackageController@update')->name('updateMembershipPackage');
    Route::post('membership-package/delete', 'MembershipPackageController@destroy')->name('destroyMembershipPackage');
    Route::post('membership-package/categories', 'MembershipPackageController@categories')->name('categoriesMembershipPackage');
    Route::post('membership-package/trial/update', 'MembershipPackageController@trial_update')->name('updateMembershipPackageTrial');

    Route::get('/setting/general', 'SettingController@showGeneralInformation')->name('showGeneralInformation');
    Route::get('/setting/marketer/commission', 'SettingController@showGeneralMarketerCommission')->name('showGeneralMarketerCommission');

    Route::post('/setting/general/', 'SettingController@updateGeneralInformation')->name('updateGeneralInformation');




    Route::post('/withdrawby/add', 'SettingController@addWithdrawBy')->name('addWithdrawBy');

    Route::get('/withdrawby/delete/{id}', 'SettingController@deleteWithdrawBy')->name('deleteWithdrawBy');

    Route::get('/page/FAQ', 'PagesController@faqindex')->name('page.faq');
    Route::post('/page/faq/store', 'PagesController@faqStore');
    Route::post('/page/faq/update', 'PagesController@faqUpdate');
    Route::post('/page/faq/destroy', 'PagesController@faqDestroy')->name('faq.destroy');

    Route::get('/page/training-video', 'PagesController@trainingsVideo')->name('page.training-video');
    Route::post('/page/training-video/store', 'PagesController@trainingsVideostore')->name('page.training-video.store');
    Route::post('/page/training-video/update', 'PagesController@trainingsVideoupdate')->name('page.training-video.update');
    Route::post('/page/training-video/delete', 'PagesController@trainingsVideodelete')->name('page.training-video.delete');

    Route::get('/page/service/details', 'PagesController@servicedetailsindex')->name('page.service.details');
    Route::post('/page/service/details/store', 'PagesController@servicedetailsStore');
    Route::post('/page/service/details/update', 'PagesController@servicedetailsUpdate');
    Route::get('/page/service/details/destroy/{id}', 'PagesController@servicedetailsDestroy')->name('servicedetails.destroy');

    Route::get('/page/about', 'PagesController@aboutIndex')->name('page.about');
    Route::post('/page/about/update', 'PagesController@aboutUpdate');

    Route::get('/page/terms/condition', 'PagesController@termsConditionIndex')->name('page.terms.condition');
    Route::post('/page/terms/condition/update', 'PagesController@termsConditionUpdate');

    Route::get('/page/privacy/policy', 'PagesController@privacypolicyIndex')->name('page.privacy.policy');
    Route::post('/page/privacy/policy/update', 'PagesController@privacypolicyUpdate');

    Route::post('/page', 'PagesController@update')->name('page.update');
    // Route::get('/page/{slug}', 'PagesController@edit')->name('page.edit');

    //Viedeo Controller
    Route::get('/video', 'VideoController@index')->name('video.index');
    Route::post('/video/store', 'VideoController@store')->name('video.store');
    Route::post('/video/update', 'VideoController@update')->name('video.update');
    Route::get('/video/delete/{id}', 'VideoController@destroy')->name('destroyVideoController');

});

Route::get('/controller', function () {
    return redirect()->route('controller.dashboard.index');
});

//Controller Routes
Route::group(['namespace' => 'Controller', 'as' => 'controller.', 'prefix' => 'controller', 'middleware' => 'controller'], function () {
    Route::resource('dashboard', 'DashboardController')->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);
    Route::get('profile', 'ProfileController@index')->name('profile.index');
    Route::get('users', 'UserController@index')->name('user.index');

    Route::get('worker/gigs/{status}', 'WorkerController@workerGigs')->name('worker.gigs');
    Route::get('worker/gigs/deactive/{id}', 'WorkerController@deactive')->name('workergig.deactive');
    Route::get('worker/gigs/active/{id}', 'WorkerController@active')->name('workergig.active');
    Route::get('worker/gigs/pending/{id}', 'WorkerController@pending')->name('workergig.pending');
    Route::post('worker/gigs/update', 'WorkerController@gigUpdate')->name('worker.gig.update');

    Route::get('worker/page/{status}', 'WorkerController@workerPage')->name('worker.pages');
    Route::get('worker/page/deactive/{id}', 'WorkerController@pagedeactive')->name('worker.page.deactive');
    Route::get('worker/page/active/{id}', 'WorkerController@pageactive')->name('worker.page.active');
    Route::get('worker/page/pending/{id}', 'WorkerController@pagePending')->name('worker.page.pending');
    Route::post('worker/page/update', 'WorkerController@pageUpdate')->name('worker.page.update');

    Route::get('worker/service/{status}', 'WorkerController@workerservice')->name('worker.services');
    Route::get('worker/service/deactive/{id}', 'WorkerController@servicedeactive')->name('worker.service.deactive');
    Route::get('worker/service/active/{id}', 'WorkerController@serviceactive')->name('worker.service.active');
    Route::get('worker/service/pending/{id}', 'WorkerController@servicePending')->name('worker.service.pending');
    Route::post('worker/service/update', 'WorkerController@serviceUpdate')->name('worker.service.update');


    Route::post('users', 'UserController@userStatus')->name('userStatus');
    Route::get('users/badge/{id}', 'UserController@userBadge')->name('userBadge');
    Route::get('users/status/{id}', 'UserController@userStatus')->name('userStatus');
    Route::get('users/useful/file/delete/{id}', 'UserController@userUsefulDocDelete')->name('userUsefulDocDelete');
    Route::resource('ads', 'AdsController');
    Route::post('controller/ads/update', 'AdsController@update')->name('ads.update');
    Route::get('ads/{id}/delete', 'AdsController@destroy')->name('ads.delete');
    Route::get('ads/{id}/disabled', 'AdsController@disabled')->name('ads.disabled');
    Route::get('ads/{id}/enable', 'AdsController@enable')->name('ads.enable');
    Route::resource('notice', 'NoticeController');
    Route::get('notice/{id}/disabled', 'NoticeController@disabled')->name('notice.disabled');
    Route::get('notice/{id}/enable', 'NoticeController@enable')->name('notice.enable');
    Route::post('controller/notice/update', 'NoticeController@update')->name('notice.update');
    Route::resource('special-profile', 'SpecialProfileController');

    Route::get('special-service/order/{status}', 'SpecialProfileController@specialServiceOrder')->name('specialServiceOrder');
    Route::get('special-service/order/cancel/{id}', 'SpecialProfileController@cancel')->name('specialorder.cancel');
    Route::get('special-service/order/running/{id}', 'SpecialProfileController@running')->name('specialorder.running');
    Route::get('special-service/order/pending/{id}', 'SpecialProfileController@pending')->name('specialorder.pending');
    Route::get('special-service/order/complete/{id}', 'SpecialProfileController@complete')->name('specialorder.complete');

    Route::post('controller/special-profile/update', 'SpecialProfileController@update')->name('special-profile.update');
    Route::post('controller/special-profile/delete', 'SpecialProfileController@destroy')->name('special-profile.delete');
    Route::get('complain/customer-complain/{status}', 'ComplainController@customerComplain')->name('complain.customer-complain');
    Route::get('/complain/customer-complain/update/{complain_id}', 'ComplainController@customerComplainUpdate')->name('complain.customer.complain.update');


    Route::resource('pouroshobha', 'PouroshobhaController');
    Route::post('/pouroshobha/enable', 'PouroshobhaController@enable')->name('pouroshobha.enable');
    Route::post('/pouroshobha/disable', 'PouroshobhaController@disable')->name('pouroshobha.disable');
    Route::resource('ward', 'WardController');
    Route::post('/ward/enable', 'WardController@enable')->name('ward.enable');
    Route::post('/ward/disable', 'WardController@disable')->name('ward.disable');

    Route::get('worker/balance/reset/{id}', 'UserController@workerBalanceReset')->name('worker.balance.reset');


    Route::get('helpline/{type}', 'BasicInformationController@helpline')->name('helpline');
    Route::post('helpline/store', 'BasicInformationController@helplinestore')->name('helpline.store');
    Route::post('helpline/update', 'BasicInformationController@helplineupdate')->name('helpline.update');
    Route::post('helpline/delete', 'BasicInformationController@helplinedelete')->name('helpline.delete');

    //Order Management Route
    Route::get('/bid-order/{status}', 'OrderManagementController@bidOrder')->name('bid.order');
    Route::get('/bid-order-by-id/{id}' ,'OrderManagementController@bidOrderById')->name('bid.order.byId');
    Route::get('/bid-cancel/{id}' ,'OrderManagementController@bidCancel')->name('bid.order.cancel');
    Route::get('/bid-complete/{id}' ,'OrderManagementController@bidComplete')->name('bid.order.complete');
    Route::get('/gig-order/{status}', 'OrderManagementController@gigOrder')->name('gig.order');
    Route::get('/gig-order-by-id/{id}' ,'OrderManagementController@gigOrderById')->name('gig.order.byId');
    Route::get('/gig-cancel/{id}' ,'OrderManagementController@gigCancel')->name('gig.order.cancel');
    Route::get('/gig-complete/{id}' ,'OrderManagementController@gigComplete')->name('gig.order.complete');
    Route::get('/service-order/{status}', 'OrderManagementController@serviceOrder')->name('service.order');
    Route::get('/service-order-by-id/{id}' ,'OrderManagementController@serviceOrderById')->name('service.order.byId');
    Route::get('/service-cancel/{id}' ,'OrderManagementController@serviceCancel')->name('service.order.cancel');
    Route::get('/service-complete/{id}' ,'OrderManagementController@serviceComplete')->name('service.order.complete');

    // Customer Order Quantity
    Route::get('/customer-order-quantity', 'CustomerOrderQuantityController@index')->name('customer.order.quantity');

    // Sp By category and Area
    Route::get('/sp-by-category', 'UserController@spByCategory')->name('sp.category');
    // Membership By Category and Area
    Route::get('/membership-by-category', 'UserController@membershipByCategory')->name('membership.category');
    // Affiliate Marketer
    Route::get('/affiliate-marketer', 'UserController@affiliateMarketer')->name('affiliate.marketer');
    // Customer
    Route::get('/customer', 'UserController@customer')->name('customer');
    Route::post('/customer', 'UserController@updateCustomer')->name('customer.update');
    Route::post('/customer/delete', 'UserController@deleteCustomer')->name('customer.delete');
    // Worker
    Route::get('/worker', 'UserController@worker')->name('worker');
    Route::post('/worker', 'UserController@updateWorker')->name('worker.update');
    Route::post('/worker/delete', 'UserController@deleteWorker')->name('worker.delete');
    // Area Aff Marketing Cost
    Route::get('/area-aff-marketing-cost', 'MarketingController@marketingCost')->name('marketing.cost');
    // Marketing Fund
    Route::get('/marketing-fund/home', 'MarketingController@home')->name('marketing.home');
    Route::get('/marketing-fund/reserved', 'MarketingController@reserved')->name('marketing.reserved');
    Route::get('/marketing-fund/export', 'MarketingController@export')->name('marketing.export');

//    Worker By Id
    Route::get('/worker/{id}', 'UserController@workerById')->name('worker.id');
});

Route::get('get/worker/gigs/underme', 'Controller\WorkerController@WorkerGigUnderMeData');
Route::get('worker/gigs/details/{id}', 'Controller\WorkerController@details');
Route::get('worker/gigs/edit/details/{id}', 'Controller\WorkerController@Editdetails');


Route::get('get/worker/page/underme', 'Controller\WorkerController@WorkerPageUnderMeData');
Route::get('worker/page/details/{id}', 'Controller\WorkerController@Pagedetails');
Route::get('worker/page/edit/details/{id}', 'Controller\WorkerController@PageEditdetails');

Route::get('get/worker/service/underme', 'Controller\WorkerController@WorkerServiceUnderMeData');
Route::get('worker/service/details/{id}', 'Controller\WorkerController@Servicedetails');
Route::get('worker/service/edit/details/{id}', 'Controller\WorkerController@ServiceEditdetails');

Route::get('get/customer/special/service/orders', 'Controller\SpecialProfileController@specialOrderList');
Route::get('get/customer/special/service/orders/details/{id}', 'Controller\SpecialProfileController@details');


//:::::::::::::::::::::Marketing Panel Routes
Route::get('/marketing-panel', function () {
    return redirect()->route('marketing_panel.dashboard.index');
});

//:::::::::::::::::::::Marketing Panel Routes
Route::group(['namespace' => 'MarketingPanel', 'as' => 'marketing_panel.', 'prefix' => 'MarketingPanel', 'middleware' => 'MarketingPanel'], function () {
    Route::resource('dashboard', 'DashboardController')->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);

    // -------------------Marketer List Start
    Route::resource('marketer-list', 'MarketerListController');
    Route::get('marketer-list/deactive/{id}', 'MarketerListController@deactive')->name('marketer.deactive');
    Route::get('marketer-list/active/{id}', 'MarketerListController@active')->name('marketer.active');

    Route::get('marketer-list/details/{id}', 'MarketerListController@details')->name('marketer.details');
    Route::post('marketer/profile-update', 'MarketerListController@marketerProfileUpdate')->name('marketer.profile.update');

    // ads and notice
    Route::resource('ads', 'AdsController');
    Route::post('controller/ads/update', 'AdsController@update')->name('ads.update');
    Route::post('controller/ads/delete', 'AdsController@destroy')->name('ads.delete');
    Route::resource('notice', 'NoticeController');
    Route::post('controller/notice/update', 'NoticeController@update')->name('notice.update');
    Route::post('controller/notice/delete', 'NoticeController@destroy')->name('notice.delete');


    // basic information
    // Route::resource('basic', 'BasicInformationController');
    // Route::get('training-video/', 'BasicInformationController@trainingVideo')->name('trainingvideos');
    // Route::post('training-video/store', 'BasicInformationController@trainingVideostore')->name('trainingvideos.store');
    // Route::post('training-video/update', 'BasicInformationController@trainingVideoupdate')->name('trainingvideos.update');
    // Route::post('training-video/delete', 'BasicInformationController@trainingVideodelete')->name('trainingvideos.delete');

    Route::get('helpline/', 'BasicInformationController@helpline')->name('helpline');
    Route::post('helpline/store', 'BasicInformationController@helplinestore')->name('helpline.store');
    Route::post('helpline/update', 'BasicInformationController@helplineupdate')->name('helpline.update');
    Route::post('helpline/delete', 'BasicInformationController@helplinedelete')->name('helpline.delete');

    // -------------------Marketer List End

    // -------------------Marketer Statement Start
    Route::resource('marketer-statement', 'MarketerStatementController');
    // -------------------Marketer Statement End

    // -------------------Withdraw Request Start
    Route::resource('withdraw-request', 'WithdrawRequestController');

    Route::get('withdraw-request/complete/{id}', 'WithdrawRequestController@complete')->name('witdraw.complete');

    Route::post('withdraw-request/complete', 'WithdrawRequestController@completeSave')->name('witdraw.complete.submit');


    Route::get('withdraw-request/cancel/{id}', 'WithdrawRequestController@cancel')->name('withdraw.cancel');

    Route::get('withdraw_request/cancel-req/{id}', 'WithdrawRequestController@cancel')->name('cancel.req');

    Route::post('withdraw_request/cancel-req', 'WithdrawRequestController@cancelSave')->name('cancel.req.submit');

    // -------------------Withdraw Request End

    //Withdraw Report
    Route::get('withdraw-complete', 'WithdrawRequestController@complete_report')->name('withdraw.complete');

    Route::get('withdraw-cancel', 'WithdrawRequestController@cancel_report')->name('withdraw.cancel');

    // -------------------Withdraw Request End

    // -------------------Blog Start
    Route::resource('blog', 'BlogController');
//    Route::post('controller/blog/delete', 'BlogController@destroy')->name('blog.delete');

    // -------------------Blog End

});
//:::::::::::::::::::::Marketing Panel Routes


//:::::::::::::::::::::Marketer User Routes
Route::get('/marketer', function () {
    return redirect()->route('marketer.home.index');
});


//:::::::::::::::::::::Marketer User Routes
Route::group(['namespace' => 'Marketer', 'as' => 'marketer.', 'prefix' => 'marketer', 'middleware' => 'marketer'], function () {

    Route::resource('home', 'HomeController')->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);

    Route::get('/withdraw/history', 'OtherpanelController@withdrawHistoryPage')->name('withdrawHistoryPage');
    Route::get('/marketer/orders/history', 'OtherpanelController@marketerOrderHistoryPage')->name('orderHistoryPage');
    Route::get('/marketer/make/withdraw/page', 'HomeController@makeWithdrawPage')->name('withdrawpage');
    Route::post('/marketer/make/withdraw', 'HomeController@makeWithdraw')->name('makewithdraw');

    Route::get('/worker/under/me', 'OtherpanelController@workerUnderMe')->name('workerunderme');
    Route::get('/customer/under/me', 'OtherpanelController@customerUnderMe')->name('customerunderme');
    Route::get('/membership/under/me', 'OtherpanelController@memberUnderMe')->name('memberunderme');
    Route::get('/marketer/under/me', 'OtherpanelController@marketerUnderMe')->name('marketerunderme');
    Route::get('/order/under/me', 'OtherpanelController@orderUnderMe')->name('orderunderme');

    Route::get('/services/{id}', 'HomeController@showServices')->name('showServices');

    //Home>Next
    Route::get('/gig/{id}', 'MarketerGigController@show')->name('showGigs');
    Route::get('/gig-details/{id}', 'MarketerGigController@showGigDetail')->name('showGigDetail');
    Route::get('/gig-details/order/{id}', 'MarketerGigController@showOrderForm')->name('showGigOrderForm');

    //Profile
    Route::get('/profile', 'ProfileController@index')->name('profile.index');
    Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');

    // basic page
    Route::get('/training-video', 'BasicInfoController@trainingVideo')->name('training.video');
    Route::get('/help-line', 'BasicInfoController@helpline')->name('helpline');
    Route::get('/faq', 'BasicInfoController@Faq')->name('faq');
    Route::get('/service-details', 'BasicInfoController@serviceDetails')->name('service.details');
    Route::get('/about', 'BasicInfoController@about')->name('about');
    Route::get('/terms/condition', 'BasicInfoController@termsCondition')->name('terms.condition');
    Route::get('/privacy/policy', 'BasicInfoController@privacyPolicy')->name('privacy.policy');

    Route::get('/blog/{id}', 'HomeController@singleBlog')->name('single.blog');
});
//:::::::::::::::::::::Marketer User Routes



Route::get('/worker', function () {
    return redirect()->route('worker.home.index');
});
//Worker Routes
Route::post('/register-or-activation-request', 'Worker\PaymentController@registerOrActivationRequest')->name('registerOrActivationRequest');
Route::get('/activation-payment/{worker}/{purpose}', 'Worker\PaymentController@activationPayment')->name('activationPayment');
Route::get('get/worker/gig-questions/{gig_id}/{show}', 'Worker\WorkerGigController@gigQuestion');


Route::group(['namespace' => 'Worker', 'as' => 'worker.', 'prefix' => 'worker', 'middleware' => 'worker'], function () {
    Route::get('/notifications', 'NotificationController@index')->name('notifications');

    // gigi replay
    Route::get('/replay/{question_id}/{gig_id}', 'WorkerGigController@replayPage')->name('replaypage');
    Route::post('/write/replay', 'WorkerGigController@questionReplay')->name('givegigreplay');

    //Home>Next
    Route::resource('home', 'HomeController')->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);
    Route::get('/show-job/{id}', 'HomeController@showJob')->name('showJob');
    Route::get('/show-services/{id}', 'HomeController@showServices')->name('showServices');
    Route::get('/home/category/service/{id}', 'HomeController@showCustomerGigs')->name('showCustomerGigs');



    //Profile
    Route::get('/profile', 'ProfileController@index')->name('profile.index');
    Route::post('/profile/upload-useful-doc', 'ProfileController@uploadFile')->name('uploadFile');
    Route::get('/profile/upload_document', 'ProfileController@upload_document')->name('profile.upload_document');
    Route::get('/profile/service_view', 'ProfileController@service_view')->name('profile.service_view');
    Route::post('/add/stories', 'ProfileController@addStories')->name('add.stories');

    Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');

    // basic page
    Route::get('/training-video', 'HomeController@trainingVideo')->name('training.video');
    Route::get('/help-line', 'HomeController@helpline')->name('helpline');
    Route::get('/faq', 'HomeController@Faq')->name('faq');
    Route::get('/service-details', 'HomeController@serviceDetails')->name('service.details');
    Route::get('/about', 'HomeController@about')->name('about');
    Route::get('/terms/condition', 'HomeController@termsCondition')->name('terms.condition');
    Route::get('/privacy/policy', 'HomeController@privacyPolicy')->name('privacy.policy');


    Route::get('/out-of-work', 'ProfileController@outOfWork')->name('outofwork');
    Route::get('/in-work', 'ProfileController@inWork')->name('inwork');

    //Worker bid on customer gig
    Route::post('/bid', 'WorkerBidController@store')->name('storeWorkerBid');
    Route::get('/order/{id}', 'WorkerBidController@show')->name('showWorkerBid');
    Route::post('/bid/cancel/', 'WorkerBidController@cancel')->name('cancelWorkerBid');
    Route::post('/bid/change-budget/', 'WorkerBidController@changePriceForMoreWork')->name('changePriceForMoreWork');

    //All job
    Route::get('/order', 'JobController@index')->name('job.index');


    //Customer bid on worker gig
    Route::get('/customer/order/{id}', 'CustomerBidController@show')->name('showCustomerBid');
    Route::post('/customer/bid/price-change', 'CustomerBidController@updateCustomerBidBudget')->name('updateCustomerBidBudget');
    Route::post('/customer/bid/accept', 'CustomerBidController@acceptCustomerBid')->name('acceptCustomerBid');
    Route::post('/customer/bid/reject', 'CustomerBidController@rejectCustomerBid')->name('rejectCustomerBid');

    Route::post('/order/worker-gig/complete-rating', 'CustomerBidController@completedJob')->name('completedCustomerGigJob');

    Route::post('/order/worker-gig/complete/job', 'CustomerBidController@completedCustomerGigJob')->name('completedWorkerGigJob');

    //Worker created gig
    Route::get('/services/gig', 'WorkerGigController@index')->name('gig.index');
    Route::get('/services', 'WorkerGigController@services')->name('services');
    Route::get('/services/page', 'WorkerGigController@page')->name('services.pages');
    Route::get('/services/membership', 'WorkerGigController@membership')->name('services.membership');
    Route::post('/gig', 'WorkerGigController@store')->name('gig.store');
    Route::get('/gig/{id}', 'WorkerGigController@show')->name('showWorkerGig');
    Route::get('/gig/edit/{id}', 'WorkerGigController@edit')->name('editWorkerGig');
    Route::post('/gig/edit', 'WorkerGigController@update')->name('updateWorkerGig');
    Route::post('/gig/delete', 'WorkerGigController@delete')->name('deleteWorkerGig');
    Route::get('/delete/replay/{replay_id}', 'WorkerGigController@deleteReplay')->name('deletereplay');

    //Worker created service
    // Route::get('/service', 'WorkerServiceController@index')->name('service.index');
    Route::post('/service', 'WorkerServiceController@store')->name('service.store');
    Route::get('/service/{id}', 'WorkerServiceController@show')->name('showWorkerService');
    Route::get('/service/edit/{id}', 'WorkerServiceController@edit')->name('editWorkerService');
    Route::post('/service/edit', 'WorkerServiceController@update')->name('updateWorkerService');
    Route::post('/service/delete', 'WorkerServiceController@delete')->name('deleteWorkerService');

    //worker service bid by customer
    Route::get('/service/order/{id}', 'WorkerServiceController@showservice')->name('showserviceBid');
    Route::post('/service/order/cancel', 'WorkerServiceController@cancelserviceBid')->name('cancelserviceBid');
    Route::post('/service/order/accept', 'WorkerServiceController@acceptserviceBid')->name('acceptserviceBid');
    Route::post('/service/order/complete', 'WorkerServiceController@completedserviceBid')->name('completedserviceBid');
    Route::post('/service/order/complain/complete', 'WorkerServiceController@completedserviceBidComplain')->name('completedserviceBidComplain');
    Route::post('/service/order/update/budget', 'WorkerServiceController@updateServiceBidBudget')->name('updateServiceBidBudget');

    //Worker created page
    Route::post('/page', 'WorkerPageController@store')->name('workerpagestore');
    Route::post('/update/page', 'WorkerPageController@update')->name('workerpageupdate');
    Route::get('/page/{id}', 'WorkerPageController@show')->name('showWorkerPage');
    Route::get('/page/edit/{id}', 'WorkerPageController@edit')->name('editworkerpage');
    Route::post('/page/edit', 'WorkerPageController@update')->name('updateworkerpage');
    Route::post('/page/delete', 'WorkerPageController@delete')->name('deleteworkerpage');
    Route::post('/page/visibility', 'WorkerPageController@visibility')->name('workerpagevisibility');

    //Payment
    Route::get('/payment', 'PaymentController@pay')->name('duePay');
    Route::get('/response', 'PaymentController@response')->name('paymentResponse');

    // worker service area
    Route::get('/service/area', 'ServiceAreaController@index')->name('workerServiceArea');
    Route::post('/change/area', 'ServiceAreaController@UpdateCustomerArea')->name('changeArea');


    // Membership
    Route::resource('member_home', 'Membership\HomeController')->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);
    Route::post('/buy-membership', 'Membership\MembershipController@purchaseRequest')->name('buyMembership');
    Route::post('/update-membership', 'Membership\MembershipController@updateRequest')->name('updateMembership');
    Route::post('/change-membership', 'Membership\MembershipController@changeMembership')->name('changeMembership');

    Route::get('/response-membership-payment/{membership}/{duration}', 'Membership\MembershipController@purchaseResponse')->name('paymentResponse');
    Route::get('page', 'Membership\PageController@index')->name('page.index');
    Route::get('page/create', 'Membership\PageController@create')->name('page.create');
    Route::post('page/store', 'Membership\PageController@store')->name('page.store');
    Route::post('page/update', 'Membership\PageController@update')->name('page.update');
    Route::get('page/edit/{page_id}', 'Membership\PageController@edit')->name('page.edit');

    Route::post('workerdf/membership/amount', 'Membership\HomeController@amount')->name('MembershipPackageAmount');
    Route::post('worker/membership/categories', 'Membership\HomeController@categories')->name('MembershipPackageCategories');
    Route::post('worker/membership/view/categories', 'Membership\HomeController@viewcategories')->name('ViewMembershipPackageCategories');
    Route::post('worker/membership/amount/update', 'Membership\HomeController@amountupdate')->name('MembershipPackageAmountUpdate');

    Route::post('worker/membership/amount/change', 'Membership\HomeController@amountchange')->name('MembershipPackageAmountChange');


    // package details
    Route::get('/package/service/{id}', 'Membership\HomeController@PackageServices')->name('package.services');

    // Worker Add
    // Route::get('/add/sub-worker', 'HomeController@addWorker')->name('add.worker');
    Route::resource('sub-worker', 'WorkerController');
});



// Route::get('/membership', function (){
//     return redirect()->route('membership.home.index');
// });

// //Membership Routes
// Route::group(['namespace' => 'Membership', 'as' => 'membership.', 'prefix'=>'membership', 'middleware'=>['membership', 'auth']], function (){
//     Route::resource('home', 'HomeController')->except(['create','store', 'show', 'edit', 'update', 'destroy']);
//     Route::post('/buy-membership', 'MembershipController@purchaseRequest')->name('buyMembership');
//     Route::get('/response-membership-payment/{membership}/{duration}', 'MembershipController@purchaseResponse')->name('paymentResponse');
//     Route::get('page', 'PageController@index')->name('page.index');
//     Route::get('page/create', 'PageController@create')->name('page.create');
//     Route::post('page/store', 'PageController@store')->name('page.store');
//     Route::post('page/update', 'PageController@update')->name('page.update');
//     Route::get('page/edit/{page_id}', 'PageController@edit')->name('page.edit');
//     Route::get('/profile','ProfileController@index')->name('profile.index');
// });

Route::get('/customer', function () {
    return redirect()->route('customer.home.index');
});

//Customer Routes
Route::group(['namespace' => 'Customer', 'as' => 'customer.', 'prefix' => 'customer', 'middleware' => 'customer'], function () {

    Route::get('/notifications', 'NotificationController@index')->name('notifications');
    //Home
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/create/service', 'HomeController@createService')->name('create.service');
    Route::post('/', 'CustomerGigController@store')->name('storeCustomerGig');
    Route::get('/services/{id}', 'HomeController@showServices')->name('showServices');

    //Home>Next
    Route::get('/gig/{id}', 'WorkerGigController@show')->name('showGigs');
    Route::get('/gig-details/{id}', 'WorkerGigController@showGigDetail')->name('showGigDetail');
    Route::get('/gig-details/order/{id}', 'WorkerGigController@showOrderForm')->name('showGigOrderForm');

    Route::get('/page/{id}', 'WorkerPageController@show')->name('showPages');
    Route::post('/page/click/increase', 'WorkerPageController@pageClick')->name('pageClick');
    Route::get('/page-details/{id}', 'WorkerPageController@showPageDetail')->name('showPageDetail');
    Route::post('/service/click/increase', 'WorkerPageController@serviceClick')->name('serviceClick');
    Route::get('/page/{page_id}/service-details/{id}', 'WorkerPageController@showServiceDetail')->name('showServiceDetail');
    //Customer service bids
    Route::get('/page/{page_id}/service-details/order/{id}', 'WorkerPageController@showOrderForm')->name('showServiceOrderForm');
    Route::post('/page/service-details/order/submit', 'CustomerBidController@servicestore')->name('submitServiceOrderForm');
    Route::post('/otp/check', 'CustomerBidController@otpCheck')->name('otpCheck');

    Route::get('/replay/{question_id}/{gig_id}', 'WorkerGigController@replayPage')->name('replaypage');
    Route::post('/write/replay', 'WorkerGigController@questionReplay')->name('givegigreplay');

    Route::get('/delete/question/{question_id}', 'WorkerGigController@deleteQuestion')->name('deletequestion');
    Route::get('/delete/replay/{replay_id}', 'WorkerGigController@deleteReplay')->name('deletereplay');

    Route::post('/search', 'WorkerGigController@search')->name('search');

    //Profile
    Route::get('/profile', 'ProfileController@index')->name('profile.index');
    Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');

    //My Order
    //Customer gig | Worker Bids
    Route::get('/orders', 'JobController@index')->name('myJob');

    Route::get('/order/customer-gig/{id}', 'CustomerGigController@show')->name('showCustomerGig');
    Route::post('/order/customer-gig', 'CustomerGigController@selectWorker')->name('selectWorkerForCustomerGig');
    Route::post('/order/customer-gig/cancel', 'CustomerGigController@cancel')->name('cancelCustomerGig');
    Route::post('/order/customer-gig/price-change', 'CustomerGigController@changePriceForMoreWork')->name('changePriceForMoreWork');
    Route::post('/order/customer-gig/image-upload', 'CustomerGigController@imageUploadToJob')->name('imageUploadToCustomerGig');
    Route::post('/order/customer-gig/complete-rating', 'CustomerGigController@completedJobAndRating')->name('completedCustomerGigJobAndRating');
    Route::post('/order/customer-gig/complete-complain', 'CustomerGigController@completedJobAndComplain')->name('completedCustomerGigJobAndComplain');
    Route::post('/order/customer-bid/complete-complain', 'CustomerBidController@completedJobAndComplain')->name('completedCustomerBidJobAndComplain');

    //Customer's Bid
    Route::post('/gig-details/order', 'CustomerBidController@store')->name('submitGigOrderForm'); //Home: category>service>worker-gig>order-form>submit
    Route::get('/order/bid/{id}', 'CustomerBidController@show')->name('showCustomerBid');
    Route::post('/order/bid/cancel', 'CustomerBidController@cancel')->name('cancelCustomerBid');
    Route::post('/order/bid/budget', 'CustomerBidController@updateBudget')->name('updateCustomerBidBudget');
    Route::post('/order/bid/image-upload', 'CustomerBidController@imageUploadToJob')->name('imageUploadToCustomerBid');
    Route::post('/order/bid/complete-rating', 'CustomerBidController@completedJobAndRating')->name('completedCustomerBidJobAndRating');

    Route::post('/order/bid/accept/budget', 'CustomerBidController@acceptGigBidBudget')->name('acceptGigBidBudget');
    Route::post('/order/bid/cancel/budget', 'CustomerBidController@cancelGigBidBudget')->name('cancelGigBidBudget');

    Route::post('/order/gig/accept/budget', 'CustomerGigController@acceptGigBidBudget')->name('acceptGigBudget');
    Route::post('/order/gig/cancel/budget', 'CustomerGigController@cancelGigBidBudget')->name('cancelGigBudget');

    Route::get('/order/service/{id}', 'CustomerBidController@showservice')->name('showserviceBid');

    Route::post('/order/service/cancel', 'CustomerBidController@cancelserviceBid')->name('cancelserviceBid');
    Route::post('/order/service/budget', 'CustomerBidController@updateserviceBidBudget')->name('updateserviceBidBudget');
    Route::post('/order/service/accept/budget', 'CustomerBidController@acceptServiceBidBudget')->name('acceptServiceBidBudget');
    Route::post('/order/service/cancel/budget', 'CustomerBidController@cancelServiceBidBudget')->name('cancelServiceBidBudget');
    Route::post('/order/customer-service/image-upload', 'CustomerBidController@imageUploadToServiceBid')->name('imageUploadTopageBid');
    Route::post('/order/customer-service/complete-rating', 'CustomerBidController@completedServiceAndRating')->name('completedserviceBidAndRating');
    Route::post('/order/customer-service/update-rating', 'CustomerBidController@updateServiceRating')->name('updateserviceBidAndRating');
    Route::post('/order/customer-page/complete-complain', 'CustomerBidController@completedServiceAndComplain')->name('completedserviceBidAndComplain');

    //General
    Route::get('/general-services', 'GeneralServiceController@showGeneralServiceCategory')->name('showGeneralServiceCategory');
    Route::get('/general-services/{id}', 'GeneralServiceController@showMembershipServices')->name('showMembershipServices');
    Route::get('/members/{id}', 'GeneralServiceController@showMembers')->name('showMembers');
    Route::get('/members/page/{id}', 'GeneralServiceController@showMembershipPageDetail')->name('showMembershipPageDetail');
    Route::get('/special-service/{id}', 'SpecialServiceController@showSpecialProfiles')->name('showSpecialProfiles');
    Route::get('/special-service/order/{id}', 'SpecialServiceController@showOrderForm')->name('showSpecialServiceOrder');
    Route::post('/special-service/store', 'SpecialServiceController@store')->name('storeSpeacialService');


    // area change
    Route::get('/my-area', 'AreaChangeController@index')->name('myarea');
    Route::post('/change/area', 'AreaChangeController@UpdateCustomerArea')->name('changeArea');

    // basic page
    Route::get('/training-video', 'HomeController@trainingVideo')->name('training.video');
    Route::get('/help-line', 'HomeController@helpline')->name('helpline');
    Route::get('/faq', 'HomeController@Faq')->name('faq');
    Route::get('/service-details', 'HomeController@serviceDetails')->name('service.details');
    Route::get('/about', 'HomeController@about')->name('about');
    Route::get('/terms/condition', 'HomeController@termsCondition')->name('terms.condition');
    Route::get('/privacy/policy', 'HomeController@privacyPolicy')->name('privacy.policy');

    Route::get('/blog/{id}', 'HomeController@singleBlog')->name('single.blog');
});

//Payment gateway
Route::group(['namespace' => 'PaymentGateway', 'as' => '', 'prefix' => '', 'middleware' => ['auth']], function () {
    Route::get('/payment/{amount}', 'ShurjoPayController@getPaymentView')->name('shurjopay.getPaymentView');
    Route::get('/payment-success', 'ShurjoPayController@getPaymentSuccessView')->name('shurjopay.getPaymentSuccessView');
    Route::get('/response', 'ShurjoPayController@response')->name('shurjopay.response');
});

//profile update
Route::group(['middleware' => ['auth']], function () {
    Route::post('/update-users-self-profile-info', 'ProfileChangeController@updateUsersSelfProfileInfo')->name('updateUsersSelfProfileInfo');
});


// ajax get customer area
Route::get('get/district/upazila/{id}', 'Customer\AreaChangeController@GetUpozila');
Route::get('get/upazila/pouroshava-union/{id}', 'Customer\AreaChangeController@GetPouroshavaUnion');
Route::get('get/pouroshava-union/word-road/{id}', 'Customer\AreaChangeController@GetWordRoad');

// gig list for customer with filter option
Route::get('get/gig-list/{service_id}/{budget}/{min_budget}/{max_budget}/{delivery_time}/{rating}/{timely_delivery_rate}/{order_complete_rate}/{now_online}/{recent_online}/{recent_order_delivery}', 'Customer\WorkerGigController@gigList');
Route::get('get/gig-questions/{gig_id}/{show}', 'Customer\WorkerGigController@gigQuestions');

Route::get('get/gig-your-questions/{gig_id}/{show}', 'Customer\WorkerGigController@yourGigQuestions');

Route::post('/get/ask-questions', 'Customer\WorkerGigController@askQuestion')->name('askQuestion');
Route::post('/get/replay', 'Customer\WorkerGigController@questionReplay')->name('replay');


// ajax get worker area
Route::get('get/district/upazila/{id}','Worker\ServiceAreaController@GetUpozila');
Route::get('get/upazila/pouroshava-union/{id}','Worker\ServiceAreaController@GetPouroshavaUnion');
Route::get('get/pouroshava-union/word-road/{id}','Worker\ServiceAreaController@GetWordRoad');

//get worker poroshova and word and show in a div
Route::get('get/pouroshava/word/{id}', 'Worker\ServiceAreaController@GetPouroshavaWord');

//marketer ajax route
Route::get('get/marketer/targetfilupdata/{year}', 'Marketer\OtherpanelController@marketerTargetFilupData');
Route::get('get/marketer/ordercompletecommission/{year}', 'Marketer\OtherpanelController@marketerOrderCompleteCommissionData');
Route::get('get/marketer/customersignupbonus/{year}', 'Marketer\OtherpanelController@marketercustomerSignupBonusData');
Route::get('get/marketer/workersignupbonus/{year}', 'Marketer\OtherpanelController@marketerWorkerSignupBonusData');
Route::get('get/marketer/membershipsignupcommission/{year}', 'Marketer\OtherpanelController@marketerMembershipSignupCommissionData');
Route::get('get/marketer/marketers/{year}', 'Marketer\OtherpanelController@marketerMarketersCommission');

// withdraw history list
Route::get('get/withdraw/history/list/{year}', 'Marketer\OtherpanelController@withdrawHistoryList');
Route::get('see/withdraw/history/details/{id}', 'Marketer\OtherpanelController@withdrawHistoryDetails');

// order history list
Route::get('get/order/under/me/{year}/{month}', 'Marketer\OtherpanelController@orderUnderMeData');
Route::get('see/order/details/{id}', 'Marketer\OtherpanelController@orderDetails');

// worker under me
Route::get('get/customer/under/me/{year}/{month}', 'Marketer\OtherpanelController@CustomerUnderMeData');
Route::get('see/customer/details/{id}', 'Marketer\OtherpanelController@customerDetails');

// worker under me
Route::get('get/worker/under/me/{year}/{month}', 'Marketer\OtherpanelController@WorkerUnderMeData');
Route::get('see/worker/details/{id}', 'Marketer\OtherpanelController@workerDetails');

// member under me
Route::get('get/member/under/me/{year}/{month}', 'Marketer\OtherpanelController@memberUnderMeData');
Route::get('see/member/details/{id}', 'Marketer\OtherpanelController@memberDetails');

// marketer under me
Route::get('get/marketer/under/me/{year}/{month}', 'Marketer\OtherpanelController@marketerUnderMeData');
Route::get('see/marketer/details/{id}', 'Marketer\OtherpanelController@marketerDetails');

// marketer gig search
Route::get('search/marketer/gig/byname/{id}/{name}/{min_price}/{max_price}/{district}/{upazila}/{pouroshava}/{word}', 'Marketer\MarketerGigController@searchGigs');

Route::get('filter/helpline/{district}/{upazila}', 'Marketer\BasicInfoController@filterHelpline');

Route::get('customer/filter/helpline/{for}/{district}/{upazila}', 'Customer\HomeController@filterHelpline');

// marketing panel filter route
// marketer list filter
Route::get('filter/marketer/dashboard/{district}/{upazila}/{month}/{year}', 'MarketingPanel\DashboardController@filter');
Route::get('filter/marketer/list/{district}/{upazila}/{month}/{year}', 'MarketingPanel\MarketerListController@filter');
Route::get('filter/marketer/statement/{district}/{upazila}', 'MarketingPanel\MarketerStatementController@filter');
Route::get('filter/marketer/withdrawrequest/{district}/{upazila}/{month}/{year}', 'MarketingPanel\WithdrawRequestController@filter');
Route::get('filter/marketer/withdrawrequest/complete/{district}/{upazila}/{month}/{year}', 'MarketingPanel\WithdrawRequestController@filterComplete');
Route::get('filter/marketer/withdrawrequest/cancel/{district}/{upazila}/{month}/{year}', 'MarketingPanel\WithdrawRequestController@filterCancel');

Route::get('change/mode/as/customer', 'HomeController@changeModeAsCustomer')->name('change.mode.as.customer');
Route::get('change/mode/as/worker', 'HomeController@changeModeAsWorker')->name('change.mode.as.worker');
Route::get('change/mode/as/marketer', 'HomeController@changeModeAsMarketer')->name('change.mode.as.marketer');

// Blog Single Page
Route::get('blog/{id}', 'HomeController@singleBlog')->name('single.blog');

// Registration ajax
Route::get('send/registration/otp/{phone}', 'Guest\RegisterController@SendOtp');
Route::get('check/registration/otp/{phone}/{otp}', 'Guest\RegisterController@CheckOtp');
