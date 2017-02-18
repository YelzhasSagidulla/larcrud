<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specialty;

class SpecialtyController extends Controller
{
    public function index() {
        $specialties = Specialty::select('id','name')->orderBy('id', 'asc')->get();          
        
        return view('specialty')->with(['specialties'=>$specialties]);
    }
    //Добавление
    public function create(Request $request){
        $specialty = new Specialty;
        $specialty->name = $request->name;
        $specialty->save();        
        echo json_encode($specialty);  
    }
    //Редактирование
    public function edit(Request $request) {        
        $specialty = Specialty::find($request->id);
        $specialty->name = $request->name;
        echo json_encode($specialty);        
        $specialty->save();
    }
}
