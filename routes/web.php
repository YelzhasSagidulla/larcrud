<?php

Route::get('/', 'IndexController@index')->name('main');

//User auth
Route::post('auth','IndexController@auth')->name('userAuth');

//User logout
Route::post('logout', function(){      
    unset($_SESSION['user']);
    return redirect('/');    
})->name('userLogout');

//ВАКАНСИИ
Route::get('vacancies','VacancyController@index')->name('vacancy');
Route::get('vacancy/{vacancy_id?}',function($vacancy_id){
    $vacancy = App\Vacancy::find($vacancy_id);
    return response()->json($vacancy);
});
//Добавление
Route::post('addvacancy','VacancyController@create');
//Редактирование
Route::post('editvacancy','VacancyController@edit');
//Удаление
Route::delete('deletevacancy/{vacancy_id?}',function($vacancy_id){
    $vacancy = App\Vacancy::destroy($vacancy_id);
    return response()->json($vacancy);
});


//РУБРИКИ
Route::get('rubrics','RubricsController@index')->name('rubrics');
Route::get('rubric/{rubric_id?}',function($rubric_id){
    $rubric = App\Rubric::find($rubric_id);
    return response()->json($rubric);
});
//Добавление
Route::post('addrubric','RubricsController@create');
//Редактирование
Route::post('editrubric','RubricsController@edit');
//Удаление
Route::delete('deleterubric/{rubric_id?}',function($rubric_id){
    $rubric = App\Rubric::destroy($rubric_id);
    return response()->json($rubric);
});


//Резюме
Route::get('rezume','RezumeController@index')->name('rezume');
Route::get('rezume/{rezume_id?}',function($rezume_id){
    $rezume = App\Rezume::find($rezume_id);
    return response()->json($rezume);
});
//Добавление
Route::post('addrezume','RezumeController@create');
//Редактирование
Route::post('editrezume','RezumeController@edit');
//Удаление
Route::delete('deleterezume/{rezume_id?}',function($rezume_id){
    $rezume = App\Rezume::destroy($rezume_id);
    return response()->json($rezume);
});


//Специальности
Route::get('specialties','SpecialtyController@index')->name('specialty');
Route::get('specialty/{specialty_id?}',function($specialty_id){
    $specialty = App\Specialty::find($specialty_id);
    return response()->json($specialty);
});
//Добавление
Route::post('addspecialty','SpecialtyController@create');
//Редактирование
Route::post('editspecialty','SpecialtyController@edit');
//Удаление
Route::delete('deletespecialty/{specialty_id?}',function($specialty_id){
    $specialty = App\Specialty::destroy($specialty_id);
    return response()->json($specialty);
});


//ВАКАНСИИ КОМПАНИИ
//Список компании
Route::get('companyvacancies','CompanyvacancyController@index')->name('companyvacancies');
//Вакансии одной компании
Route::get('company/{company_name}','CompanyvacancyController@show')->name('companyshow');





