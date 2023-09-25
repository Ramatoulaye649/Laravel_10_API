<?php

namespace App\Http\Controllers\Api;
use App\Http\Requests\LoguserRequest;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResisterUser;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(ResisterUser $request){


        try {
            $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password,[
            'rounds'=>12
        ]) ;
        $user->save();
            return response()->json([
                'status_code'=>200,
                'status_message'=>'lutilisateur enregistré avec succès',
                'user'=>$user
    
            ]);
    
           } catch (Exception $e){
    
            return response()->json(['error' => 'Une erreur est produite'], 500);
    
           
        }



       
        

    }

    public function login(LoguserRequest $request){

       if(auth()->attempt($request->only(['email','password']))){
        $user=auth()->user();
        $token=$user->createToken('ma_cle_secrete_visible_uniquement_au_backen')->plainTextToken;
        return response()->json([
            'status_code'=>200,
            'status_message'=>'utilisateur connecté avec succès',
            'user'=>$user,
            'token'=>$token
            
          


        ]);

       }else{
        return response()->json([
            'status_code'=>403,
            'status_message'=>'information non valide',
            
          


        ]);

       }
    }
}
