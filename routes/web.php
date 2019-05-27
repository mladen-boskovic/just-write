<?php
/*-----regularni izrazi-----*/
Route::pattern('id', '[0-9]+');
Route::pattern('korisnikID', '[0-9]+');
Route::pattern('objavaID', '[0-9]+');
Route::pattern('token', '[\w\d]{32}');


/*-----nepostojeća stranica i error-----*/
Route::fallback('FrontEndController@fallback');
Route::get('/error', 'FrontEndController@error')->name('errorpage')->middleware('errorPageProvera');



/*-----registracija, prijava, odjava (prikaz i logika)-----*/
Route::get('/register', 'FrontEndController@register')->name('registerpage')->middleware('korisnikPrijavljenProvera');
Route::post('/register', 'RegisterLoginController@registracija')->name('registracija');
Route::get('/login', 'FrontEndController@login')->name('loginpage')->middleware('korisnikPrijavljenProvera');
Route::post('/login', 'RegisterLoginController@prijava')->name('prijava');
Route::get('/logout', 'RegisterLoginController@odjava')->name('odjava')->middleware('korisnikNijePrijavljenProvera');
Route::get('/activate/{token}', 'RegisterLoginController@activate')->name('aktivacija')->middleware('korisnikPrijavljenProvera');



/*-----resetovanje lozinke (prikaz i logika)-----*/
Route::put('/resetpassword/emailcheck', 'ChangePasswordController@resetLozinkeEmailProvera')->name('resetLozinkeEmailProvera');
Route::get('/resetpassword/{token}', 'ChangePasswordController@resetLozinkeTokenProvera')->name('resetLozinkeTokenProvera')->middleware('korisnikPrijavljenProvera');
Route::get('/resetpassword', 'FrontEndController@resetpasswordpage')->name('resetpasswordpage')->middleware('resetPasswordTokenProvera', 'korisnikPrijavljenProvera');
Route::put('/resetpassword', 'ChangePasswordController@resetPassword')->name('resetPassword');



/*-----prikaz ostalih stranica-----*/
Route::get('/', 'FrontEndController@home')->name('home');
Route::get('/userprofile/{id}', 'FrontEndController@userprofile')->name('userprofilepage')->middleware('korisnikNijePrijavljenProvera');
Route::get('/addobjavauser', 'FrontEndController@addobjavauser')->name('addobjavauserpage')->middleware('korisnikNijePrijavljenProvera');
Route::get('/updateobjavauser/{id}', 'FrontEndController@updateobjavauser')->name('updateobjavauserpage')->middleware('korisnikNijePrijavljenProvera');
Route::get('/contact', 'FrontEndController@contact')->name('contactpage');
Route::get('/author', 'FrontEndController@author')->name('authorpage');
Route::get('/objava/{objavaID}/{korisnikID}', 'FrontEndController@jednaObjava')->name('jednaObjava');



/*-----stranica 'objave' (prikaz i logika)-----*/
Route::get('/objave', 'FrontEndController@objave')->name('objavepage');
Route::post('/objaveajax', 'FrontEndController@sveobjave')->name('objaveajax');



/*-----promena profilne slike i lozinke (logika)-----*/
Route::put('/userchangesimage', 'UserChangesController@promenaProfilneSlike')->name('promenaProfilneSlike');
Route::put('/changepassword', 'ChangePasswordController@promenaLozinke')->name('promenaLozinke');



/*-----kontakt (logika)-----*/
Route::post('/contactadmin', 'FrontEndController@contactAdmin')->name('contactAdmin');



/*-----admin (prikaz i logika)-----*/
Route::resource('admin/korisnik', 'Admin\KorisnikController')->middleware('adminProvera');
Route::get('/admin', 'FrontEndController@admin')->name('adminhomepage')->middleware('adminProvera');
Route::resource('admin/objava', 'Admin\ObjavaController'); //middleware je u konstruktoru kontrolera
Route::resource('/admin/komentar', 'Admin\KomentarController'); //middleware je u konstruktoru kontrolera
Route::resource('/admin/kategorija', 'Admin\KategorijaController')->middleware('adminProvera');
Route::resource('/admin/aktivnost', 'Admin\AktivnostController')->middleware('adminProvera');



/*-----lajkovanje (logika)-----*/
Route::post('/lajkovanje', 'UserChangesController@lajkovanje')->name('lajkovanje');