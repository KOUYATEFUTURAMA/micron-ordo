<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Route::get('/confirmer_compte/{id}/{token}', 'Auth\RegisterController@confirmationCompte');
Route::post('/update_password', 'Auth\RegisterController@updatePassword')->name('update_password');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//les routes du module Parrametre 
Route::namespace('Parametre')->middleware('auth')->name('parametre.')->prefix('parametre')->group(function () {
    //Route resources
    Route::resource('localites', 'LocaliteController');
    Route::resource('categories', 'CategorieController');
  
    //Autres rooutes 
    Route::get('sous-categorie', 'CategorieController@sousCategorie')->name('categories.sous-categorie');

    //Route pour les listes dans boostrap table
    Route::get('liste-localites', 'LocaliteController@listeLocalite')->name('liste-localites');
    Route::get('liste-categories', 'CategorieController@listeCategorie')->name('liste-categories');
    Route::get('liste-sous-categories', 'CategorieController@listeSousCategorie')->name('liste-sous-categories');
});

//les routes du module Auth 
Route::namespace('Auth')->middleware('auth')->name('auth.')->prefix('auth')->group(function () {
    //Route resources
    Route::resource('users', 'UserController');
    
    //Autres routes
    Route::get('profil-user', 'UserController@profil')->name('user.profil');
    Route::put('profil/update/{user}', 'UserController@updateProfil')->name('user.profil.update');
    Route::post('password-reset-by-admin', 'UserController@resetPasswordManualy')->name('user.password-reset-by-admin');
    
    //Route pour les listes dans boostrap table resetPasswordManualy
    Route::get('liste-users', 'UserController@listeUser')->name('liste-users');
});