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

//Route::get('/gestionSeguimiento', 'PagesController@gestionSeguimiento');

//Route::get('/nuevaAsesoria', 'PagesController@nuevaAsesoria');

//Route::get('/reporteSeguimiento', 'PagesController@reporteSeguimiento');

Route::get('student/potential', 'StudentController@potential');

Route::post('student/registerPotential', 'StudentController@registerPotential')->name('student.registerPotential');

Route::post('student/deletePotential/{id}', 'StudentController@deletePotential')->name('student.deletePotential');

Route::get('student/getComment', 'StudentController@getComment')->name('student.getComment');

Route::post('student/updateComment', 'StudentController@updateComment')->name('student.updateComment');

Route::post('student/createAdvisory', 'StudentController@createAdvisory')->name('student.createAdvisory');

Route::post('student/registerDateTrack', 'StudentController@registerDateTrack')->name('student.registerDateTrack');



Route::post('advisory/storeStep1', 'AdvisoryController@storeStep1');

Route::resource('advisory', 'AdvisoryController');

Route::post('advisory/storeStep1', 'AdvisoryController@storeStep1');

//Route::post('advisory/storeStep2', 'AdvisoryController@storeStep2');

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

Route::match(['put', 'match'], '/finishEnrollment/{id}', 'AdvisoryController@finishEnrollment')->name('advisory.finishEnrollment');

Route::post('/remove/{id}', 'AdvisoryController@remove')->name('advisory.remove');

Route::post('/extend/{id}', 'AdvisoryController@extend')->name('advisory.extend');




Route::get('report/tracking', 'ReportController@tracking');




Route::get('combo/courseTypeInstitutions', 'ComboController@courseTypeInstitutions')->name('combo.courseTypeInstitutions');

Route::get('combo/institutions', 'ComboController@institutions')->name('combo.institutions');

Route::get('combo/institutionsPagination', 'ComboController@institutionsPagination')->name('combo.institutionsPagination');

Route::get('combo/advisories', 'ComboController@advisories')->name('combo.advisories');

Route::get('combo/advisoriesPagination', 'ComboController@advisoriesPagination')->name('combo.advisoriesPagination');

Route::get('combo/advisoryProcess', 'ComboController@advisoryProcess')->name('combo.advisoryProcess');



Route::get('combo/students', 'ComboController@students')->name('combo.students');

Route::get('combo/studentPagination', 'ComboController@studentPagination')->name('combo.studentPagination');



Route::get('combo/advisoriesTracking', 'ComboController@advisoriesTracking')->name('combo.advisoriesTracking');

Route::get('combo/advisoriesTrackingPaginate', 'ComboController@advisoriesTrackingPaginate')->name('combo.advisoriesTrackingPaginate');

Route::get('combo/advisoriesTrackingPagination', 'ComboController@advisoriesTrackingPagination')->name('combo.advisoriesTrackingPagination');



Route::get('combo/countries', 'ComboController@countries')->name('combo.countries');

Route::get('combo/cities', 'ComboController@cities')->name('combo.cities');

Route::get('combo/citiesPagination', 'ComboController@citiesPagination')->name('combo.citiesPagination');

Route::get('combo/roles', 'ComboController@roles')->name('combo.roles');

Route::get('combo/professions', 'ComboController@professions')->name('combo.professions');


Route::post('advisoryInfoSent/registerDocument', 'AdvisoryInfoSentController@registerDocument')->name('advisoryInfoSent.registerDocument');

Route::post('advisoryInfoSent/deleteDocument', 'AdvisoryInfoSentController@deleteDocument')->name('advisoryInfoSent.deleteDocument');

Route::post('studentExperience/registerExperience', 'StudentExperienceController@registerExperience')->name('studentExperience.registerExperience');

Route::post('studentExperience/deleteExperience', 'StudentExperienceController@deleteExperience')->name('studentExperience.deleteExperience');

Route::post('advisoryProcess/registerDate', 'AdvisoryProcessController@registerDate')->name('advisoryProcess.registerDate');

Route::get('authorization/getMnAdvisories', 'AuthorizationController@getMnAdvisories')->name('authorization.getMnAdvisories');

Route::get('authorization/getMnReports', 'AuthorizationController@getMnReports')->name('authorization.getMnReports');

Route::get('authorization/getMnConfig', 'AuthorizationController@getMnConfig')->name('authorization.getMnConfig');

Auth::routes();


Route::get('/advisory', 'AdvisoryController@index');


Route::resource('coursetype','CourseTypeController');

Route::post('coursetype/registerInstitution', 'CourseTypeController@registerInstitution')->name('coursetype.registerInstitution');

Route::post('coursetype/deleteInstitution', 'CourseTypeController@deleteInstitution')->name('coursetype.deleteInstitution');


Route::resource('institution','InstitutionController');

Route::resource('profession', 'ProfessionController');

Route::post('profession/store', 'ProfessionController@store')->name('profession.store');

Route::resource('country', 'CountryController');

Route::post('country/store', 'CountryController@store')->name('country.store');

Route::resource('city', 'CityController');

Route::post('city/store', 'CityController@store')->name('city.store');




Route::post('studentInsuranceHistory/register', 'StudentInsuranceHistoryController@register')->name('studentInsuranceHist.register');

Route::post('studentInsuranceHistory/update', 'StudentInsuranceHistoryController@update')->name('studentInsuranceHist.update');

Route::get('studentInsuranceHistory/get', 'StudentInsuranceHistoryController@get')->name('studentInsuranceHist.get');


Route::post('studentVisaHistory/register', 'StudentVisaHistoryController@register')->name('studentVisaHist.register');

Route::post('studentVisaHistory/update', 'StudentVisaHistoryController@update')->name('studentVisaHist.update');

Route::get('studentVisaHistory/get', 'StudentVisaHistoryController@get')->name('studentVisaHist.get');



Route::get('studentAdvComment/get', 'StudentAdvCommentController@get')->name('studentAdvComment.get');

Route::post('studentAdvComment/update', 'StudentAdvCommentController@update')->name('studentAdvComment.update');