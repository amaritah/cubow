<?php

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

Route::get('/', function () {
    return view('welcome');
});

/*
 * Mediante Auth::user() conocemos si el usuario está loggeado. 
 * En caso de que no esté loggeado, le obligamos a ello devolviendo la vista de login. 
 * En caso de que ya esté loggeado, le devolvemos la vista del panel de administración. 
 */
Route::get('admin', function () {
    if (Auth::user()){
        if (Auth::user()->role_id == 1){
            return view('admin.index');
        } else{
            return redirect('/admin/rooms');
        }
    } else {
        return view('admin.login');
    }
})->name('admin');

Route::group(['namespace' => 'Admin' , 'middleware' => 'auth'], function () {
    /*
     *  Rutas relativas a la administración de usuarios (CRUD) 
     */
    Route::get('admin/users', 'UserController@index')->name('admin.users');
    Route::get('admin/user/new', 'UserController@detail')->name('admin.users.new');
    Route::get('admin/user/{id}/edit', 'UserController@detail')->name('admin.users.edit');
    Route::post('admin/user/{id}', 'UserController@update')->name('admin.users.update');
    Route::delete('admin/user/{id}', 'UserController@destroy')->name('admin.users.destroy');
    Route::post('admin/user', 'UserController@store')->name('admin.users.store');
    /*
     * Perfil de usuario, disponible para todos.
     */
    Route::get('admin/profile', 'UserController@profile')->name('profile');
    /*
     * Rutas relativas a la administración de pisos
     */
    Route::get('admin/floors', 'FloorController@index')->name('admin.floors');
    Route::get('admin/floors/new', 'FloorController@detail')->name('admin.floors.new');
    Route::get('admin/floors/{id}/edit', 'FloorController@detail')->name('admin.floors.edit');
    Route::post('admin/floors/{id}', 'FloorController@update')->name('admin.floors.update');
    Route::delete('admin/floors/{id}', 'FloorController@destroy')->name('admin.floors.destroy');
    Route::post('admin/floors', 'FloorController@store')->name('admin.floors.store');
    
    /*
     * Rutas relativas a la administración de salas
     */
    Route::get('admin/rooms', 'RoomController@index')->name('admin.rooms');
    //Route::get('admin/rooms/new', 'RoomController@detail')->name('admin.rooms.new');
    Route::get('admin/rooms/{id}/edit', 'RoomController@detail')->name('admin.rooms.edit');
    Route::post('admin/rooms/{id}', 'RoomController@update')->name('admin.rooms.update');
    Route::delete('admin/rooms/{id}', 'RoomController@destroy')->name('admin.rooms.destroy');
    Route::post('admin/rooms', 'RoomController@store')->name('admin.rooms.store');
    /*
     * Rutas de subida de imágenes de sala. Basándome en https://appdividend.com/2018/05/31/laravel-dropzone-image-upload-tutorial-with-example/
     */
    Route::post('roomimages/upload/store/{id}','RoomController@fileStore')->name('admin.rooms.imageUpload');
    Route::post('roomimages/delete','RoomController@fileDestroy')->name('admin.rooms.imageDelete');
    
    /* 
     * Rutas relativas a la administración de promociones
     */
    Route::get('admin/promotions', 'PromotionController@index')->name('admin.promotions');
    Route::get('admin/promotions/new', 'PromotionController@detail')->name('admin.promotions.new');
    Route::get('admin/promotions/{id}/edit', 'PromotionController@detail')->name('admin.promotions.edit');
    Route::post('admin/promotions/{id}', 'PromotionController@update')->name('admin.promotions.update');
    Route::delete('admin/promotions/{id}', 'PromotionController@destroy')->name('admin.promotions.destroy');
    Route::post('admin/promotions', 'PromotionController@store')->name('admin.promotions.store');
    /*
     * Rutas de subida de imágenes de promoción. Basándome en https://appdividend.com/2018/05/31/laravel-dropzone-image-upload-tutorial-with-example/
     */
    Route::post('promotionimages/upload/store/{id}','PromotionController@fileStore')->name('admin.promotions.imageUpload');
    Route::post('promotionimages/delete','PromotionController@fileDestroy')->name('admin.promotions.imageDelete');
});

Auth::routes(['register' => false]);
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
/*
 * Redefinimos el login, para no mostrar el de Laravel.
 */
Route::get('login', function () {
    if (Auth::user()){
        return view('admin.index');
    } else {
        return view('admin.login');
    }
})->name('login');