<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Session;
use App\Models\User;

class LoginController extends BaseController
{
    
    public function register_form(){
        if(Session::get('user_id')){
            return redirect('home');
        }
        $error= Session::get('error');
        Session::forget('error');
        return view('register')->with('error', $error);
    }

    public function do_register(){
        if(Session::get('user_id')){
            return redirect('home');
        }
        //verifica dati

        if(strlen(request('username'))>0 && strlen(request('password'))>0 && strlen(request('email'))>0 && 
           strlen(request('name'))>0 && strlen(request('surname'))>0 && strlen(request('confirm_password'))>0 
           && strlen(request('allow'))>0){
               //username
               if(User::where('username', request('username'))->first()){
                   Session::put('error', 'username_già_utilizzato');
                   return redirect('register')->withInput();
               }
               //password
               if(strlen(request('password')) < 8){
                   Session::put('error', 'password_corta');
                   return redirect('register')->withInput();
               }
               //conferma password
               if(strcmp(request('password'), request('confirm_password')) !=0 ){
                Session::put('error', 'password_non_coincidenti');
                return redirect('register')->withInput();
               }
               //email
               if(User::where('email', strtolower(request('email')))->first()){
                   Session::put('error', 'email_già_utilizzata');
                   return redirect('register')->withInput();
               }
        }else{
            Session::put('error', 'campi_vuoti');
            return redirect('register')->withInput();
        }

        //creazione utente

        $user= new User;
        $user->username= request('username');
        $user->password= password_hash(request('password'), PASSWORD_BCRYPT);
        $user->email= request('email');
        $user->name= request('name');
        $user->surname= request('surname');
        $user->save();

        //login

        Session::put('user_id', $user->id);

        //redirect alla home

        return redirect('home');
    }

    public function logout(){
        Session::flush();
        return redirect('login');
    }

    public function login_form(){
        if(Session::get('user_id')){
            return redirect('home');
        }
        $error= Session::get('error');
        Session::forget('error');
        return view('login')->with('error', $error);
    }

    public function do_login(){
        if(Session::get('user_id')){
            return redirect('home');
        }

        if(strlen(request('username'))>0 && strlen(request('password'))>0){
            $user= User::where('username', request('username'))->first();
            if(!$user || !password_verify(request('password'), $user->password)){
                Session::put('error', 'errati');
                return redirect('login')->withInput();
            }
            
        }else{
            Session::put('error', 'campi_vuoti');
            return redirect('login')->withInput();
        }

        //login

        Session::put('user_id', $user->id);

        //redirect alla home

        return redirect('home');
    }
}
?>