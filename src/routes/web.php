<?php

Route::group(
    [
        'namespace' => 'Raosys\\Fees\\Http\\Controllers',
        'prefix' => 'fees',
        'middleware' => ['web', 'auth']
    ],
    function () {
        Route::name('fees.')->group(function () {
            Route::get('/', 'FeeAdminController@index')->name('dashboard');
            Route::resource('structure', FeeStructureController::class);
            Route::resource('entries', EntryItemController::class);
            Route::resource('students', StudentController::class);
            Route::get('profile', 'FeeProfileController@profile')->name('profile');
        });
    }
);
