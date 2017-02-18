<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vacancy;

class VacancyController extends Controller
{    
    public function index() {
        
        $vacancies = Vacancy::select('id','name','description')->get();          
        
        return view('vacancies')->with(['vacancies'=>$vacancies]);
    }
    //Добавление
    public function create(Request $request) {                
        $vacancy = new Vacancy;
        $vacancy->name = $request->name;
        $vacancy->description = $request->description;
        $vacancy->contacts = $request->contacts;
        $vacancy->address = $request->address;
        $vacancy->save();        
        echo json_encode($vacancy);           
    }
    //Редактирование
    public function edit(Request $request) {        
        $vacancy = Vacancy::find($request->id);
        $vacancy->name = $request->name;
        $vacancy->description = $request->description;
        $vacancy->contacts = $request->contacts;
        $vacancy->address = $request->address;
        echo json_encode($vacancy);        
        $vacancy->save();
    }
}
