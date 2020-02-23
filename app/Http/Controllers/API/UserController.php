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
        $exist = "no";

        if ($user) {
            $exist = "yes";
            // $success['token'] =  $user->createToken('Learn On')->accessToken;
            // API token will not be generated here
        }

//        $user = User::create($input);
        // $success['token'] =  $user->createToken('MyApp')->accessToken;
        // $success['name'] =  $user->name;
        // return response()->json(['success' => $success], $this->successStatus);
        return response()->json(['exist' => $exist], 200);
    }
}
