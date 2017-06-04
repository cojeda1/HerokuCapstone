<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;

class AdministratorTempController extends Controller
{
////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////SELECTS////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
  /**
    * [getAssignedTransactions description]
    * This function will access the MariaDB and select all of
    * the transactions assigned to an accountant
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
    * }
  */
  public function getAssignedTransactions()
  {

    DB::transaction(function() use (&$results) {
      $results = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, transactions_info.company_name, transactions_info.date_bought,
        researchersInfo.first_name as researcherFirstName, researchersInfo.last_name as researcherLastName,
        accountantsInfo.first_name as accountantFirstName, accountantsInfo.last_name as accountantLastName
        FROM (transactions NATURAL JOIN transactions_info), (researchers NATURAL JOIN user_info as researchersInfo),
        (accountants NATURAL JOIN user_info accountantsInfo)
        WHERE transactions.researcher_id = researchers.researcher_id AND transactions.accountant_id = accountants.accountant_id
        AND NOT transactions.status = "unassigned"');
    });

    return $results;

  }

  /**
    * [getUnassignedTransactions description]
    * This function will access the MariaDB and select all of
    * the transactions unassigned
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
    * }
  */
  public function getUnassignedTransactions()
  {

    DB::transaction(function() use (&$results) {
      $results = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, transactions_info.company_name, transactions_info.date_bought,
        researchersInfo.first_name as researcherFirstName, researchersInfo.last_name as researcherLastName,
        accountantsInfo.first_name as accountantFirstName, accountantsInfo.last_name as accountantLastName
        FROM (transactions NATURAL JOIN transactions_info), (researchers NATURAL JOIN user_info as researchersInfo),
        (accountants NATURAL JOIN user_info accountantsInfo)
        WHERE transactions.researcher_id = researchers.researcher_id AND transactions.accountant_id = accountants.accountant_id
        AND transactions.status = "unassigned"');
    });

    return $results;

  }

  /**
    * [getAllAccountants description]
    * This function will access the MariaDB and select all of
    * the accountants and their last audited transaction
    *
    * @return [JSON] $results      - JSON response from the database
    *
    * JSON structure:
    * $accountant = {
    * accountant_id - int
    * first_name - string
    * last_name - string
    * }
    *
    * $transaction_info = {
    * transaction_id - int
    * created_at - DATE
    * updated_at - DATE
    * status - string
    * billing_cycle - DATE
    * is_reconciliated - int
    * researcher_id - int
    * accountant_id - int
    * }
  */
  public function getAllAccountants()
  {

    DB::transaction(function() use (&$results) {
      $results = array();

      $accountants = DB::select('SELECT accountant_id, first_name, last_name
        FROM accountants NATURAL JOIN user_info');

      for ($index = 0; $index < count($accountants); $index++) {
        $accountant = (array)$accountants[$index];

        $transaction_info = DB::select('SELECT DISTINCT translow.*
          FROM transactions AS translow
          WHERE accountant_id = :aid AND NOT translow.status = "unassigned" AND
          NOT exists (SELECT * FROM transactions as transHigh
          WHERE transHigh.accountant_id = translow.accountant_id
          AND transHigh.updated_at > translow.updated_at
          AND NOT transHigh.status = "unassigned")',
          ['aid'=> $accountant['accountant_id']]);

        if(!empty($transaction_info)){
          $transaction_info = (array) $transaction_info[0];
        }

        $results += array($index
          => array('accountant_info' => $accountant,
          'transaction_info' => $transaction_info));
      }
    });

    return $results;

  }

  /**
    * [getAccountant description]
    * This function will access the MariaDB and select all of
    * the accountant's information and their recent transactions
    *
    * @param  [int]  $accountant_id - accountant id received via the request
    * @return [JSON] $results      - JSON response from the database
    *
    * JSON structure:
    * $results = [
    *   'accountant_information':{
    *     accountant_id - int
    *     roles_id - int
    *     user_info_id - int
    *     first_name - string
    *     last_name - string
    *     department - string
    *     office - string
    *     phone_number - string
    *     job_title - string
    *     email - string
    *     password - string
    *     created_at - DATE
    *     updated_at - DATE
    *     },
    *   'recent_Transactions':{
    *     researcherFirstName - string
    *     researcherlastName - string
    *     updated_at - DATE
    *     transaction_id - int
    *     status - string
    *     credit_card_number - string
    *   }
    * ]
  */
  public function getAccountant($accountant_id)
  {

    DB::transaction(function() use ($accountant_id, &$response) {
      $accountant = DB::select('SELECT *
        FROM accountants NATURAL JOIN user_info
        WHERE accountant_id = :aid',['aid'=> $accountant_id]);

      $recentTransactions = DB::select('SELECT DISTINCT user_info.first_name as researcherFirstName, user_info.last_name as researcherlastName,
        transactions.updated_at, transactions.transaction_id, transactions.status, credit_card.credit_card_number
        FROM (researchers NATURAL JOIN user_info), transactions, credit_card
        WHERE (transactions.status = "approved" OR transactions.status = "denied" OR
        transactions.status = "escalated" or transactions.status = "unathorized charge")
        AND credit_card.researcher_id = transactions.researcher_id
        AND transactions.researcher_id = researchers.researcher_id
        AND transactions.accountant_id = :aid
        ORDER BY transactions.updated_at DESC',
        ['aid'=> $accountant_id]);

      $response = array(
        'accountant_information' => $accountant,
        'recent_Transactions' => $recentTransactions);
    });

    return $response;

  }

  /**
   * [getIndividualTransaction description]
   * @param  int  $researcher_id - researcher id received via the request
   * @param  int  $transaction_id - transaction id received via the request
   * @return JSON $response - associative array constructed with data received
   *                        from the DB
   * JSON structure:
   *
   * $items = {
   * item_id - int
   * item_name - string
   * item_price - double
   * quantity - int
   * transaction_id - int
   * ra_id - int
   * research_nickname - string
   * ufis_account_number - string
   * frs_account_number - string
   * unofficial_budget - double
   * budget_remaining - double
   * principal_investigator - string
   * be_notified - int
   * }
   *
   * $comments = {
   * comment_id - int
   * created_at - DATE
   * updated_at - DATE
   * body_of_comment - string
   * transaction_id - int
   * accountant_id - int
   * first_name - string
   * last_name - string
   * }
   *
   * $transaction_info = {
   * 'transaction_id' - integer
   * 'created_at' - DATE
   * 'updated_at' - DATE
   * 'status' - string
   * 'billing_cycle' - DATE
   * 'is_reconciliated' - boolean
   * 'researcher_id' - integer
   * 'accountant_id' - integer
   * 'tinfo_id' - integer
   * 'transaction_number' - string
   * 'receipt_number' - string
   * 'receipt_image_path' - string
   * 'date_bought' - string
   * 'company_name' - string
   * 'description_justification' - string
   * 'total' - integer
   * }
   *
   * $accountant = {
   * 'first_name' - string
   * 'last_name' - string
   * }
   *
   * $researcher = {
   * 'first_name' - string
   * 'last_name' - string
   * }
   *
   * $credit_card = {
   * 'credit_card_number' - string
   * }
   *
   * $images = {
   * 'image_path' - string
   * }
   *
  */
  public function getIndividualTransaction($researcher_id, $transaction_id)
  {

    DB::transaction(function() use ($transaction_id, &$results) {
      $transaction_info = DB::select('SELECT *
        FROM  transactions NATURAL JOIN transactions_info
        WHERE transaction_id = :tid',
        ['tid' => $transaction_id]);

      $items = DB::select('SELECT items.*, ra.ra_id, ra.research_nickname, frs_account_number, unofficial_budget, budget_remaining, principal_investigator, be_notified, CONCAT(SUBSTRING(ufis_account_number,1,14),item_code,SUBSTRING(ufis_account_number,19,32)) as "ufis_account_number"
        FROM (items NATURAL JOIN items_paid_from), research_accounts as ra
        WHERE ra.ra_id = items_paid_from.ra_id AND items.transaction_id = :tid
        AND items.item_id = items_paid_from.item_id ',
        ['tid'=> $transaction_id]);

      $comments = DB::select('SELECT comments.*, user_info.first_name, user_info.last_name
        FROM comments,  (accountants NATURAL JOIN  user_info)
        WHERE comments.accountant_id = accountants.accountant_id  AND comments.transaction_id = :tid',
        ['tid'=> $transaction_id]);

      $accountant = DB::select('SELECT first_name, last_name
        FROM  transactions, (user_info NATURAL JOIN accountants)
        WHERE transaction_id = :tid AND transactions.accountant_id = accountants.accountant_id',
        ['tid' => $transaction_id]);

      $researcher = DB::select('SELECT first_name, last_name
        FROM  transactions, user_info NATURAL JOIN researchers
        WHERE transaction_id = :tid AND transactions.researcher_id = researchers.researcher_id',
        ['tid' => $transaction_id]);

      $credit_card = DB::select('SELECT credit_card_number
        FROM  transactions, researchers NATURAL JOIN credit_card
        WHERE transaction_id = :tid AND transactions.researcher_id = researchers.researcher_id
        AND credit_card.is_active = 1',
        ['tid' => $transaction_id]);

      $images =  DB::select('SELECT image_path
        FROM transactions NATURAL JOIN transactions_info NATURAL JOIN transaction_images NATURAL JOIN images
        WHERE transactions.transaction_id = :tid',
        ['tid' => $transaction_id]);

      $results = array(
        'transaction_info' => $transaction_info,
        'items' => $items,
        'comments' => $comments,
        'accountant' => $accountant,
        'researcher' => $researcher,
        'credit_card' => $credit_card,
        'images' => $images
      );
    });

    return $results;

  }

  /**
    * [getAccountant description]
    * This function will access the MariaDB and select all of
    * the accountant's assigned researchers
    *
    * @param  [int]  $accountant_id - accountant id received via the request
    * @return [JSON] $results      - JSON response from the database
    *
    * JSON structure:
    * $results = {
    * researcher_id - int
    * first_name - string
    * last_name - string
    * }
  */
  public function getResearchersAssignedToAccountant($accountant_id)
  {

    DB::transaction(function() use ($accountant_id, &$response) {
      $response = DB::select('SELECT researcher_id, first_name, last_name
        FROM  user_info NATURAL JOIN researchers
        WHERE accountant_id = :aid',
        ['aid' => $accountant_id]);
    });
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
    * }
  */
  public function getAllTransactionsNotReconciliated()
  {

    DB::transaction(function() use (&$results) {
      $results = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, transactions_info.company_name, transactions_info.date_bought,
        researchersInfo.first_name as researcherFirstName, researchersInfo.last_name as researcherLastName,
        accountantsInfo.first_name as accountantFirstName, accountantsInfo.last_name as accountantLastName
        FROM (transactions NATURAL JOIN transactions_info), (researchers NATURAL JOIN user_info as researchersInfo),
        (accountants NATURAL JOIN user_info accountantsInfo)
        WHERE transactions.researcher_id = researchers.researcher_id AND transactions.accountant_id = accountants.accountant_id
        AND transactions.status = "Error in reconciliation"');
    });

    return $results;

  }

  /**
    * [getTransactionsNotReconciliatedCycle description]
    * This function will access the MariaDB and select all of
    * the transactions that had error in the reconciliation process of  selected cycle
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
    * }
  */
  public function getTransactionsNotReconciliatedCycle($cycle)
  {

    DB::transaction(function() use (&$results) {
      $results = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, transactions_info.company_name, transactions_info.date_bought,
        researchersInfo.first_name as researcherFirstName, researchersInfo.last_name as researcherLastName,
        accountantsInfo.first_name as accountantFirstName, accountantsInfo.last_name as accountantLastName
        FROM (transactions NATURAL JOIN transactions_info), (researchers NATURAL JOIN user_info as researchersInfo),
        (accountants NATURAL JOIN user_info accountantsInfo)
        WHERE transactions.researcher_id = researchers.researcher_id AND transactions.accountant_id = accountants.accountant_id
        AND transactions.status = "Error in reconciliation" AND transactions.cycle = :ccl',
        ['ccl' => $cycle]);
    });

    return $results;

  }

////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////UPDATES////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
  /**
   * [putEditAccountant description]
   * This function will access the MariaDB and update
   * the selected accountant's information
   *
   * @param  [int]  accountant_id - accountant id received via the request
   *         [JSON]  $request  - accountant's new info received via the request
   * @return [string] $response     - string response from the database.
   *                                  If successful, response is "Edit Successful".
   *                                  If fail, response is "Email already exists"
   *
   * JSON structure:
   * $request = [
   *   'accountant_information':{
   *     first_name - string
   *     last_name - string
   *     department - string
   *     office - string
   *     phone_number - string
   *     job_title - string
   *     email - string
   *     password - string
   *     updated_at - DATE
   *     },
   *   'list_of_researchers':[
   *      researcher_ids
   *   ]
   * ]
  */

  public function putEditAccountant($accountant_id, Request $request)
  {
    $checkIfEmailExists = DB::select('SELECT email, user_info_id
      FROM user_info
      WHERE email = :em',
      ['em'=>$request['email']]);

    $emailIsFromSameAccountant = 0;

    // Verify if user email is from accountant or researcher
    if(!empty(json_decode(json_encode($checkIfEmailExists), true))){
      $temp = $checkIfEmailExists[0];
      $temp2 = (array) $temp;
      $user_info_id = $temp2['user_info_id'];

      // Verify if the user_info_id is the same as the accountant edited
      $checkIfAccountantOrResearcher = DB::select('SELECT accountant_id
        FROM accountants
        WHERE user_info_id = :uid AND accountant_id = :aid',
        ['uid'=>$user_info_id, 'aid'=>$accountant_id]);

      // If there is a returned row, email is from same accountant
      $emailIsFromSameAccountant = !(empty(json_decode(json_encode($checkIfAccountantOrResearcher), true)));
    }

    if(
        // Email is new
        empty(json_decode(json_encode($checkIfEmailExists), true))
        or
        // Email is from same accountant
        $emailIsFromSameAccountant
      ){

      DB::transaction(function () use ($accountant_id, &$response, $request, &$user_info_id) {
        $user_info_id = DB::select('SELECT user_info_id
          FROM accountants NATURAL JOIN user_info
          WHERE accountant_id = :aid',
          ['aid'=> $accountant_id]);
        $user_info_id = json_decode(json_encode($user_info_id));
        $user_info_id = (array) $user_info_id[0];

        $userInfo = DB::update('UPDATE user_info
          SET first_name = :fsn, last_name = :lsn, department = :dep, office = :off, phone_number = :pn, job_title = :jt,
          email = :em, password = :psw, updated_at = :ua
          WHERE user_info_id = :uid',
          ['fsn'=> $request['first_name'], 'lsn'=> $request['last_name'], 'dep'=> $request['department'],
          'off'=> $request['office'], 'pn'=> $request['phone_number'],
          'jt'=> $request['job_title'], 'em'=> $request['email'], 'psw'=> $request['password'],
          'ua'=> $request['updated_at'], 'uid' => $user_info_id['user_info_id']]);

          $list_of_researchers = $request['list_of_researchers'];

          foreach ($list_of_researchers as $value) {
            DB::update("UPDATE researchers
              SET accountant_id = :aid
              WHERE researcher_id = :rid",
              ['rid' => $value, 'aid' => $accountant_id]);
          }
      });
      $response = "Edit Successful";
    }
    else{
      $response ='Email already exists';
    }

    return $response;

  }

  /**
   * [putEditAccountant description]
   * This function will access the MariaDB and update
   * the selected researcher's information
   *
   * @param  [int]  researcher_id - researcher id received via the request
   *         [JSON]  $request  - researcher's new info received via the request
   * @return [string] $response     - string response from the database.
   *                                  If successful, response is "Edit Successful".
   *                                  If fail, response is "Email and/or Employee ID already exists"
   *
   * JSON structure:
   * $request =
   * first_name - string
   * last_name - string
   * department - string
   * office - string
   * phone_number - string
   * job_title - string
   * email - string
   * password - string
   * updated_at - DATE
   * user_info_id - string
   * amex_account_id - string
   * employee_id - string
   * accountant_id - int
  */
  public function putEditResearcher($researcher_id, Request $request)
  {

    json_decode($request);

    $checkIfEmailExists = DB::select('SELECT email, user_info_id
      FROM user_info
      WHERE email = :em',
      ['em'=>$request['email']]);

    $emailIsFromSameResearcher = 0;

    if(!empty(json_decode(json_encode($checkIfEmailExists), true))){
      $temp = $checkIfEmailExists[0];
      $temp2 = (array) $temp;
      $user_info_id = $temp2['user_info_id'];

      //Verify if user_info_id is the same as the accountant edited
      $checkIfAccountantOrResearcher = DB::select('SELECT researcher_id
        FROM researchers
        WHERE user_info_id = :uid AND researcher_id = :rid',
        ['uid'=>$user_info_id, 'rid'=>$researcher_id]);

      // If there is a retured row, email is from researcher
      $emailIsFromSameResearcher = !(empty(json_decode(json_encode($checkIfAccountantOrResearcher), true)));
    }

    $checkIfEmployeeExists = DB::select('SELECT employee_id
      FROM researchers
      WHERE employee_id = :emid',
      ['emid'=>$request['employee_id']]);

    $employeeIdIsFromSameResearcher = 0;

    if(!empty(json_decode(json_encode($checkIfEmployeeExists), true))){
      $temp = $checkIfEmployeeExists[0];
      $temp2 = (array) $temp;
      $employee_id = $temp2['employee_id'];

      //Verify if employee_id is the same as the accountant edited
      $checkIfSameResearcher = DB::select('SELECT researcher_id
        FROM researchers
        WHERE employee_id = :eid AND researcher_id = :rid',
        ['eid'=>$employee_id, 'rid'=>$researcher_id]);

      // If there is a retured row, email is from researcher
      $employeeIdIsFromSameResearcher = !(empty(json_decode(json_encode($checkIfSameResearcher), true)));
    }

    if(
        // Both email and employee_id are new
        (empty(json_decode(json_encode($checkIfEmailExists), true)) and
        empty(json_decode(json_encode($checkIfEmployeeExists), true)))

        // Or email and employee_id are from the same researcher
        or ($emailIsFromSameResearcher and $employeeIdIsFromSameResearcher)
    ){
      DB::transaction(function () use ($request, &$response, $researcher_id) {
        $userInfo = DB::update('UPDATE user_info
          SET first_name = :fsn, last_name = :lsn, department = :dep, office = :off, phone_number = :pn, job_title = :jt,
          email = :em, password = :psw, updated_at = :ua
          WHERE user_info_id = :uid',
          ['fsn'=> $request['first_name'], 'lsn'=> $request['last_name'], 'dep'=> $request['department'],
          'off'=> $request['office'], 'pn'=> $request['phone_number'],
          'jt'=> $request['job_title'], 'em'=> $request['email'], 'psw'=> $request['password'],
          'ua'=> $request['updated_at'], 'uid'=> $request['user_info_id']]);

        $researcher = DB::update('UPDATE researchers
          SET amex_account_id = :amexid, employee_id = :emid, accountant_id = :aid
          WHERE researcher_id = :rid',
          ['rid'=> $researcher_id, 'amexid'=> $request['amex_account_id'],
          'emid'=> $request['employee_id'], 'aid'=> $request['accountant_id']]);
      });
      $response = "Edit Successful";
    }
    else {
      $response ='Email and/or Employee ID already exists';
    }

    return $response;

  }

  /**
   * [assignTransaction description]
   * This function will access the MariaDB and update
   * the accountant assigned to a transaction
   *
   * @param   [JSON]  $request  - researcher's new info received via the request
   * @return [string] $response     - string response from the database.
   *                                  If successful, response is 'Assignment Sucessful'.
   *                                  If fail, response is 'Assignment Failed'
   *
   * JSON structure:
   * $request =
   * transaction_id - int
   * accountant_id - int
   * admin_id - int
  */
  public function assignTransaction(Request $request) {

    $response = 'Assignment Failed';

    DB::transaction(function () use ($request, &$response) {
      json_decode($request);
      $accountant_id = $request['accountant_id'];
      $transaction_id = $request['transaction_id'];
      $admin_id = $request['admin_id'];

      DB::update('UPDATE transactions SET accountant_id = :a_id, status = "in progress" WHERE transaction_id = :tid;',
      ['a_id'=>$accountant_id, 'tid' => $transaction_id]);

      $accountant_name = DB::select('SELECT first_name, last_name
        FROM accountants NATURAL JOIN user_info
        WHERE accountant_id = :aid', ['aid' => $accountant_id]);

      $researcher = DB::select('SELECT R.researcher_id
        FROM researchers AS R, transactions as T
        WHERE T.researcher_id = R.researcher_id AND transaction_id = :tid', ['tid' => $transaction_id]);

      $researcher = json_decode(json_encode($researcher), true);

      $researcher_id = $researcher[0]['researcher_id'];

      $accountant_name = json_decode(json_encode($accountant_name), true);
      $accountant_name = $accountant_name[0];

      $accountant_full_name = $accountant_name['first_name'] . ' ' . $accountant_name['last_name'];

      $admin_name = DB::select('SELECT first_name, last_name
        FROM administrators NATURAL JOIN user_info
        WHERE admin_id = :aid', ['aid' => $admin_id]);

      $admin_name = json_decode(json_encode($admin_name), true);
      $admin_name = $admin_name[0];

      $admin_full_name = $admin_name['first_name'] . ' ' . $admin_name['last_name'];

      $researcher_name = DB::select('SELECT first_name, last_name
        FROM researchers NATURAL JOIN user_info
        WHERE researcher_id = :rid', ['rid' => $researcher_id]);

      $researcher_name = json_decode(json_encode($researcher_name), true);
      $researcher_name = $researcher_name[0];

      $researcher_full_name = $researcher_name['first_name'] . ' ' . $researcher_name['last_name'];

      $timestamp = DB::insert('INSERT INTO admin_timestamps (action, timestamp, transaction_id, admin_id, name)
        VALUES ("Assigned Transaction", CURRENT_TIMESTAMP, :tid, :aid, :name)', ['tid' => $transaction_id,
        'aid' => $admin_id, 'name' => $admin_full_name]);

      if ($timestamp){
        $timestamp_id = DB::connection()->getPdo()->lastInsertId();
      }

      $researcher_notification_body = "Your transaction was assigned to "  . $accountant_full_name . ".";
      $accountant_notification_body = "A transaction from "  . $researcher_full_name . " was assigned to you.";


      DB::insert('INSERT INTO researcher_notifications (notification_body, marked_as_read, admin_timestamp_id, researcher_id)
        VALUES (:nb, 0, :atid, :rid)', ['nb' => $researcher_notification_body,
        'atid' => $timestamp_id, 'rid' => $researcher_id]);

      DB::insert('INSERT INTO accountant_notifications (notification_body, marked_as_read, admin_timestamp_id, accountant_id)
        VALUES (:nb, 0, :atid, :aid)', ['nb' => $accountant_notification_body,
        'atid' => $timestamp_id, 'aid' => $accountant_id]);

      $response = 'Assignment Sucessful';
    });

    return $response;

  }

  /**
   * [putAssignResearchersToAccountant description]
   * This function will access the MariaDB and update
   * the accountant's assigned researchers
   *
   * @param   [int]  accountant_id - accountant id received via the request
   *          [JSON]  $request  - researcher's new info received via the request
   * @return [string] $response     - string response from the database.
   *                                  If successful, response is "Researchers Assigned".
   *
   * JSON structure:
   * $request = {
   * list_of_researchers = [researcher_ids]
   * }
  */
  public function putAssignResearchersToAccountant($accountant_id, Request $request)
  {

    DB::transaction(function() use ($accountant_id, &$response, $request) {
      json_decode($request);
      $list_of_researchers = $request['list_of_researchers'];

      foreach ($list_of_researchers as $value) {
        DB::update("UPDATE researchers
          SET accountant_id = :aid
          WHERE researcher_id = :rid",
          ['rid' => $value, 'aid' => $accountant_id]);
      }
      $response = "Researchers Assigned";
    });

    return $response;

  }

////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////INSERTS////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
/**
 * [postCreateResearcher description]
 * This function will access the MariaDB and insert
 * a new researcher user
 *
 * @param  [JSON]  $request  - researcher's info received via the request
 * @return [string] $response     - string response from the database.
 *                                  If successful, response is "added".
 *                                  If fail, response is 'exists'
 *
 * JSON structure:
 * $request =
 * first_name - string
 * last_name - string
 * department - string
 * office - string
 * phone_number - string
 * job_title - string
 * email - string
 * password - string
 * created_at - DATE
 * updated_at - DATE
 * user_info_id - string
 * amex_account_id - string
 * employee_id - string
 * accountant_id - int
 * credit_card_number - string
 * name_on_card - string
 * expiration_date - DATE
*/
  public function postCreateResearcher(Request $request)
  {

    json_decode($request);

    $checkIfUserExist = DB::select('SELECT email
      FROM user_info
      WHERE email = :em',['em'=>$request['email']]);

    $checkIfResearcherExist = DB::select('SELECT employee_id
      FROM researchers
      WHERE employee_id = :emid',['emid'=>$request['employee_id']]);

    $checkIfCardExist = DB::select('SELECT credit_card_number
      FROM credit_card
      WHERE credit_card_number = :em',['em'=>$request['credit_card_number']]);

    if(empty(json_decode(json_encode($checkIfUserExist), true)) and
        empty(json_decode(json_encode($checkIfResearcherExist), true)) and
        empty(json_decode(json_encode($checkIfCardExist), true))){

      DB::transaction(function () use ($request) {

        $user_info_id = DB::select('SELECT UUID() as "uuid"');
        $user_info_id = json_decode(json_encode($user_info_id));
        $user_info_id = (array)$user_info_id[0];

        $hash = password_hash($request['password'], PASSWORD_DEFAULT,  ['cost' => 12]);

        $userInfo = DB::insert('INSERT INTO user_info (user_info_id, first_name, last_name, department, office,
          phone_number, job_title, email, password, created_at, updated_at)
          VALUES (:uid, :fsn, :lsn, :dep, :off, :pn, :jt, :em, :psw, :ca, :ua)',
          ['fsn'=> $request['first_name'], 'lsn'=> $request['last_name'], 'dep'=> $request['department'],
          'off'=> $request['office'], 'pn'=> $request['phone_number'],
          'jt'=> $request['job_title'], 'em'=> $request['email'], 'psw'=> $hash,
          'ca'=> $request['created_at'], 'ua'=> $request['updated_at'], 'uid'=> $user_info_id['uuid']]);

        $researcher = DB::insert('INSERT INTO researchers (roles_id, user_info_id, amex_account_id, employee_id, accountant_id)
          VALUES (3, :usrid, :amexid, :emid, :aid)',
          ['usrid'=> $user_info_id['uuid'], 'amexid'=> $request['amex_account_id'], 'emid'=> $request['employee_id'],
          'aid'=> $request['accountant_id']]);

        if ($researcher){
          $researcher_id = DB::connection()->getPdo()->lastInsertId();
        }

        $credit_card = DB::insert('INSERT INTO credit_card (credit_card_number, name_on_card, researcher_id, expiration_date, is_active)
          VALUES (:ccn, :noc, :rid, :exd, :iac)',
          ['ccn'=> $request['credit_card_number'], 'noc'=> $request['name_on_card'], 'rid'=> $researcher_id,
          'exd'=> $request['expiration_date'], 'iac'=> 1]);
      });
      $response = "added";
    }
    else {
      $response ='exists';
    }
    return $response;

  }

  /**
   * [postCreateAccountant description]
   * This function will access the MariaDB and insert
   * a new accountant user
   *
   * @param  [JSON]  $request  - accountant's info received via the request
   * @return [string] $response     - string response from the database.
   *                                  If successful, response is "added".
   *                                  If fail, response is 'exists'
   *
   * JSON structure:
   * $request =
   * first_name - string
   * last_name - string
   * department - string
   * office - string
   * phone_number - string
   * job_title - string
   * email - string
   * password - string
   * created_at - DATE
   * updated_at - DATE
   * list_of_researchers - [researcher_ids]
  */
  public function postCreateAccountant(Request $request)
  {

    json_decode($request);
    $checkIfUserExist = DB::select('SELECT email
      FROM user_info
      WHERE email = :em',['em'=>$request['email']]);

    if(empty(json_decode(json_encode($checkIfUserExist), true))){

      DB::transaction(function () use ($request) {

        $user_info_id = DB::select('SELECT UUID() as "uuid"');
        $user_info_id = json_decode(json_encode($user_info_id));
        $user_info_id = (array)$user_info_id[0];

        $userInfo = DB::insert('INSERT INTO user_info (user_info_id, first_name, last_name, department, office,
          phone_number, job_title, email, password, created_at, updated_at)
          VALUES (:uid, :fsn, :lsn, :dep, :off, :pn, :jt, :em, :psw, :ca, :ua)',
          ['fsn'=> $request['first_name'], 'lsn'=> $request['last_name'], 'dep'=> $request['department'],
          'off'=> $request['office'], 'pn'=> $request['phone_number'],
          'jt'=> $request['job_title'], 'em'=> $request['email'], 'psw'=> $request['password'],
          'ca'=> $request['created_at'], 'ua'=> $request['updated_at'], 'uid'=> $user_info_id['uuid']]);

        $accountant = DB::insert('INSERT INTO accountants (roles_id, user_info_id)
          VALUES (2, :usrid)',
          ['usrid'=> $user_info_id['uuid']]);

        if ($accountant){
          $accountant_id = DB::connection()->getPdo()->lastInsertId();
        }

        foreach ($request['list_of_researchers'] as $researcher_id) {
          DB::update("UPDATE researchers
            SET accountant_id = :aid
            WHERE researcher_id = :rid",
            ['rid' => $researcher_id, 'aid' => $accountant_id]);
        }

      });
      $response = "added";
    }
    else {
      $response ='exists';
    }
    return $response;

  }

  /**
   * [postCreateAdministrator description]
   * This function will access the MariaDB and insert
   * a new administrator user
   *
   * @param  [JSON]  $request  - administrator's info received via the request
   * @return [string] $response     - string response from the database.
   *                                  If successful, response is "added".
   *                                  If fail, response is 'user exists or two admin exist'
   *
   * JSON structure:
   * $request =
   * first_name - string
   * last_name - string
   * department - string
   * office - string
   * phone_number - string
   * job_title - string
   * email - string
   * password - string
   * created_at - DATE
   * updated_at - DATE
  */
  public function postCreateAdministrator(Request $request)
  {

    json_decode($request);
    $checkIfUserExist = DB::select('SELECT email
      FROM user_info
      WHERE email = :em',['em'=>$request['email']]);

    $checkIfTwoAdminExist = DB::select('SELECT admin_id
      FROM administrators');

    //$response = count($checkIfTwoAdminExist);

    if(empty(json_decode(json_encode($checkIfUserExist), true))
      AND count($checkIfTwoAdminExist) < 2){

      DB::transaction(function () use ($request) {

        $user_info_id = DB::select('SELECT UUID() as "uuid"');
        $user_info_id = json_decode(json_encode($user_info_id));
        $user_info_id = (array)$user_info_id[0];

        $userInfo = DB::insert('INSERT INTO user_info (user_info_id, first_name, last_name, department, office,
          phone_number, job_title, email, password, created_at, updated_at)
          VALUES (:uid, :fsn, :lsn, :dep, :off, :pn, :jt, :em, :psw, :ca, :ua)',
          ['fsn'=> $request['first_name'], 'lsn'=> $request['last_name'], 'dep'=> $request['department'],
          'off'=> $request['office'], 'pn'=> $request['phone_number'],
          'jt'=> $request['job_title'], 'em'=> $request['email'], 'psw'=> $request['password'],
          'ca'=> $request['created_at'], 'ua'=> $request['updated_at'], 'uid'=> $user_info_id['uuid']]);

        $admin = DB::insert('INSERT INTO administrators (roles_id, user_info_id)
          VALUES (1, :usrid)',
          ['usrid'=> $user_info_id['uuid']]);

      });
      $response = "added";
    }
    else {
      $response ='user exists or two admin exist';
    }
    return $response;

  }

  /**
   * [uploadExcelFile description]
   * This function will access the server and add the excel
   * file uploaded by the administrator
   *
   * @return [string] $response     - string response from the database.
   *                                  If successful, response is "Upload Excel File Successful"
  */
  public function postUploadExcelFile(Request $request)
  {

    $file = Input::file();
    $excel = $file['file'];
    $cycle = $request['cycle'];
    $admin_id = $request['admin_id'];


    // Upload File
    $destinationPath = storage_path() . '/uploads/excel';

    // Verify if upload was successful
    if(!$excel->move($destinationPath, $excel->getClientOriginalName())) {
      return $this->errors(['message' => 'Error saving the file.', 'code' => 400]);
    }

    $response = "Upload Excel File Successful";

    // Start Reconciliation process with uploaded file
    //app('App\Http\Controllers\ReconciliationController')->reconcileTransactions("/storage/uploads/excel/" . $excel->getClientOriginalName(), $admin_id, $cycle);

    return app('App\Http\Controllers\ReconciliationController')->reconcileTransactions("/storage/uploads/excel/" . $excel->getClientOriginalName(), $admin_id, $cycle);;

  }

////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////DELETES////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
  /**
   * [deleteTransaction description]
   * This function will access the MariaDB and delete
   * the selected transaction
   *
   * @param  [int]  transaction_id - transaction id received via the request
   * @return [string] $response     - string response from the database.
   *                                  If successful, response is "Delete Transaction Successful"
  */
  public function deleteTransaction($transaction_id)
  {

    DB::transaction(function() use ($transaction_id, &$response) {
      // Delete transaction_id from admin_timestamps
      $admin_timestamps = DB::update("UPDATE admin_timestamps
        SET transaction_id = NULL
        WHERE transaction_id = :tid",['tid' => $transaction_id]);

      // Delete transaction_id from accountants_timestamps
      $accountants_timestamps = DB::update("UPDATE accountants_timestamps
        SET transaction_id = NULL
        WHERE transaction_id = :tid",['tid' => $transaction_id]);

      // Delete transaction_id from researchers_timestamps
      $researchers_timestamps = DB::update("UPDATE researchers_timestamps
        SET transaction_id = NULL
        WHERE transaction_id = :tid",['tid' => $transaction_id]);

      // Delete transaction notes
      $notes = DB::delete('DELETE FROM notes
        WHERE transaction_id = :tid',
        ['tid'=> $transaction_id]);

      // Delete transaction comments
      $comments = DB::delete('DELETE FROM comments
        WHERE transaction_id = :tid',
        ['tid'=> $transaction_id]);

      // Select transaction items ids for delete
      $items = DB::select('SELECT item_id
        FROM items
        WHERE transaction_id = :tid',
        ['tid'=> $transaction_id]);

      // Delete transaction items from items_paid_from
      if(!empty($items)){
        for ($index = 0; $index < count($items); $index++) {
          $item = (array)$items[$index];
          $items_paid_from = DB::delete('DELETE FROM items_paid_from
            WHERE item_id = :itid',
            ['itid'=> $item['item_id']]);
        }
      }

      // Delete transaction items
      $items = DB::delete('DELETE FROM items
        WHERE transaction_id = :tid',
        ['tid'=> $transaction_id]);

      // Select transaction images for delete
      $images_paths = DB::select('SELECT images.image_id, image_path
        FROM (transactions_info NATURAL JOIN transaction_images), images
        WHERE transaction_id = :tid AND transaction_images.image_id = images.image_id',
        ['tid'=> $transaction_id]);

      // Delete transaction images from transaction_images, and Delete image from images and server
      if(!empty($images_paths)){
        for ($index = 0; $index < count($images_paths); $index++) {
          $image = (array)$images_paths[$index];

          $transaction_images = DB::delete('DELETE FROM transaction_images
            WHERE image_id = :iid',
            ['iid'=> $image['image_id']]);

          $images = DB::delete('DELETE FROM images
            WHERE image_id = :iid',
            ['iid'=> $image['image_id']]);

          app('App\Http\Controllers\FileController')->deleteFile($image['image_path']);
        }
      }

      // Delete transaction information from transaction_info
      $transaction_info = DB::delete('DELETE FROM transactions_info
        WHERE transaction_id = :tid',
        ['tid'=> $transaction_id]);

      // Delete transaction from transactions
      $transaction = DB::delete('DELETE FROM transactions
        WHERE transaction_id = :tid',
        ['tid'=> $transaction_id]);

      $response = "Delete Transaction Successful";
    });

    return $response;

  }

  /**
   * [deleteAdministrator description]
   * This function will access the MariaDB and delete
   * the selected administrator
   *
   * @param  [int]  $admin_id - administrator id received via the request
   * @return [string] $response     - string response from the database.
   *                                  If successful, response is "Delete Administrator Successful" when successful,
   *                                  and "Administrator does not exists or System only has one administrator" when administrator does not exist
  *                                   or the system only has one administrator
  */
  public function deleteAdministrator($admin_id)
  {

    DB::transaction(function() use ($admin_id, &$response) {
      $checkIfAdminExists = DB::select('SELECT admin_id
        FROM administrators
        WHERE admin_id = :aid',
        ['aid'=> $admin_id]);

      $checkIfTwoAdminExist = DB::select('SELECT admin_id
        FROM administrators');

      if(!empty($checkIfAdminExists) AND count($checkIfTwoAdminExist) == 2){
        $timestamps = DB::select('SELECT admin_timestamp_id
          FROM admin_timestamps
          WHERE admin_id = :aid',
          ['aid'=> $admin_id]);

        if(!empty($timestamps)){
          for ($index = 0; $index < count($timestamps); $index++) {
            $timestamp = (array)$timestamps[$index];
            DB::update('UPDATE accountant_notifications
              SET admin_timestamp_id = NULL
              WHERE admin_timestamp_id = :atid',
              ['atid'=> $timestamp['admin_timestamp_id']]);
          }
        }

        DB::update('UPDATE admin_timestamps
          SET admin_id = NULL
          WHERE admin_id = :aid',
          ['aid'=> $admin_id]);

        $user_info_id = DB::select('SELECT user_info_id
          FROM administrators NATURAL JOIN user_info
          WHERE admin_id = :aid',
          ['aid'=> $admin_id]);

        $user_info_id = json_decode(json_encode($user_info_id), true);
        $user_info_id = $user_info_id[0]['user_info_id'];

        DB::delete('DELETE FROM administrators
          WHERE admin_id = :aid',
          ['aid'=> $admin_id]);

        DB::delete('DELETE FROM user_info
          WHERE user_info_id = :uid',
          ['uid'=> $user_info_id]);

        $response = "Delete Administrator Successful";
      }

      else{
        $response = "Administrator does not exists or System only has one administrator";
      }
    });

    return $response;

  }
}
