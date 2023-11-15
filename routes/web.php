<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\agentController;
use App\Http\Controllers\userController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\backend\propertyTypeController;
use App\Http\Controllers\backend\propertyController;

Route::get('/',[homeController::class,'homePage']);
Route::get('/admin/login',[adminController::class, 'adminLogin'])->name('admin.login');

// Admin group middleware start
Route::middleware(['auth','role:admin'])->group(function(){
   
    Route::get('/admin/dashboard', [adminController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [adminController::class, 'destroy'])->name('admin.logout');
    Route::get('/admin/profile', [adminController::class, 'adminProfile'])->name('admin.profile');
    Route::post('/admin/profile/update', [adminController::class, 'adminProfileUpdate'])->name('admin.profile.update');
    Route::get('/admin/change/password', [adminController::class, 'adminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [adminController::class, 'adminUpdatePassword'])->name('admin.password.update');

});
// Admin group middleware end

// agent grouop middleware start
Route::middleware(['auth','role:agent'])->group(function(){
   Route::get('/agent/dashboard', [agentController::class, 'agentDashboard'])->name('agent.dashboard');
   Route::get('/agent/logout', [agentController::class, 'destroy'])->name('agent.logout');
});
// agent group middleware end

// user group middleware start

Route::middleware(['auth','role:user'])->group(function(){
    Route::get('/user/dashboard', [userController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/user/profile/edit', [userController::class, 'userProfileEdit'])->name('user.profile.edit');
    Route::post('/user/profile/update', [userController::class, 'userProfileUpdate'])->name('user.profile.update');
    Route::get('/user/change/password', [userController::class, 'userChangePassword'])->name('user.change.password');
    Route::post('/user/password/update', [userController::class, 'userPasswordUpdate'])->name('user.password.update');
    Route::get('/user/logout', [userController::class, 'destroy'])->name('user.logout');
});

// user group middleware end
require __DIR__.'/auth.php';



// propertyTypeController group route start

Route::middleware(['auth','role:admin'])->group(function(){
   
    Route::get('/admin/dashboard', [adminController::class, 'adminDashboard'])->name('admin.dashboard');

    route::controller(propertyTypeController::class)->group(function(){

        route::get('/all/type','allType')->name('all.type');
        route::get('/add/type','addType')->name('add.type');
        route::post('/store/type','storeType')->name('store.type');
        route::get('/edit/type/{id}','editType')->name('edit.type');
        route::get('/add/type/{id}','deleteType')->name('delete.type');
        route::post('/update/type','updateType')->name('update.type');


     
    });
// routes for amenities
    route::controller(propertyTypeController::class)->group(function(){

        route::get('/all/amenities','allAmenities')->name('all.amenities');
        route::get('/add/amenities','addAmenities')->name('add.amenities');
        route::post('/store/amenities','storeAmenities')->name('store.amenities');
        route::get('/edit/amenities/{id}','editAmenities')->name('edit.amenities');
        route::get('/delete/amenities/{id}','deleteAmenities')->name('delete.amenities');
        route::post('/update/amenities','updateAmenities')->name('update.amenities');


     
    });
    // / routes for property
    route::controller(propertyController::class)->group(function(){

        route::get('/all/property','allProperty')->name('all.property');
        route::get('/add/property','addProperty')->name('add.property');
        route::post('/store/property','storeProperty')->name('store.property');
        route::get('/edit/property/{id}','editProperty')->name('edit.property');
        route::post('/update/property','updateProperty')->name('update.property');
        route::get('/details/property/{id}','detailsProperty')->name('details.property');
       
        route::post('/update/property/thumnail','updatePropertyThumnail')->name('update.property.thumnail');
        route::post('/update/property/multiimage','updatePropertyMultiimage')->name('update.property.multiimage');
        route::get('/property/multiimage/delete/{id}','deletePropertyMultiimage')->name('property.multiimage.delete');
        route::post('/store/new/multiimage','storeNewMultiimage')->name('store.new.multiimage');
        route::post('/update/property/facilities','updatePropertyFacilities')->name('update.property.facilities');
        route::get('/delete/property/{id}','deleteProperty')->name('delete.property');
        route::post('/inactive/property','inactiveProperty')->name('inactive.property');
        route::post('/active/property','activeProperty')->name('active.property');

        
     
    });
    
});
// propertyTypeController group route end