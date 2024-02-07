<?php


Route::group(['namespace' => 'Accountant', 'as' => 'accountant.', 'prefix' => 'accountant', 'middleware' => ['accountant', 'auth']], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    //Earnings Route
    Route::group(['prefix' => 'earnings', 'as' => 'earnings.'], function () {
        Route::get('/service-provider', 'EarningController@serviceProvider')->name('service-provider');
        Route::get('/service-provider/{district}/{upazila}/{month}/{year}', 'EarningController@serviceProviderFilter')->name('service-provider.filter');
        Route::group(['prefix' => 'member', 'as' => 'member.'], function () {
            Route::get('/home', 'EarningController@memberHome')->name('home');
            Route::get('/total-paid', 'EarningController@totalPaid')->name('total.paid');
            Route::get('/payment-report', 'EarningController@paymentReport')->name('payment.report');
        });

        //Router Service
        Route::group(['prefix' => 'service', 'as' => 'service.'], function () {
            Route::get('/home', 'EarningController@serviceHome')->name('home');
            Route::get('/total-paid', 'EarningController@serviceTotalPaid')->name('total.paid');
            Route::get('/payment-report', 'EarningController@servicePaymentReport')->name('payment.report');
        });

        Route::group(['prefix' => 'others', 'as' => 'others.'], function () {
            Route::get('/home', 'EarningController@othersHome')->name('home');
            Route::get('/report', 'EarningController@othersReport')->name('report');
            Route::post('/report', 'EarningController@othersReportPost')->name('report.store');
        });

    });

    //Expense Route
    Route::group(['prefix' => 'expenses', 'as' => 'expenses.'], function () {
        Route::group(['prefix' => 'aff-marketer', 'as' => 'aff-marketer.'], function () {
            Route::get('/home', 'ExpensesController@affMarketerHome')->name('home');
            Route::get('/home/{district}/{upazila}/{month}/{year}', 'ExpensesController@affMarketerHomeFilter')->name('home.filter');
            Route::get('/exp-area', 'ExpensesController@affMarketerExpArea')->name('exp-area');
            Route::get('/exp-area/{district}/{upazila}/{month}/{year}', 'ExpensesController@affMarketerExpAreaFilter')->name('exp-area.filter');
        });

        //ad expense
        Route::group(['prefix' => 'ad', 'as' => 'ad.'], function () {
            Route::get('/home', 'ExpensesController@adHome')->name('home');
            Route::get('/home/{month}/{year}', 'ExpensesController@adHomeFilter')->name('home.filter');
            Route::get('/ad-area-report', 'ExpensesController@adArea')->name('ad-area');
            Route::post('/ad-area-report', 'ExpensesController@adAreaPost')->name('ad-area.store');
            Route::get('/ad-area-report/{district}/{upazila}/{month}/{year}', 'ExpensesController@adAreaFilter')->name('ad-area.filter');
            Route::get('/ad-global-report', 'ExpensesController@adGlobal')->name('ad-global');
            Route::post('/ad-global-report', 'ExpensesController@adGlobalPost')->name('ad-global.store');
            Route::get('/ad-global-report/{district}/{upazila}/{month}/{year}', 'ExpensesController@adGlobalFilter')->name('ad-global.filter');
        });

        //area controller expense
        Route::group(['prefix' => 'area-controller', 'as' => 'area-controller.'], function () {
            Route::get('/home', 'ExpensesController@areaControllerHome')->name('home');
            Route::get('/total-income', 'ExpensesController@areaControllerTotalIncome')->name('total-income');
            Route::get('/profit-and-pay', 'ExpensesController@areaControllerProfitAndPay')->name('profit-and-pay');
            Route::post('/profit-and-pay', 'ExpensesController@areaControllerProfitAndPayStore')->name('profit-and-pay-store');
            Route::get('/payment-report', 'ExpensesController@areaControllerPaymentReport')->name('payment-report');
        });

        //Salary Expense
        Route::group(['prefix' => 'salary', 'as' => 'salary.'], function () {
            Route::get('/home', 'ExpensesController@salaryHome')->name('home');
            Route::get(
                '/home/{month}/{year}',
                'ExpensesController@salaryHomeFilter'
            )->name('home.filter');
            Route::post('/salary-new', 'ExpensesController@salaryNewStore')->name('salary-new.store');
            Route::get('/salary-report', 'ExpensesController@salaryReport')->name('salary-report');
        });

        //Others Expense
        Route::group(['prefix' => 'others', 'as' => 'others.'], function () {
            Route::get('/home', 'ExpensesController@othersHome')->name('home');
            Route::post('/new-expense', 'ExpensesController@othersNewExpenseStore')->name('new-expense.store');
            Route::get('/report', 'ExpensesController@othersReport')->name('report');
        });

    });

    // Marketing Fund Route
    Route::group(['prefix' => 'marketing-fund', 'as' => 'marketing-fund.'], function () {
        Route::get('/overview', 'MarketingFundController@overview')->name('overview');

        //Company Marketing Fund
        Route::group(['prefix' => 'company', 'as' => 'company.'], function () {
            Route::get('/home', 'MarketingFundController@companyHome')->name('home');
            Route::get('/fund-reserve', 'MarketingFundController@companyFundReserve')->name('fund-reserve');
            Route::get('/fund-exp', 'MarketingFundController@companyFundExp')->name('fund-exp');
            Route::post('/fund-exp', 'MarketingFundController@companyFundExpStore')->name('fund-exp-store');
        });

        //Area marketing fund
        Route::group(['prefix' => 'area', 'as' => 'area.'], function () {
            Route::get('/home', 'MarketingFundController@areaHome')->name('home');
            Route::get('/fund-reserve', 'MarketingFundController@areaFundReserve')->name('fund-reserve');
            Route::get('/fund-exp', 'MarketingFundController@areaFundExp')->name('fund-exp');
            Route::post('/fund-exp', 'MarketingFundController@areaFundExpStore')->name('fund-exp-store');
        });

    });

});
