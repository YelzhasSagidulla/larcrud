<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Companyvacancy;
use App\Companyname;

class CompanyvacancyController extends Controller
{
    public function index(){        
        $companyvacancies = Companyvacancy::select('id','title','description','company_name',
                'status')->where('status', 2)->get();      
        $companyvacancies2 = DB::table('companyvacancies')
            ->leftJoin('Companynames', 'Companynames.name', '=', 'Companyvacancies.company_name')
            ->selectRaw('Companynames.*, count(Companyvacancies.id) as child_count')
            ->groupBy('Companynames.id')
            ->get();     
        
        $companynames = Companyname::select('id','name')->get();                          
        
        return view('companyvacancies')->with(['companyvacancies'=>$companyvacancies,
                                                'companynames'=>$companynames,
                                                'companyvacancies2'=>$companyvacancies2]);
    }
    public function show($company_name) {        
        $companyvacancies = Companyvacancy::select('id','title','description','company_name',
                'status')->where('company_name', $company_name)->get();                            
        
        return view('companyshow')->with(['companyvacancies'=>$companyvacancies,
                                        'company_name'=>$company_name]);
    }
}
