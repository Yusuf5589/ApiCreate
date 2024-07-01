<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLog;
use App\Repositories\UserRepository;

class LoginController extends Controller
{

    protected $userRepository;


    public function __construct(UserRepository $userRepository){
        $this->UserRepository = $userRepository;
    }
    
    public function valError(){
        return [
            "username.required" => "Kullanıcı adı girmen gerek.",
            "username.min" => "Kullanıcı adı en az 8 karakterli olması gerek.",
            "username.min" => "Kullanıcı adı en fazla 20 karakterli olabilir.",            
            "username.unique" => "Bu kullanıcı adı kullanlıyor.",            
            "password.required" => "Password girmen gerek.",
            "password.min" => "Password en az 8 karakterli olması gerek.",
            "password.min" => "Password en fazla 20 karakterli olabilir.",
        ];
    }

    public function userAdd(Request $req){  
        $req->validate([
            "username" => "required|min:8|max:20|unique:user,username",
            "password" => "required|min:8|max:20",
        ], $this->valError());


        UserLog::create([
            "username" => $req->username,
            "password" => $req->password,
        ]);

        return "Kullanıcı ".$req->username." başarıyla kayıt oldun.";

    }


    public function userGet(){
        $data = $this->UserRepository->getAll();
        return response()->json($data, 200, [],JSON_UNESCAPED_UNICODE);
    }


    public function firstGet($id){
        $datafirst = UserLog::whereId($id)->first();
        return response()->json($datafirst, 200, [],JSON_UNESCAPED_UNICODE);
    }

    public function login(Request $req){

        $req->validate([
            "username" => "required|min:8|max:20",
            "password" => "required|min:8|max:20",
        ], $this->valError());

        $user = UserLog::where('username', $req->username)->first();

        if($user == ""){
            return "Böyle bi kullanıcı adı bulunamadı.";
        }
        else if($user->password == $req->password){
            $token = $user->createToken('auth_token')->plainTextToken;
            return [
                "welcome" => "Hoşgeldin ".$req->username,
                "token" => $token
            ];
        }
        else if($user->password != $req->password){
            return "Yanlış sifre girdin.";
        }
        return response()->json($user, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
