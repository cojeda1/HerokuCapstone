<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Tymon\JWTAuth\JWTAuth;
use App\User;
use Tymon\JWTAuth\Token;

class Login extends Controller
{

    public function login(Request $request, JWTAuth $jwt) {
      json_decode($request);
      $email = $request['email'];
      $password = $request['password'];
      $role = $request['role'];

      if($role === 'researcher') {

              $user = DB::select('SELECT researcher_id
                FROM researchers natural join user_info
                WHERE email = :email AND password = :password',
                ['email' => $email, 'password' => $password]);

              $jwtUser = User::all()->where('email', $email)->where('password',$password)->first();


              if(!empty($user)) {
                $user = json_decode(json_encode($user), true);
                $user = $user[0];
                $claims = [
                      'rid' => $user['researcher_id']
                  ];

                $token = $jwt->claims($claims)->fromUser($jwtUser);
                return response()->json(['token' => $token]);

              }
              else {
                return response()->json(['Researcher not found'], 404);
              }
      }

      elseif($role === 'accountant') {

              $user = DB::select('SELECT accountant_id
                FROM accountants natural join user_info
                WHERE email = :email AND password = :password',
                ['email' => $email, 'password' => $password]);

              $jwtUser = User::all()->where('email', $email)->where('password',$password)->first();


              if(!empty($user)) {
                $user = json_decode(json_encode($user), true);
                $user = $user[0];
                $claims = [
                      'aid' => $user['accountant_id']
                  ];

                $token = $jwt->claims($claims)->fromUser($jwtUser);
                return response()->json(['token' => $token]);

              }
              else {
                return response()->json(['Accountant not found'], 404);
              }
      }
      elseif($role === 'administrator') {

              $user = DB::select('SELECT admin_id
                FROM administrators natural join user_info natural join roles
                WHERE email = :email AND password = :password AND system_roles = "administrator" ',
                ['email' => $email, 'password' => $password]);

              $jwtUser = User::all()->where('email', $email)->where('password',$password)->first();


              if(!empty($user)) {
                $user = json_decode(json_encode($user), true);
                $user = $user[0];
                $claims = [
                      'admin_id' => $user['admin_id']
                  ];

                $token = $jwt->claims($claims)->fromUser($jwtUser);
                return response()->json(['token' => $token]);

              }
              else {
                return response()->json(['Administrator not found'], 404);
              }
      }

    }

}
