<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;

class UserController extends Controller
{
    /* * Register api
    *
    * @return \Illuminate\Http\Response
    */
    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $email = $input['email'];

        $user = User::where('email', $email)->first();
        $success = [];

        if ($user == null) {
            $success['exist'] = "no";
        }
        else {
            $success['exist'] = "yes";
            $success['token'] =  $user->createToken('Learn On')->accessToken;
        }

//        $user = User::create($input);
        // $success['token'] =  $user->createToken('MyApp')->accessToken;
        // $success['name'] =  $user->name;
        // return response()->json(['success' => $success], $this->successStatus);
        return response()->json(['success' => $success], 200);
    }
}
