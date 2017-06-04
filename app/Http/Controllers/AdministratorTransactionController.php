<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdministratorTransactionController extends Controller
{
    //
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function getAssignedTransactions()
    {


      $results = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, transactions_info.company_name, transactions_info.date_bought,
        user_info.first_name as "researcher_first_name", user_info.last_name as "researcher_last_name"
        FROM (transactions NATURAL JOIN transactions_info), (user_info NATURAL JOIN researchers)
        WHERE transactions.researcher_id = researchers.researcher_id AND NOT (transactions.accountant_id = 6 OR transactions.status = "unassigned")');

        return $results;
    }

    public function getUnassignedTransactions()
    {


      $results = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, transactions_info.company_name, transactions_info.date_bought,
        user_info.first_name as "researcher_first_name", user_info.last_name as "researcher_last_name"
        FROM (transactions NATURAL JOIN transactions_info), (user_info NATURAL JOIN researchers)
        WHERE transactions.researcher_id = researchers.researcher_id AND (transactions.accountant_id = 6 OR transactions.status = "unassigned")');

        return $results;
    }

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

          $userInfo = DB::insert('INSERT INTO user_info (user_info_id, first_name, last_name, department, office,
            phone_number, job_title, email, password, created_at, updated_at)
            VALUES (UUID(), :fsn, :lsn, :dep, :off, :pn, :jt, :em, :psw, :ca, :ua)',
            ['fsn'=> $request['first_name'], 'lsn'=> $request['last_name'], 'dep'=> $request['department'],
            'off'=> $request['office'], 'pn'=> $request['phone_number'],
            'jt'=> $request['job_title'], 'em'=> $request['email'], 'psw'=> $request['password'],
            'ca'=> $request['created_at'], 'ua'=> $request['updated_at']]);

          if ($userInfo){
            $user_info_id = DB::connection()->getPdo()->lastInsertId();
          }

          $researcher = DB::insert('INSERT INTO researchers (roles_id, user_info_id, amex_account_id, employee_id, accountant_id)
            VALUES (3, :usrid, :amexid, :emid, :aid)',
            ['usrid'=> $user_info_id, 'amexid'=> $request['amex_account_id'], 'emid'=> $request['employee_id'],
            'aid'=> $request['accountant_id']]);

          if ($researcher){
            $researcher_id = DB::connection()->getPdo()->lastInsertId();
          }

          $credit_card = DB::insert('INSERT INTO credit_card (credit_card_number, name_on_card, researcher_id, expiration_date)
            VALUES (:ccn, :noc, :rid, :exd)',
            ['ccn'=> $request['credit_card_number'], 'noc'=> $request['name_on_card'], 'rid'=> $researcher_id,
            'exd'=> $request['expiration_date']]);
        });
        $response = "added";
      }
      else {
        $response ='exists';
      }
      return $response;
    }

    public function postCreateAccountant(Request $request)
    {
      json_decode($request);
      $checkIfUserExist = DB::select('SELECT email
        FROM user_info
        WHERE email = :em',['em'=>$request['email']]);

      if(empty(json_decode(json_encode($checkIfUserExist), true))){

        DB::transaction(function () use ($request) {

          $userInfo = DB::insert('INSERT INTO user_info (user_info_id, first_name, last_name, department, office,
            phone_number, job_title, email, password, created_at, updated_at)
            VALUES (UUID(), :fsn, :lsn, :dep, :off, :pn, :jt, :em, :psw, :ca, :ua)',
            ['fsn'=> $request['first_name'], 'lsn'=> $request['last_name'], 'dep'=> $request['department'],
            'off'=> $request['office'], 'pn'=> $request['phone_number'],
            'jt'=> $request['job_title'], 'em'=> $request['email'], 'psw'=> $request['password'],
            'ca'=> $request['created_at'], 'ua'=> $request['updated_at']]);

          if ($userInfo){
            $user_info_id = DB::connection()->getPdo()->lastInsertId();
          }

          $accountant = DB::insert('INSERT INTO researchers (roles_id, user_info_id)
            VALUES (2, :usrid)',
            ['usrid'=> $user_info_id]);

        });
        $response = "added";
      }
      else {
        $response ='exists';
      }
      return $response;
    }

    public function postEditAccountant($accountantInfo)
    {
      DB::transaction(function () use ($accountantInfo, &$user_info_id) {
        $userInfo = DB::update('UPDATE user_info
          SET first_name = :fsn, last_name = :lsn, department = :dep, office = :off, phone_number = :pn, job_title = :jt,
          email = :em, password = :psw, updated_at = :ua)
          WHERE user_info_id = :uid',
          ['fsn'=> $accountantInfo->$first_name, 'lsn'=> $accountantInfo->$last_name, 'dep'=> $accountantInfo->$department,
          'off'=> $accountantInfo->$office, 'pn'=> $accountantInfo->$phoneNumber,
          'jt'=> $accountantInfo->$jobTitle, 'em'=> $accountantInfo->$email, 'psw'=> $accountantInfo->$password,
          'ua'=> $accountantInfo->$updated_at, 'uid' => $accountantInfo->$user_info_id]);
      });
    }

    public function postEditResearcher($researcherInfo)
    {
      DB::transaction(function () use ($researcherInfo) {
        $userInfo = DB::update('UPDATE user_info
          SET first_name = :fsn, last_name = :lsn, department = :dep, office = :off, phone_number = :pn, job_title = :jt,
          email = :em, password = :psw, updated_at = :ua
          WHERE user_info_id = :uid',
          ['fsn'=> $researcherInfo->$first_name, 'lsn'=> $researcherInfo->$last_name, 'dep'=> $researcherInfo->$department,
          'off'=> $researcherInfo->$office, 'pn'=> $researcherInfo->$phoneNumber,
          'jt'=> $researcherInfo->$jobTitle, 'em'=> $researcherInfo->$email, 'psw'=> $researcherInfo->$password,
          'ua'=> $researcherInfo->$updated_at, 'uid'=> $researcherInfo->$user_info_id]);

        $researcher = DB::update('UPDATE researchers
          SET user_info_id = :usrid, amex_account_id = :amexid, employee_id = emid
          WHERE researcher_id = :rid',
          ['usrid'=> $researcherInfo->$user_info_id, 'amexid'=> $researcherInfo->$amex_account_id,
          'emid'=> $researcherInfo->$employee_id, 'rid'=> $researcherInfo->$researcher_id]);

        $credit_card = DB::update('UPDATE credit_card
          SET credit_card_number = :ccn, name_on_card = :noc, expiration_date = :exd
          WHERE researcher_id = :rid AND cc_id = :ccid',
          ['ccn'=> $researcherInfo->$credit_card_number, 'noc'=> $researcherInfo->$name_on_card,
          'rid'=> $researcherInfo->$researcher_id, 'exd'=> $researcherInfo->$expiration_date, 'ccid'=> $researcherInfo->$cc_id]);

        });
    }

    public function allResearchers() {
      $researcher_info = DB::select('SELECT first_name, last_name, researchers.researcher_id, credit_card_number
        FROM user_info natural join researchers, credit_card
        WHERE researchers.researcher_id = credit_card.researcher_id');

      // if(!empty(json_decode(json_encode($dbResult))) {
      //   foreach($dbResult )
      // }
      return $dbResult;
    }

    public function assignTransaction(Request $request) {
      $response = 'Assignment Failed';
     DB::transaction(function () use ($request, &$response) {

        json_decode($request);
        $accountant_id = $request['accountant_id'];
        $transaction_id = $request['transaction_id'];

        DB::update('UPDATE transactions SET accountant_id = :a_id, status = "in progress" WHERE transaction_id = :tid;', ['a_id'=>$accountant_id, 'tid' => $transaction_id]);
        $response = 'Assignment Sucessful';

        DB::insert('INSERT INTO accountants_timestamps (action, timestamp, transaction_id, accountant_id, name)
          VALUES ("Assigned Transaction by an Administrator", CURRENT_TIMESTAMP, :tid, :aid, "Administrator")', ['tid' => $transaction_id,
            'aid' => $accountant_id]);
     });
      return $response;
    }

    // public function getIndividualResearcher($researcher_id) {
    //  DB::transaction(function () use ($request, &$response) {
    //
    //     json_decode($request);
    //     $accountant_id = $request['accountant_id'];
    //     $transaction_id = $request['transaction_id'];
    //
    //     DB::update('UPDATE transactions SET accountant_id = :a_id, status = "in progress" WHERE transaction_id = :tid;', ['a_id'=>$accountant_id, 'tid' => $transaction_id]);
    //     $response = 'Assignment Sucessful';
    //
    //  });
    //   return $response;
    // }

    public function getAllTransactions() {
      $response = DB::select('SELECT accountant_first_name, accountant_last_name, researcher_first_name, researcher_last_name, transaction_id, status, created_at,  transactions_info.company_name
        FROM (SELECT  A.first_name as "accountant_first_name", A.last_name as "accountant_last_name", R.first_name as "researcher_first_name", R.last_name as "researcher_last_name", R.researcher_id
          FROM  (SELECT DISTINCT first_name, last_name, accountant_id FROM accountants natural join user_info) as A
          join  (SELECT DISTINCT first_name, last_name, accountant_id, researcher_id FROM researchers natural join user_info) as R
        WHERE A.accountant_id = R.accountant_id) as T natural join transactions  natural join transactions_info WHERE checked_pi = 1
        ');
      return $response;
    }

    public function getAllResearchers() {
      $response = DB::select('SELECT accountant_first_name, accountant_last_name, researcher_first_name, researcher_last_name, credit_card_number, researcher_id
        FROM (SELECT  A.first_name as "accountant_first_name", A.last_name as "accountant_last_name", R.first_name as "researcher_first_name", R.last_name as "researcher_last_name", R.researcher_id
          FROM  (SELECT  first_name, last_name, accountant_id FROM accountants natural join user_info) as A
          join  (SELECT  first_name, last_name, accountant_id, researcher_id FROM researchers natural join user_info) as R
          WHERE A.accountant_id = R.accountant_id) as T natural join credit_card WHERE credit_card.is_active = 1;');

          json_decode(json_encode($response));

        $null_values = DB::select('SELECT "Unassigned" as "accountant_first_name", "Accountant" as "accountant_last_name", first_name as "researcher_first_name", last_name as "researcher_last_name", credit_card_number, researcher_id
          FROM researchers natural join user_info natural join credit_card
          WHERE accountant_id IS NULL AND  is_active = 1;');
        json_decode(json_encode($null_values));

        foreach($null_values as $v){
          array_push($response, $v);
        }
      return $response;
    }

    public function getAllCreditCards() {
      $response = DB::select('SELECT accountant_first_name, accountant_last_name, researcher_first_name, researcher_last_name, credit_card_number, cc_id, is_active
        FROM (SELECT  A.first_name as "accountant_first_name", A.last_name as "accountant_last_name", R.first_name as "researcher_first_name", R.last_name as "researcher_last_name", R.researcher_id
          FROM  (SELECT DISTINCT first_name, last_name, accountant_id FROM accountants natural join user_info) as A
          join  (SELECT DISTINCT first_name, last_name, accountant_id, researcher_id FROM researchers natural join user_info) as R
        WHERE A.accountant_id = R.accountant_id) as T natural join credit_card

        ');
      return $response;
    }

    public function getActiveCreditCard($researcher_id) {
      $response = DB::select('SELECT credit_card_number, name_on_card, expiration_date, is_active, cc_id
        FROM credit_card natural join researchers
        WHERE is_active = 1 AND researcher_id = :rid', ['rid' => $researcher_id]);

      return $response;
    }

    public function addNewCreditCard(Request $request, $researcher_id) {
      DB::transaction(function () use ($researcher_id, $request, &$response) {

        $response = "Credit Card Creation Failed";


        $activeCard = DB::select('SELECT credit_card_number, expiration_date, cc_id
          FROM credit_card natural join researchers
          WHERE researcher_id = :rid AND is_active = 1
          ORDER BY cc_id DESC;', ['rid' => $researcher_id]);

        //If the person has an active credit_card
        if(!empty($activeCard)) {
          $activeCard = json_decode(json_encode($activeCard), true);
          $activeCard = $activeCard[0];

          $oldNumber = $activeCard['credit_card_number'];
          $oldExpDate = $activeCard['expiration_date'];
          $old_id = $activeCard['cc_id'];
            json_decode($request);
          $newNumber = $request['credit_card_number'];
          $newExpDate = $request['expiration_date'];

          if(!($oldNumber==$newNumber && $oldExpDate==$newExpDate) && !($oldNumber==$newNumber)) {
            DB::update('UPDATE credit_card
            SET is_active = 0
            WHERE cc_id = :old_id', ['old_id' => $old_id]);

            DB::insert('INSERT INTO credit_card(credit_card_number, name_on_card, expiration_date, researcher_id, is_active, reason)
            VALUES (:credit_card_number, :name_on_card, :expiration_date, :researcher_id, 1, :reason)',
            ['credit_card_number' => $newNumber , 'name_on_card' => $request['name_on_card'],
             'expiration_date' => $request['expiration_date'], 'researcher_id' => $researcher_id , 'reason' => $request['reason']]);

            $response = 'Card has been Created';
          }
          else {
            $response = 'Card already Exists';
          }
        }
      });

      return $response;
    }

    public function editCreditCard(Request $request, $cc_id) {
      json_decode($request);
      $credit_card_number = $request["credit_card_number"];
      DB::update('UPDATE credit_card
        SET credit_card_number = :ccn, expiration_date = :ed, name_on_card = :noc
        WHERE cc_id = :cc_id', ['ccn' => $request['credit_card_number'], 'ed' => $request['expiration_date'],
          'noc' => $request['name_on_card'], 'cc_id' => $cc_id]);

      return "Update Credit Card Successful";
    }

    public function getIndividualResearcher($researcher_id) {

      $researcherInfo = DB::select('SELECT *
        FROM researchers natural join user_info
        WHERE researcher_id = :rid', ['rid' => $researcher_id]);

      $creditCardActive = DB::select('SELECT credit_card_number, name_on_card, expiration_date, is_active, cc_id
        FROM credit_card natural join researchers
        WHERE is_active = 1 AND researcher_id = :rid', ['rid' => $researcher_id]);

      $purchaseReports = DB::select('SELECT created_at, transaction_id, status
        FROM  transactions natural join transactions_info, researchers
        WHERE transactions.researcher_id = researchers.researcher_id AND researchers.researcher_id =   :rid', ['rid' => $researcher_id]);

      $creditCardHistory = DB::select('SELECT credit_card_number, is_active, expiration_date, cc_id
        FROM credit_card natural join researchers
        WHERE researcher_id = :rid', ['rid' => $researcher_id]);

      $accountant = DB::select('SELECT first_name, last_name, researchers.accountant_id
        FROM user_info natural join accountants, researchers
        WHERE researchers.accountant_id = accountants.accountant_id AND researcher_id = :rid',['rid' => $researcher_id]);

      if(empty($accountant)){
        $response = array(
          'researcher_info' => $researcherInfo[0],
          'activeCard' => $creditCardActive[0],
          'purchase_reports' => $purchaseReports,
          'credit_card' => $creditCardHistory,
          'accountant_info' => array()
        );
      }
      else{
        $response = array(
          'researcher_info' => $researcherInfo[0],
          'activeCard' => $creditCardActive[0],
          'purchase_reports' => $purchaseReports,
          'credit_card' => $creditCardHistory,
          'accountant_info' => $accountant[0]
        );
      }


      return $response;
    }

    public function getIndividualAdministrator($admin_id){
      //check if admin\
      $checkIfAdmin = DB::select('SELECT *
        FROM administrators natural join roles
        WHERE system_roles = "administrator" AND admin_id = :aid', ['aid' => $admin_id]);

        if(!empty($checkIfAdmin)) {
          $adminInfo = DB::select('SELECT *
            FROM user_info NATURAL JOIN administrators
            WHERE admin_id = :aid', ['aid' => $admin_id]);
          $adminInfo = json_decode(json_encode($adminInfo), true);
          $response = $adminInfo[0];
          return $response;
        }
        else {
          abort(404, "User is not an admin");
        }
    }

    public function getAllAdministrators() {
      $response = DB::select('SELECT first_name, last_name, user_info_id, job_title, email, admin_id
        FROM administrators natural join roles natural join user_info
        WHERE system_roles = "administrator"');
      return $response;
    }

    public function disableAdmin($admin_id) {
      $role_id = DB::select('SELECT roles_id
        FROM roles
        WHERE system_roles = "disabled"');
      $role_id = json_decode(json_encode($role_id), true);
      $role_id = $role_id[0]['roles_id'];

      DB::update('UPDATE administrators
        SET roles_id = :rid
        WHERE admin_id = :aid', ['aid' => $admin_id, 'rid' => $role_id]);

      return "Admin has been disabled";
    }

}
