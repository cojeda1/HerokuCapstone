<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class ResearcherCycleController extends Controller
{
  public function getAllTransactions($researcher_id, $month, $year) {
    $cycle = $month . ' ' . $year;
    $results = DB::select('SELECT date_bought, transaction_id, company_name, total, status, is_reconciliated
      FROM  transactions natural join transactions_info, researchers
      WHERE transactions.researcher_id = researchers.researcher_id AND researchers.researcher_id = :rid AND transactions.billing_cycle = :cycle',
      ['rid'=> $researcher_id, 'cycle' => $cycle]);

    return $results;
  }

  public function getAllTransactionToApprove($researcher_id, $month, $year) {
    $cycle = $month . ' ' . $year;
    $researcher_name = DB::select('SELECT first_name, last_name
      FROM  user_info natural join researchers
      WHERE researcher_id = :rid',['rid'=> $researcher_id]);

    $researcher_name = json_decode(json_encode($researcher_name), true);
    $researcher_name = $researcher_name[0]['first_name'] .' '. $researcher_name[0]['last_name'];

    $transactionsToValidate = DB::select('SELECT date_bought, transaction_id, company_name, total, status, is_reconciliated
      FROM (SELECT transaction_id
             FROM items as I natural join items_paid_from as IP, research_accounts
             WHERE IP.ra_id = research_accounts.ra_id ANd pi_allowed_item = 0 AND principal_investigator = :name
             GROUP BY transaction_id) as Temp natural join transactions natural join transactions_info
             WHERE transactions.billing_cycle = :cycle;', ['name' => $researcher_name, 'cycle' => $cycle]);

    return $transactionsToValidate;
  }

  /**
    * [getAllTransactionsNotReconciliated description]
    * This function will access the MariaDB and select all of
    * the transactions from the selected researcher that had error in the reconciliation process
    *
    * @param  [int]  $researcher_id   - researcher id received via the request
    * @return [JSON] $results         - JSON response from the database
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
  public function getAllTransactionsNotReconciliated($researcher_id)
  {

    DB::transaction(function() use (&$results, $researcher_id) {
      $results = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, transactions_info.company_name,
        transactions_info.date_bought, researchersInfo.first_name as researcherFirstName, researchersInfo.last_name as researcherLastName,
        accountantsInfo.first_name as accountantFirstName, accountantsInfo.last_name as accountantLastName
        FROM (transactions NATURAL JOIN transactions_info), (researchers NATURAL JOIN user_info as researchersInfo),
        (accountants NATURAL JOIN user_info accountantsInfo)
        WHERE transactions.researcher_id = researchers.researcher_id AND transactions.accountant_id = accountants.accountant_id
        AND transactions.status = "Error in reconciliation" AND transactions.researcher_id = :rid',
        ['rid' => $researcher_id]);
    });

    return $results;

  }

  /**
    * [getTransactionsNotReconciliatedCycle description]
    * This function will access the MariaDB and select all of
    * the transactions from the selected researcher that had error in the reconciliation
    * process of selected cycle
    *
    * @param  [int]  $researcher_id   - researcher id received via the request
    *         [string]  $month        - month of the cycle received via the request
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
  public function getTransactionsNotReconciliatedCycle($researcher_id, $month, $year)
  {

    $cycle = $month . ' ' . $year;

    DB::transaction(function() use (&$results, $researcher_id, $cycle) {
      $results = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, transactions_info.company_name,
        transactions_info.date_bought, researchersInfo.first_name as researcherFirstName, researchersInfo.last_name as researcherLastName,
        accountantsInfo.first_name as accountantFirstName, accountantsInfo.last_name as accountantLastName
        FROM (transactions NATURAL JOIN transactions_info), (researchers NATURAL JOIN user_info as researchersInfo),
        (accountants NATURAL JOIN user_info accountantsInfo)
        WHERE transactions.researcher_id = researchers.researcher_id AND transactions.accountant_id = accountants.accountant_id
        AND transactions.status = "Error in reconciliation" AND transactions.researcher_id = :rid AND transactions.billing_cycle = :ccl',
        ['rid' => $researcher_id, 'ccl' => $cycle]);
    });

    return $results;

  }

}
