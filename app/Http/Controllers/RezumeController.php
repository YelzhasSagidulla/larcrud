<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rezume;
use App\Vacancy;

class RezumeController extends Controller
{
    public function index() {
        $rezumes = Rezume::select('id','jobname','vacancy','experience','fullname','educationlevel',
                'educationname','skills','contacts')->orderBy('id', 'asc')->get();          
        $vacancies = Vacancy::select('id','name','description')->get();          
        
        
        
        return view('rezume')->with(['rezumes'=>$rezumes,'vacancies'=>$vacancies]);
    }
    //Добавление
    public function create(Request $request) {                
        $rezume = new Rezume;
        $rezume->jobname = $request->jobname;
        $rezume->vacancy = $request->vacancy;
        $rezume->experience = $request->experience;
        $rezume->fullname = $request->fullname;
        $rezume->educationlevel = $request->educationlevel;
        $rezume->educationname = $request->educationname;
        $rezume->skills = $request->skills;
        $rezume->contacts = $request->contacts;
        $rezume->save();        
        echo json_encode($rezume);           
    }
    //Редактирование
    public function edit(Request $request) {        
        $rezume = Rezume::find($request->id);
        $rezume->jobname = $request->jobname;
        $rezume->vacancy = $request->vacancy;
        $rezume->experience = $request->experience;
        $rezume->fullname = $request->fullname;
        $rezume->educationlevel = $request->educationlevel;
        $rezume->educationname = $request->educationname;
        $rezume->skills = $request->skills;
        $rezume->contacts = $request->contacts;
        echo json_encode($rezume);        
        $rezume->save();
    }
    
}
