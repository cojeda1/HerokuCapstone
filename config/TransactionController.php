<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use \DateTime;

class TransactionController extends Controller
{
    //
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function getIndividualResearcherTransaction($researcher_id, $transaction_id)
    {

      $results = DB::select('SELECT *
        FROM transactions
        WHERE researcher_id = :rid
          AND transaction_id = :tid',
        ['rid'=> $researcher_id, 'tid' => $transaction_id ]);

        return $results;
    }

    public function getValidatedAccountant($accountant_id)
    {

      $results = DB::select('SELECT *
        FROM transactions
        WHERE accountant_id = :aid AND status = "approved"',
        ['aid'=> $accountant_id ]);

        return $results;
    }

    public function createTransaction($researcher_id)
    {

      $results = DB::insert('SELECT *
        FROM transactions
        WHERE accountant_id = :aid AND status = "approved"',
        ['aid'=> $accountant_id ]);

        return $results;
    }

    public function passwordCheck(Request $request) {
      json_decode($request);
      $password = $request['password'];
      $email = $request['email'];
      $userInfo = DB::select('SELECT email, password from user_info WHERE email = :email', ['email' => $email]);
      $userInfo = json_decode(json_encode($userInfo),true);
      $hash = $userInfo[0]['password'];
      if(!empty($userInfo)) {
        $checked = password_verify($password, $hash);
        if($checked) {
          return "All is good";
        }
        else {
          return "password did not match bruh";
        }
      }
      else {
        return "Email Not Found";
      }
    }


}
