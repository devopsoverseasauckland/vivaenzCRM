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

//Route::get('/login', 'PagesController@login');

//Route::get('/index', 'PagesController@index');

Route::get('/gestionSeguimiento', 'PagesController@gestionSeguimiento');

//Route::get('/nuevaAsesoria', 'PagesController@nuevaAsesoria');

Route::get('/reporteSeguimiento', 'PagesController@reporteSeguimiento');

Route::resource('advisory', 'AdvisoryController');

Route::post('advisory/storeStep1', 'AdvisoryController@storeStep1');

//sRoute::post('advisory/storeStep2', 'AdvisoryController@storeStep2');

//Route::post('advisory/storeStep3', 'AdvisoryController@storeStep3');

Route::get('/editStep1/{id}', 'AdvisoryController@editStep1')->name('advisory.editStep1');

Route::get('/editStep2/{id}', 
//function($name) 
//{
//    return 'User Name is ' . $name;
//});
'AdvisoryController@editStep2')->name('advisory.editStep2');

Route::get('/editStep3/{id}', 'AdvisoryController@editStep3')->name('advisory.editStep3');


Route::match(['put', 'match'], '/updateStep1/{id}', 'AdvisoryController@updateStep1')->name('advisory.updateStep1');

Route::match(['put', 'match'], '/updateStep2/{id}', 'AdvisoryController@updateStep2')->name('advisory.updateStep2');

Route::match(['put', 'match'], '/updateStep3/{id}', 'AdvisoryController@updateStep3')->name('advisory.updateStep3');

Route::match(['put', 'match'], '/finalizar/{id}', 'AdvisoryController@finalizar')->name('advisory.finalizar');

Route::get('combo/institutions', 'ComboController@institutions')->name('combo.institutions');

Route::get('combo/advisories', 'ComboController@advisories')->name('combo.advisories');

Route::get('combo/advisoryProcess', 'ComboController@advisoryProcess')->name('combo.advisoryProcess');

Route::get('combo/cities', 'ComboController@cities')->name('combo.cities');

Route::get('combo/citiesPagination', 'ComboController@citiesPagination')->name('combo.citiesPagination');


Route::post('advisoryInfoSent/registerDocument', 'AdvisoryInfoSentController@registerDocument')->name('advisoryInfoSent.registerDocument');

Route::post('advisoryInfoSent/deleteDocument', 'AdvisoryInfoSentController@deleteDocument')->name('advisoryInfoSent.deleteDocument');

Route::post('studentExperience/registerExperience', 'StudentExperienceController@registerExperience')->name('studentExperience.registerExperience');

Route::post('studentExperience/deleteExperience', 'StudentExperienceController@deleteExperience')->name('studentExperience.deleteExperience');

Route::post('advisoryProcess/registerDate', 'AdvisoryProcessController@registerDate')->name('advisoryProcess.registerDate');

//Route::post('authorization/login', 'AuthorizationController@login')->name('authorization.login');

Auth::routes();


Route::get('/advisory', 'AdvisoryController@index');


Route::resource('coursetype','CourseTypeController');

Route::post('coursetype/registerInstitution', 'CourseTypeController@registerInstitution')->name('coursetype.registerInstitution');

Route::post('coursetype/deleteInstitution', 'CourseTypeController@deleteInstitution')->name('coursetype.deleteInstitution');


Route::resource('institution','InstitutionController');

Route::resource('profession', 'ProfessionController');

Route::resource('country', 'CountryController');

Route::resource('city', 'CityController');



Route::post('studentInsuranceHistory/register', 'StudentInsuranceHistoryController@register')->name('studentInsuranceHist.register');

Route::post('studentInsuranceHistory/update', 'StudentInsuranceHistoryController@update')->name('studentInsuranceHist.update');

Route::get('studentInsuranceHistory/get', 'StudentInsuranceHistoryController@get')->name('studentInsuranceHist.get');


Route::post('studentVisaHistory/register', 'StudentVisaHistoryController@register')->name('studentVisaHist.register');

Route::post('studentVisaHistory/update', 'StudentVisaHistoryController@update')->name('studentVisaHist.update');

Route::get('studentVisaHistory/get', 'StudentVisaHistoryController@get')->name('studentVisaHist.get');