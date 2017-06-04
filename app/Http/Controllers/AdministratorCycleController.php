<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class AdministratorCycleController extends Controller
{
  public function getUnassignedTransactions($month, $year) {
    $cycle = $month . ' ' . $year;
    $response = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, transactions_info.company_name, transactions_info.date_bought,
      user_info.first_name as "researcher_first_name", user_info.last_name as "researcher_last_name"
      FROM (transactions NATURAL JOIN transactions_info), (user_info NATURAL JOIN researchers)
      WHERE transactions.researcher_id = researchers.researcher_id AND (transactions.accountant_id = 6 OR transactions.status = "unassigned")  AND checked_pi = 1 AND transactions.billing_cycle = :cycle',
      ['cycle' => $cycle]);

      return $response;
  }

  public function getAssignedTransactions($month, $year) {
    $cycle = $month . ' ' . $year;
    $response = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, transactions_info.company_name, transactions_info.date_bought,
      user_info.first_name as "researcher_first_name", user_info.last_name as "researcher_last_name"
      FROM (transactions NATURAL JOIN transactions_info), (user_info NATURAL JOIN researchers)
      WHERE transactions.researcher_id = researchers.researcher_id AND NOT (transactions.accountant_id = 6 OR transactions.status = "unassigned")  AND checked_pi = 1 AND  transactions.billing_cycle = :cycle',
      ['cycle' => $cycle]);

      return $response;
  }

  public function getAllTransactions($month, $year) {
    $cycle = $month . ' ' . $year;
    $response = DB::select('SELECT accountant_first_name, accountant_last_name, researcher_first_name, researcher_last_name, transaction_id, status, created_at, transactions_info.company_name
      FROM (SELECT  A.first_name as "accountant_first_name", A.last_name as "accountant_last_name", R.first_name as "researcher_first_name", R.last_name as "researcher_last_name", R.researcher_id
        FROM  (SELECT DISTINCT first_name, last_name, accountant_id FROM accountants natural join user_info) as A
        join  (SELECT DISTINCT first_name, last_name, accountant_id, researcher_id FROM researchers natural join user_info) as R
      WHERE A.accountant_id = R.accountant_id) as T natural join transactions natural join transactions_info WHERE checked_pi = 1 AND transactions.billing_cycle = :cycle',
      ['cycle' => $cycle]);
    return $response;
  }

  /**
    * [getAllTransactionsNotReconciliated description]
    * This function will access the MariaDB and select all of
    * the transactions that had error in the reconciliation process
    *
    * @return [JSON] $results      - JSON response from the database
    *
    * JSON structure:
    * $results = {
    * transaction_id - int
    * created_at - DATE
    * updated_at - DATE
    * status - string
    * billing_cycle - DATE
    * is_reconciliated - int
    * researcher_id - int
    * accountant_id - int
    * total - double
    * company_name - string
    * date_bought - DATE
    * researcherFirstName - string
    * researcherLastName - string
    * accountantFirstName - string
    * accountantLastName - string
    * }
  */
  public function getAllTransactionsNotReconciliated()
  {

    DB::transaction(function() use (&$results) {

      $researcher_ids = DB::select('SELECT DISTINCT researcher_id
        FROM transactions
        WHERE status = "Error in reconciliation"');

      $researcher_ids = json_decode(json_encode($researcher_ids), true);

      foreach ($researcher_ids as $researcher_id) {
        $researcher_name = DB::select('SELECT first_name, last_name
          FROM  user_info natural join researchers
          WHERE researcher_id = :rid',['rid'=> $researcher_id['researcher_id']]);

        $researcher_name = json_decode(json_encode($researcher_name), true);
        $researcher_name = $researcher_name[0]['first_name'] .' '. $researcher_name[0]['last_name'];

        $transactions = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, transactions_info.company_name, transactions_info.date_bought,
          researchersInfo.first_name as researcherFirstName, researchersInfo.last_name as researcherLastName,
          accountantsInfo.first_name as accountantFirstName, accountantsInfo.last_name as accountantLastName
          FROM (transactions NATURAL JOIN transactions_info), (researchers NATURAL JOIN user_info as researchersInfo),
          (accountants NATURAL JOIN user_info accountantsInfo)
          WHERE transactions.researcher_id = researchers.researcher_id AND transactions.accountant_id = accountants.accountant_id
          AND transactions.status = "Error in reconciliation" AND transactions.researcher_id = :rid',
          ['rid' => $researcher_id['researcher_id']]);

        if(empty($results)){
          $results = array($researcher_name
            => $transactions);
        }
        else{
          $results += array($researcher_name
            => $transactions);
        }
      }

    });

    return $results;

  }

  /**
    * [getTransactionsNotReconciliatedCycle description]
    * This function will access the MariaDB and select all of
    * the transactions that had error in the reconciliation process of  selected cycle
    *
    * @param  [string]  $month        - month of the cycle received via the request
    *         [string]  $year         - year of the cycle received via the request
    * @return [JSON] $results      - JSON response from the database
    *
    * JSON structure:
    * $results = {
    * transaction_id - int
    * created_at - DATE
    * updated_at - DATE
    * status - string
    * billing_cycle - DATE
    * is_reconciliated - int
    * researcher_id - int
    * accountant_id - int
    * total - double
    * company_name - string
    * date_bought - DATE
    * researcherFirstName - string
    * researcherLastName - string
    * accountantFirstName - string
    * accountantLastName - string
    * }
  */
  public function getTransactionsNotReconciliatedCycle($month, $year)
  {

    $cycle = $month . ' ' . $year;

    DB::transaction(function() use (&$results, $cycle) {

      $researcher_ids = DB::select('SELECT DISTINCT researcher_id
        FROM transactions
        WHERE status = "Error in reconciliation" AND billing_cycle = :bc',
        ['bc' => $cycle]);

      $researcher_ids = json_decode(json_encode($researcher_ids), true);

      foreach ($researcher_ids as $researcher_id) {

        $researcher_name = DB::select('SELECT first_name, last_name
          FROM  user_info natural join researchers
          WHERE researcher_id = :rid',['rid'=> $researcher_id['researcher_id']]);

        $researcher_name = json_decode(json_encode($researcher_name), true);
        $researcher_name = $researcher_name[0]['first_name'] .' '. $researcher_name[0]['last_name'];

        $transactions = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, transactions_info.company_name, transactions_info.date_bought,
          researchersInfo.first_name as researcherFirstName, researchersInfo.last_name as researcherLastName,
          accountantsInfo.first_name as accountantFirstName, accountantsInfo.last_name as accountantLastName
          FROM (transactions NATURAL JOIN transactions_info), (researchers NATURAL JOIN user_info as researchersInfo),
          (accountants NATURAL JOIN user_info accountantsInfo)
          WHERE transactions.researcher_id = researchers.researcher_id AND transactions.accountant_id = accountants.accountant_id
          AND transactions.status = "Error in reconciliation" AND transactions.researcher_id = :rid AND transactions.billing_cycle = :ccl',
          ['rid' => $researcher_id['researcher_id'], 'ccl' => $cycle]);

        if(empty($results)){
          $results = array($researcher_name
            => $transactions);
        }
        else{
          $results += array($researcher_name
            => $transactions);
        }
      }
    });

    return $results;

  }

}
