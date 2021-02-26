<?php

Route::get('logout', function(){
    auth()->logout();

    return redirect()->route('index');
});

Route::get('test/export', 'ImportController@test');

Route::post('tim-kiem', 'SearchController@search')->name('search'); // đã convert

Route::get('tim-kiem/all', 'SearchController@allSearch')->name('all-search'); // đã convert

Route::get('/', 'AdminController@index')->name('index');
Route::post('/update-status-care', 'AdminController@updateStatusCare')->name('update-status-care');

Route::get('/delete-key-active/{id}', 'AdminController@deleteKeyActive')->name('delete-key'); // đã convert

Route::resource('/roles', 'RolesController'); // đã convert

Route::get('permission', 'PermissionsController@index')->name('permission.index')->middleware(['pms:create-permission']); // đã convert

Route::post('permission', 'PermissionsController@create')->name('permission.create')->middleware(['pms:create-permission']); // đã convert

Route::resource('/product', 'ProductController'); // đã convert

Route::get('input', 'AdminController@inputForm')->name('input'); // đã convert
Route::get('input/edit/{id}', 'AdminController@inputEditForm')->name('input-edit-form'); // đã convert
Route::post('input/edit/{id}', 'AdminController@inputEdit')->name('input-edit'); // đã convert

Route::post('product-add', 'AdminController@input')->name('product-add'); // đã convert

Route::get('get-product/{id}/{count}/{total}', 'AdminController@getProduct');

Route::get('import', 'ImportController@importForm')->name('inport-form');

Route::post('import', 'ImportController@import')->name('import'); // đã convert

Route::group(['prefix' => 'sendy', 'as' => 'sendy.'], function(){
    Route::get('/', 'SendyController@index')->name('index'); // đã convert
    Route::post('/', 'SendyController@store')->name('store'); // đã convert
});

Route::group(['prefix' => 'customer', 'as' => 'customer.'], function() {
    Route::get('/classify', 'CustomerController@classify')->name('classify'); // đã convert
    Route::get('no-paid', 'CustomerController@noPaid')->name('no-paid'); // đã convert
    Route::get('confirm-pay/{id}', 'CustomerController@confirmPay')->name('confirm-pay'); // đã convert
    Route::get('not-actived', 'CustomerController@notActived')->name('not-actived'); // đã convert
    Route::post('customer-paid/{id}', 'CustomerController@customerPaid')->name('customer-paid'); // đã convert
    Route::post('/reset-key/{id}', 'CustomerController@resetKey')->name('reset-key'); // đã convert

    Route::get('/{id}/edit', 'CustomerController@edit')->name('edit'); // đã convert
    Route::put('/{id}/edit', 'CustomerController@update')->name('update'); // đã convert

    Route::get('/{id}/renewed', 'CustomerController@getRenewed')->name('getRenewed'); // đã convert
    Route::put('/{id}/renewed', 'CustomerController@postRenewed')->name('postRenewed'); // đã convert

    Route::post('/editComment', 'CustomerController@editComment')->name('editComment'); // đã convert
    Route::post('/editBackground', 'CustomerController@editBackground')->name('editBackground'); // đã convert

    Route::get('/listHashKeyCustomer', 'CustomerController@listHashKeyCustomer')->name('listHashKeyCustomer'); // đã convert
    Route::get('/hashKeyCustomer', 'CustomerController@hashKeyCustomer')->name('hashKeyCustomer'); // đã convert
    Route::post('/createHashKeyCustomer', 'CustomerController@createHashKeyCustomer')->name('createHashKeyCustomer'); // đã convert
    Route::post('/exportHashKeyCustomer', 'CustomerController@exportHashKeyCustomer')->name('exportHashKeyCustomer'); // đã convert
    Route::post('/exportCertificateCustomer', 'CustomerController@exportCertificateCustomer')->name('exportCertificateCustomer'); // đã convert
    Route::post('/importListHashKeyCustomer', 'CustomerController@importListHashKeyCustomer')->name('importListHashKeyCustomer'); // đã convert
    Route::post('/exportCustomer', 'CustomerController@exportCustomer')->name('exportCustomer'); // đã convert
    Route::get('/print/{id}', 'CustomerController@print')->name('print'); // đã convert

    Route::get('/trial', 'CustomerController@trial')->name('trial'); // đã convert
    Route::get('/today', 'CustomerController@activeToday')->name('today'); // đã convert
    Route::post('/exportCustomerTrial', 'CustomerController@exportCustomerTrial')->name('exportCustomerTrial'); // đã convert

    Route::post('/changeUser', 'CustomerController@changeUser')->name('changeUser'); // đã convert

    Route::post('/{id}/delete', 'CustomerController@delete')->name('delete'); // đã convert
    Route::post('/{id}/resendEmail', 'CustomerController@resendEmail')->name('resendEmail'); // đã convert
    Route::post('/{id}/blockKey', 'CustomerController@blockKey')->name('blockKey'); // đã convert
    Route::get('/import/certificate', 'CustomerController@importCertificateForm')->name('import-certicate-form'); // đã convert

    Route::get('/delete-certificate/{id}', 'CustomerController@deleteCertificate')->name('delete-certificate'); // đã convert
    Route::get('/edit-certificate/{id}', 'CustomerController@editCertificateForm')->name('edit-certificate'); // đã convert
    Route::post('/edit-certificate/{id}', 'CustomerController@editCertificate')->name('edit-certificate-post'); // đã convert


    Route::post('/import/certificate', 'ImportController@importCertificateExcel')->name('import-certificate'); // đã convert
    Route::get('/export/certificate', 'CertificateController@exportCertificateView')->name('export-certificate-view'); // đã convert
    Route::post('/export/certificate', 'CertificateController@exportCertificate')->name('export-certificate'); // đã convert

    Route::get('/certificate/approve/list', 'CertificateController@certificateList')->name('certificate-list-approve'); // đã convert
    Route::get('/certificate/detail/{name}', 'CertificateController@certificateDetail')->name('certificate-detail'); // đã convert
    Route::get('/certificate/delete/{name}', 'CertificateController@certificateDelete')->name('certificate-delete'); // đã convert
    Route::get('/certificate/accept/{name}', 'CertificateController@certificateAccept')->name('accept-certificate'); // đã convert
    Route::group(['prefix' => 'export', 'as' => 'export.'], function() {
        Route::post('notPaid', 'ExportCustomerController@notPaid')->name('notPaid'); // đã convert
        Route::post('expired', 'ExportCustomerController@expired')->name('expired'); // đã convert
        Route::post('beforeExpired', 'ExportCustomerController@beforeExpired')->name('beforeExpired'); // đã convert
    });

});

Route::group(['prefix' => 'course', 'as' => 'course.'], function () {
    Route::post('importExcel', 'CourseController@importExcel')->name('importExcel'); // đã convert
    Route::post('exportExcel', 'CourseController@exportExcel')->name('exportExcel'); // đã convert
    
});
Route::resource('/course', 'CourseController'); // đã convert
Route::resource('/customer', 'CustomerController'); // đã convert

Route::get('certificate/create', 'CourseController@certificateCreate')->name('certificate'); //  đã convert
Route::get('certificate/index', 'CertificateController@certificateIndex')->name('certification'); // đã convert 

Route::group(['prefix' => 'certificate', 'as' => 'certificate.'], function () {
    Route::post('merge', 'CertificateController@merge')->name('merge'); // đã convert
    Route::get('decree-suggest', 'CertificateController@decreeSuggest')->name('decree-suggest');
    Route::get('contest-list', 'CertificateController@contestList')->name('contest-list'); // đã convert
    Route::get('edit/{id}', 'CertificateController@editCertificateForm')->name('edit-certificate-form');
    Route::post('edit/{id}', 'CertificateController@editCertificate')->name('edit-certificate'); // đã convert
    Route::get('accept-item/{id}', 'CertificateController@acceptItem')->name('accept-item'); // đã convert
    Route::get('list', 'CertificateController@list')->name('list-certificate'); // đã convert
    Route::post('update-date-exam', 'CertificateController@updateDateExam')->name('update-date-exam')->middleware(['pms:update-date-exam-all']); // đã convert
    Route::post('update-date-exam-item', 'CertificateController@updateDateExamItem')->name('update-date-exam-item')->middleware(['pms_:access-certificate-detail']); // đã convert
    Route::post('update-retest-item', 'CertificateController@updateRetestItem')->name('update-retest-item'); // đã convert
    Route::get('{nameUpload}', 'CertificateController@detailCertificateAccept')->name('detail-certificate-upload')->middleware(['pms_:access-certificate-detail']); // đã convert
    Route::post('update-import-certificate/{nameUpload}', 'CertificateController@updateImportCertificate')->name('update-import-certificate'); // đã convert
    Route::post('update-decree', 'CertificateController@updateDecree')->name('update-decree'); // đã convert
    Route::get('delete-certificate/{id}', 'CertificateController@deleteCertificate')->name('delete-certificate'); // đã convert
});
Route::group(['prefix' => 'license', 'as' => 'license.'], function() {
    Route::get('/send-key', 'LicenseController@sendKey')->name('send-key')->middleware(['pms:license-sendkey']); // đã convert
    Route::post('/send-key', 'LicenseController@postSendKey')->name('post-send-key')->middleware(['pms:license-sendkey']); // đã convert

    Route::get('create', 'LicenseController@create')->name('create'); // đã comvert
    Route::get('key-store', 'LicenseController@keyStore')->name('key-store'); // đã convert
    Route::post('create-license-key', 'LicenseController@store')->name('store');
    Route::get('not-actived', 'LicenseController@notActived')->name('not-actived'); // đã convert
    Route::get('actived', 'LicenseController@actived')->name('actived'); // đã convert

    Route::get('emailSended', 'LicenseController@emailSended')->name('emailSended'); // đã convert
    Route::get('emailSendedToday', 'LicenseController@emailSendedToday')->name('emailSendedToday'); // đã convert

    Route::get('exported', 'LicenseController@exported')->name('exported'); // đã convert
    Route::post('export-excel-key', 'LicenseController@exportExcel')->name('exportExcel'); // đã convert

    Route::get('export-api', 'LicenseController@exportApi')->name('exportApi'); // đã convert

    Route::get('{id}/edit', 'LicenseController@edit')->name('edit');// đã convert
    Route::put('{id}/edit', 'LicenseController@update')->name('update'); // đã convert
    Route::put('{id}/edit-email', 'LicenseController@updateEmail')->name('updateEmail');
    Route::post('/export-excel', 'LicenseController@exportExcelSelected')->name('export-excel-selected');// đã convert
    Route::post('/send-mail-customer/{id}', 'LicenseController@sendMailCustomer')->name('sendMailCustomer');// đã convert

    // Route::get('/{id}/edit', 'LicenseController@edit')->name('edit');
    // Route::put('/{id}/edit', 'LicenseController@update')->name('update');
    // Route::post('/send-key', 'LicenseController@postSendKey')->name('post-send-key');


    Route::delete('/destroy/{id}/destroy', 'LicenseController@destroy')->name('destroy')->middleware(['pms:delete-key']); // đã convert
    Route::post('/editEmail', 'LicenseController@editEmail')->name('editEmail'); // đã convert
    Route::post('/editName', 'LicenseController@editName')->name('editName'); // đã convert
    Route::post('/editPhone', 'LicenseController@editPhone')->name('editPhone'); // đã convert


    Route::group(['prefix' => 'export', 'as' => 'export.'], function() {
        Route::post('sendEmailToday', 'ExportLicenseController@sendEmailToday')->name('sendEmailToday'); // đã convert
    });
});



Route::group(['prefix' => 'settings', 'as' => 'settings.'], function() {
    Route::get('email', 'SettingController@email')->name('email'); // đã convert
    Route::post('email', 'SettingController@updateEmail')->name('update-email'); // đã convert

    Route::get('system', 'SettingController@system')->name('system'); // đã convert
    Route::post('system', 'SettingController@updateSystem')->name('update-system'); // đã convert

    Route::get('api', 'SettingController@api')->name('api'); // đã convert
    Route::post('api', 'SettingController@createApi')->name('createApi'); // đã convert
    Route::delete('api/{id}', 'SettingController@deleteApi')->name('deleteApi'); // đã convert
    Route::get('api/{id}', 'SettingController@editApi')->name('editApi'); // đã convert
    Route::put('api/{id}', 'SettingController@updateApi')->name('updateApi'); // đã convert
});


Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('password/reset-password', 'UsersController@resetPassword')->name('reset-password'); // đã convert
    Route::post('password/reset-password', 'UsersController@updatePassword')->name('update-password'); // đã convert

    Route::get('profile/edit', 'UsersController@editProfile')->name('edit-profile'); // đã convert
    Route::post('profile/edit', 'UsersController@updateProfile')->name('update-profile'); // đã convert

    Route::post('{id}/change-password-user', 'UsersController@postEditPassword')->name('postEditPassword'); // đã convert
});


Route::group(['prefix' => 'email', 'as' => 'email.'], function () {
    Route::get('/', 'EmailController@index')->name('index'); // đã convert
    Route::get('/{product_id}/edit', 'EmailController@edit')->name('edit'); // đã convert
    Route::post('/{product_id}/update', 'EmailController@update')->name('update'); // đã convert
});

Route::group(['prefix' => 'mailcontent', 'as' => 'mailcontent.'], function () {
    Route::get('/', 'MailcontentController@list')->name('list'); // đã convert
    Route::get('/{type}', 'MailcontentController@index')->name('index'); // đã convert
    Route::post('/{type}/update', 'MailcontentController@update')->name('update'); // đã convert
});


Route::group(['prefix' => 'chart', 'as' => 'chart.'], function () {
    Route::get('/region', 'ChartController@region')->name('region');
    Route::get('/user', 'ChartController@users')->name('user');
    
    Route::get('/usersDetail/delete/{id}', 'ChartController@usersDetailDelete')->name('usersDetail-delete'); // đã convert
    Route::get('/expiredCustomer', 'ChartController@expiredCustomer')->name('expiredCustomer'); // đã convert
    Route::get('/expiredBeforeCustomer', 'ChartController@expiredBeforeCustomer')->name('expiredBeforeCustomer'); // đã convert
    Route::get('/courseLicense', 'ChartController@courseLicense')->name('courseLicense'); // đã convert
    Route::get('/kpi','ChartController@kpi')->name('kpi'); // đã convert
});

Route::group(['prefix' => 'statistic', 'as' => 'statistic.'], function () {
    Route::post('/edit-note', 'StatisticController@editNote')->name('edit-note'); // đã convert
    Route::get('/product','StatisticController@product')->name('product')->middleware(['pms:statistic']); // đã convert
    Route::get('/time','StatisticController@time')->name('time')->middleware(['pms:statistic']); // đã convert
    Route::get('/local','StatisticController@local')->name('local')->middleware(['pms:statistic']); // đã convert
    Route::get('/vacc','StatisticController@vacc')->name('vacc')->middleware(['pms:statistic']); // đã convert
    Route::post('/update-status-vacc-vace', 'StatisticController@updateStatus')->name('update-status-vacc-vace'); // đã convert
    Route::get('/vace','StatisticController@vace')->name('vace')->middleware(['pms:statistic']); // đã convert
    Route::get('/usersDetail', 'StatisticController@usersDetail')->name('usersDetail'); // đã convert
    Route::get('/consolidated', 'StatisticController@consolidated')->name('consolidated'); // đã convert
    Route::post('/update-salary', 'StatisticController@updateSalary')->name('update-salary'); // đã convert
    Route::post('/update-salary-item', 'StatisticController@updateSalaryItem')->name('update-salary-item'); // đã convert
    Route::post('/update-certificate-item', 'StatisticController@updateCertificateItem')->name('update-certificate-item'); // đã convert
});

Route::resource('/user', 'UsersController'); // đã convert

Route::resource('/feedback', 'FeedbackController'); // đã convert

Route::group(['prefix' => 'request', 'as' => 'request.'], function() {
    Route::get('/', 'RequestController@index')->name('index')->middleware(['pms:license-approved']); // đã convert
    Route::get('/print/{orderId}', 'RequestController@print')->name('print'); // đã convert
    Route::get('/myRequest', 'RequestController@myRequest')->name('myRequest'); // đã request
    Route::post('/approve', 'RequestController@approve')->name('approve')->middleware(['pms:license-approved']); // đã convert
    Route::get('/create', 'RequestController@create')->name('create'); // đã convert
    Route::post('/', 'RequestController@store')->name('store'); // đã convert
    Route::delete('/{id}', 'RequestController@destroy')->name('destroy'); // đã convert
    Route::post('/approveAll/{type}', 'RequestController@approveAll')->name('approveAll'); // đã convert
    Route::get('/{id}/edit', 'RequestController@edit')->name('edit'); // đã convert
    Route::put('/{id}/edit', 'RequestController@update')->name('update');
    Route::delete('/{id}/delete', 'RequestController@delete')->name('delete'); // đã convert
});

Route::group(['prefix' => 'backup', 'as' => 'backup.', 'middleware' => ['pms:backup']], function(){
    Route::get('/', 'BackupController@index')->name('index'); // đã convert
    Route::get('/download/{filename}', 'BackupController@download')->name('download'); // đã convert
    Route::get('/delete/{filename}', 'BackupController@destroy')->name('destroy'); // đã convert
});


//die('xxx');