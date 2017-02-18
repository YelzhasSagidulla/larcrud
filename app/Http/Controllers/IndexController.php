<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class IndexController extends Controller
{
    public function index(){
        return view('home');
    }
    public function auth(Request $request) {
        
        //Сохранение полученных с post данных в $postdata
        $postdata = $request->all();
        //Берем с базы пользователя
        $user = User::select(['id','name','password'])->where('email',$request->email)->first();
        //Если пароли совпадают, то имя админ сохраняем в сессии 
        if(isset($user) && $postdata['password'] == $user->password){            
            $_SESSION['user'] = $user->name;
        }                
       
        return redirect('/');
    }
}
