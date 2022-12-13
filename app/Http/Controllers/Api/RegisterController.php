<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
        $validator=Validator::make($request->all(),[
                'name'=>'required|string|max:255',
                'email'=>'required|email|max:255|unique:users',
                'password'=>'required|min:6',
                'confirm_password'=>'required|same:password',
        ]);

        if($validator->fails()){


        return $this->sentError('validation error',$validator->errors());
        }
        $password=bcrypt($request->password);

        $user=User::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'password' =>$password
        ]);

        $success['token']=$user->createToken('rest-api')->plainTextToken;
        $success['name']=$user->name;

        return $this-> sentResponse($success,'user create successfully');

    }

    public function login(Request $request){
        $validator=Validator::make($request->all(),[
            
            'email'=>'required|email|max:255',
            'password'=>'required|min:6',
            
    ]);
    if($validator->fails()){


        return $this->sentError('login fails',$validator->errors());
        }


    if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
        $user=Auth::user();
        $success['token']=$user->createToken('rest-api')->plainTextToken;
        $success['name']=$user->name;

        return $this->sentResponse($success,'successfully login');


    }else{
        return $this->sentError('Unauthorize',['logmessage'=>'unauthorize user']);
    }

    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->sentResponse([],'user logout');
    }
}
