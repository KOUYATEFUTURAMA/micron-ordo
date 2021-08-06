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
 Route::post('/password-reset', 'Auth\UserController@resetPassword')->name('user.password-reset');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//les routes du module Parrametre 
Route::namespace('Parametre')->middleware('auth')->name('parametre.')->prefix('parametre')->group(function () {
    //Route resources
    Route::resource('localites', 'LocaliteController');
    Route::resource('categories', 'CategorieController');
    Route::resource('pharmacies', 'PharmacieController');
    Route::resource('hopitals', 'HopitalController');
    Route::resource('modes', 'ModeAdministrationController');
    Route::resource('emballages', 'EmballageController');
    Route::resource('formes', 'FormeController');
    Route::resource('medicaments', 'MedicamentController');
  
    //Autres rooutes  pharmacies.update
    Route::get('sous-categorie', 'CategorieController@sousCategorie')->name('categories.sous-categorie');
    Route::post('update-pharmacie.', 'PharmacieController@pharmacieUpdate')->name('update.pharmacie');
    Route::post('update-hopital.', 'HopitalController@hopitalUpdate')->name('update.hopital');
    Route::post('update-medicament.', 'MedicamentController@medicamentUpdate')->name('update.medicament');

    //Route pour les listes dans boostrap table
    Route::get('liste-hopitals', 'HopitalController@listeHopital')->name('liste-hopitals');
    Route::get('liste-pharmacies', 'PharmacieController@listePharmacie')->name('liste-pharmacies');
    Route::get('liste-localites', 'LocaliteController@listeLocalite')->name('liste-localites');
    Route::get('liste-categories', 'CategorieController@listeCategorie')->name('liste-categories');
    Route::get('liste-sous-categories', 'CategorieController@listeSousCategorie')->name('liste-sous-categories');
    Route::get('liste-modes', 'ModeAdministrationController@listeModeAdministation')->name('liste-modes');
    Route::get('liste-emballages', 'EmballageController@listeEmballage')->name('liste-emballages');
    Route::get('liste-formes', 'FormeController@listeForme')->name('liste-formes');
    Route::get('liste-medicaments', 'MedicamentController@listeMedicament')->name('liste-medicaments');

    //Routes paramétrés 
    Route::get('liste-sous-categories-by-categorie/{categorie}', 'CategorieController@listeSousCategoriesByCategorie');
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