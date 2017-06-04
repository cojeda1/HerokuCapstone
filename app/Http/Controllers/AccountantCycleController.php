<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class AccountantCycleController extends Controller
{
  public function getAssignedTransactions($accountant_id, $month, $year) {
    $cycle = $month . ' ' . $year;
    $response = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, transactions_info.company_name, transactions_info.date_bought,
      user_info.first_name, user_info.last_name
      FROM (transactions NATURAL JOIN transactions_info), (user_info NATURAL JOIN researchers)
      WHERE transactions.researcher_id = researchers.researcher_id AND transactions.accountant_id = :aid AND transactions.billing_cycle = :cycle',
      ['aid'=> $accountant_id, 'cycle' => $cycle]);

   return $response;
   }

   public function getValidatedTransactions($accountant_id, $month, $year) {
     $cycle = $month . ' ' . $year;
     $response = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, user_info.first_name, user_info.last_name
       FROM (transactions NATURAL JOIN transactions_info), (user_info NATURAL JOIN researchers)
       WHERE transactions.researcher_id = researchers.researcher_id AND transactions.accountant_id = :aid
       AND transactions.status = "approved" AND transactions.billing_cycle = :cycle',
       ['aid'=> $accountant_id, 'cycle' => $cycle]);
     return $response;
   }

   public function getUnassignedTransactions($month, $year) {
     $cycle = $month . ' ' . $year;
     $response = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, user_info.first_name, user_info.last_name
       FROM (transactions NATURAL JOIN transactions_info), (user_info NATURAL JOIN researchers)
       WHERE transactions.researcher_id = researchers.researcher_id AND transactions.status = "unassigned" AND transactions.billing_cycle = :cycle',
        ['cycle' => $cycle]);
     return $response;
   }

   public function getAllTransactions($month, $year) {
     $cycle = $month . ' ' . $year;
     $response = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, user_info.first_name, user_info.last_name
       FROM (transactions NATURAL JOIN transactions_info), (user_info NATURAL JOIN researchers)
       WHERE transactions.researcher_id = researchers.researcher_id AND transactions.billing_cycle = :cycle',['cycle' => $cycle]); //  AND transactions.checked_pi = 1 - for when the PI validation is completed
     return $response;
   }


}
