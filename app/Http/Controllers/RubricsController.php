<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rubric;

class RubricsController extends Controller
{    
    public function index() {
        $rubrics = Rubric::select('id','name')->orderBy('id', 'asc')->get();          
        
        return view('rubrics')->with(['rubrics'=>$rubrics]);
    }
    //Добавление
    public function create(Request $request){
        $rubric = new Rubric;
        $rubric->name = $request->name;
        $rubric->save();        
        echo json_encode($rubric);  
    }
    //Редактирование
    public function edit(Request $request) {        
        $rubric = Rubric::find($request->id);
        $rubric->name = $request->name;
        echo json_encode($rubric);        
        $rubric->save();
    }
}
