<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Session;
use App\Models\User;
use App\Models\Car;

class CollectionController extends BaseController
{
    
    public function home(){
        //controllo accesso
        if(!Session::get('user_id')){
            return redirect('login');
        }
        //leggo dati utente
        $user= User::find(Session::get('user_id'));
        
        return view('home')->with('user', $user);
    }

    public function carica_loghi(){
        //controllo accesso
        if(!Session::get('user_id')){
            return [];
        }

        $client_id= env('UNSPLASH_CLIENT_ID');
        $curl= curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://vpic.nhtsa.dot.gov/api/vehicles/getallmakes?format=json");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res_1= curl_exec($curl);
        curl_close($curl);
        $obj= json_decode($res_1);
        $marche= array();
        $max=30;
        //seleziono marche
        for($i=0; $i<$max; $i++){
           $marche[$i]["Make_ID"]= $obj->Results[$i]->Make_ID;
           $marche[$i]["Make_Name"]= $obj->Results[$i]->Make_Name;
        }
        //assegno un url del logo per ogni marca
        $multicurl= array();
        $mh= curl_multi_init();
        for($i=0; $i<$max; $i++){
            $dati= urlencode($marche[$i]["Make_Name"]." emblem");
            $multicurl[$i]= curl_init();
            //da imsea
            curl_setopt($multicurl[$i], CURLOPT_URL, "https://imsea.herokuapp.com/api/1?q=".$dati);
            curl_setopt($multicurl[$i], CURLOPT_RETURNTRANSFER, 1);
            
            //da unsplash
            /*$url = 'https://api.unsplash.com/search/photos?per_page=2&client_id='.$client_id.'&query='.$dati;
            curl_setopt($multicurl[$i], CURLOPT_URL, $url);
            curl_setopt($multicurl[$i], CURLOPT_RETURNTRANSFER, 1);*/
        
            curl_multi_add_handle($mh,$multicurl[$i]);
        }
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);
        for($i=0; $i<$max; $i++) {
            $results[$i] = curl_multi_getcontent($multicurl[$i]);
            curl_multi_remove_handle($mh, $multicurl[$i]);
            curl_close($multicurl[$i]);
            $loghi[$i]= json_decode($results[$i]);

            //da unsplash
            //$marche[$i]["Make_url_logo"]= $loghi[$i]->results[0]->urls->regular;

            //da imsea
            $marche[$i]["Make_url_logo"]= $loghi[$i]->results[0];
        }
        curl_multi_close($mh);

        return $marche;
    }

    public function auto_salvate(){
        //controllo accesso
        if(!Session::get('user_id')){
            return redirect('login');
        }

        $user= User::find(Session::get('user_id'));
        
        return view('auto_salvate')->with('user', $user);
    }

    public function carica_auto_salvate(){
        //controllo accesso
        if(!Session::get('user_id')){
            return redirect('login');
        }

        $cars= Car::where('user', Session::get('user_id'))->get();
        
        return $cars;
    }

    public function specifiche_auto($anno, $marca, $modello){
        //controllo accesso
        if(!Session::get('user_id')){
            return redirect('login');
        }

        //leggo dati utente
        $user= User::find(Session::get('user_id'));

        //leggo macchine salvate dall'utente
        $cars= Car::where('user', Session::get('user_id'))->get();

        if ($anno==null || $marca==null || $modello==null){
            $error= "Marca, modello o anno non inseriti!";
            exit;
        } 
        else{
            $client_id= env('UNSPLASH_CLIENT_ID');
            $curl= curl_init();
            $URL= "https://vpic.nhtsa.dot.gov/api/vehicles/GetCanadianVehicleSpecifications/?Year=".urlencode($anno)."&Make=".urlencode($marca)."&Model=".urlencode($modello)."&units=&format=json";
            curl_setopt($curl, CURLOPT_URL, $URL);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $res= curl_exec($curl);
            curl_close($curl);
            $obj= json_decode($res);
            if($obj->Count > 0){
                $length= count($obj->Results[0]->Specs);
            }else $length = 0;
            //Carico immagine auto

            //da imsea
            $URL_img= "https://imsea.herokuapp.com/api/1?q=".urlencode($marca." ".$modello." ".$anno);

            //da unsplash
            //$URL_img= 'https://api.unsplash.com/search/photos?per_page=2&client_id='.$client_id.'&query='.urlencode($marca." ".$modello/*." ".$anno*/);
            $curl_img= curl_init();
            curl_setopt($curl_img, CURLOPT_URL, $URL_img);
            curl_setopt($curl_img, CURLOPT_RETURNTRANSFER, 1);
            $res_img= curl_exec($curl_img);
            curl_close($curl_img);
            $obj_img= json_decode($res_img);
            //$img= $obj_img->results[0]->urls->regular;
            $img= $obj_img->results[0];

            $saved= false;
            foreach($cars as $car){
                if($car["marca"]==$marca && $car["modello"]==$modello && $car["anno"]==$anno){
                    $saved=true;
                }
            }
        }
        
        return view('specifiche_auto')->with('user', $user)
                                      ->with('obj', $obj)
                                      ->with('anno', $anno)
                                      ->with('marca', $marca)
                                      ->with('modello', $modello)
                                      ->with('img', $img)
                                      ->with('length', $length)
                                      ->with('saved', $saved);
    }

    public function save_car(){
        //controllo accesso
        if(!Session::get('user_id')){
            return redirect('login');
        }

        //leggo dati utente
        $user= User::find(Session::get('user_id'));

        //leggo macchine salvate dall'utente
        $cars= Car::where('user', Session::get('user_id'))->get();

        foreach($cars as $car){
            if($car["marca"]==request("marca") && $car["modello"]==request("modello") && $car["anno"]==request("anno")){ 
                //auto già salvata, quindi la devo eliminare dalle auto salvate
                $car->delete();
                $returndata = array('ok' => true, 'n_car_saved' => $user->n_car_saved-1, 'operation' => 'unsaved');
                return $returndata;
            }
        }

        //altrimenti salvo auto
        $new_car= new Car;
        $new_car->user= Session::get('user_id');
        $new_car->marca= request('marca');
        $new_car->modello= request('modello');
        $new_car->anno= request('anno');
        $new_car->img= request('img');
        $new_car->save();

        $returndata = array('ok' => true, 'n_car_saved' => $user['n_car_saved']+1, 'operation' => 'saved');
        return $returndata;
    }

}
?>