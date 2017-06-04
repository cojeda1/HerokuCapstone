<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use \DateTime;


class ResearcherController extends Controller {

////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////SELECTS////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

  /**
   * [getAllResearchAccounts_PI description]
   * This function will access the MariaDB and select all of
   * the research accounts where the Researcher is the principal_investigator
   *
   * @param  [int]  $researcher_id - researcher id received via the request
   * @return [JSON] $results      - JSON response from the database
   *
   * JSON structure:
   * $results = {
   * research_nickname - string
   * ufis_account_number - string
   * budget_remaining - double
   * unofficial_budget - double
   * }
   */
  public function getAllResearchAccounts_PI($researcher_id) {
    $results = DB::select('SELECT research_nickname, ufis_account_number, budget_remaining, unofficial_budget, ra_id
      FROM  researcher_has_accounts natural join research_accounts natural join researchers natural join user_info
      WHERE researcher_id = :rid AND CONCAT_WS(" ",first_name,last_name) = principal_investigator ',['rid'=> $researcher_id]);

      return $results;
  }

  /**
   * [getAllResearchAccounts_COPI description]
   * * This function will access the MariaDB and select all of
   * the research accounts where the Researcher is the CO-PI
   *
   * @param  [int]  $researcher_id - researcher id received via the request
   * @return [JSON] $results      - JSON response from the database
   *
   * JSON structure:
   * $results = {
   * research_nickname - string
   * ufis_account_number - string
   * budget_remaining - double
   * unofficial_budget - double
   * }
   */
  public function getAllResearchAccounts_COPI($researcher_id) {
    $results = DB::select('SELECT research_nickname, ufis_account_number, budget_remaining, unofficial_budget, ra_id
      FROM  researcher_has_accounts natural join research_accounts natural join researchers natural join user_info
      WHERE researcher_id = :rid AND CONCAT_WS(" ",first_name,last_name) != principal_investigator ',['rid'=> $researcher_id]);

      return $results;
  }

  /**
   * [getResearcherInfo description]
   * GETs the necessary pernal information of a researcher
   * @param  [int]  $researcher_id - researcher id received via the request
   * @return [JSON] $results      - JSON response from the database
   *
   * JSON structure:
   * $results = {
   * first_name - string
   * last_name - string
   * }
   */
  public function getResearcherInfo($researcher_id) {
    $results = DB::select('SELECT first_name, last_name, department, office, phone_number, job_title, email, employee_id
      FROM  researchers natural join user_info
      WHERE researcher_id = :rid',['rid'=> $researcher_id]);

      return $results;
  }

  public function getAllResearchers($researcher_id) {
    $results = DB::select('SELECT first_name, last_name, researcher_id
      FROM  researchers natural join user_info
      WHERE researcher_id != :rid',['rid' => $researcher_id]);

      return $results;
  }

  /**
   * [getAllTransactions description]
   * @param  [type]  $researcher_id - researcher id received via the request
   * @return [JSON] $results      - JSON response from the database
   *
   * JSON structure:
   * $results = {
   * date_bought - DATE
   * transaction_id - int
   * company_name - string
   * total - double
   * status - string
   * is_reconciliated - boolean
   * }
   */
  public function getAllTransactions($researcher_id) {
    $results = DB::select('SELECT date_bought, transaction_id, company_name, total, status, is_reconciliated
      FROM  transactions natural join transactions_info, researchers
      WHERE transactions.researcher_id = researchers.researcher_id AND researchers.researcher_id = :rid ',['rid'=> $researcher_id]);

      return $results;
  }

  public function getAllTransactionToApprove($researcher_id) {
    $researcher_name = DB::select('SELECT first_name, last_name
      FROM  user_info natural join researchers
      WHERE researcher_id = :rid',['rid'=> $researcher_id]);

    $researcher_name = json_decode(json_encode($researcher_name), true);
    $researcher_name = $researcher_name[0]['first_name'] .' '. $researcher_name[0]['last_name'];

    $transactionsToValidate = DB::select('SELECT date_bought, transaction_id, company_name, total, status, is_reconciliated, transactions.researcher_id
      FROM (SELECT transaction_id
	           FROM items as I natural join items_paid_from as IP, research_accounts
	           WHERE IP.ra_id = research_accounts.ra_id ANd pi_allowed_item = 0 AND principal_investigator = :name
	           GROUP BY transaction_id) as Temp natural join transactions natural join transactions_info;', ['name' => $researcher_name]);

    return $transactionsToValidate;
  }

  /**
   * [getIndividualTransaction description]
   * @param  int  $researcher_id - researcher id received via the request
   * @param  int  $transaction_id - transaction id received via the request
   * @return JSON $response - associative array constructed with data received
   *                        from the DB
   * $response = {
   *  'items' - array of all items associated with chosen transactions
   *  'comments' - array of all comments associated with the chosen transactions
   *  'transaction_infromation' - all of the transaction information
   *  'accountant' - first name and last name of the accountant
   *  'researcher' - first name and last name of the accountant
   * }
   *
   * Response structure of DB
   *
   * $items = {
   *  'item_name' - string
   *  'item_id' - integer
   *  'item-price' - double
   *  'item-price' integer
   * }
   *
   * $comments = {
   *  'created_at' - DATE
   *  'body_of_comment' - string
   *  'comment_id' - integer
   *  'first_name' - string
   *  'last_name' - string
   * }
   *
   * $transaction_information = {
   *  'transaction_id' - integer
   *  'created_at' - DATE
   *  'updated_at' - DATE
   *  'status' - string
   *  'billing_cycle' - DATE
   *  'is_reconciliated' - boolean
   *  'researcher_id' - integer
   *  'accountant_id' - integer
   *  'tinfo_id' - integer
   *  'transaction_number' - string
   *  'receipt_number' - string
   *  'receipt_image_path' - string
   *  'date_bought' - string
   *  'company_name' - string
   *  'description_justification' - string
   *  'total' - integer
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
   */
  public function getIndividualTransaction($researcher_id, $transaction_id) {

    DB::transaction(function() use ($researcher_id, $transaction_id, &$response) {

      $transaction_information = DB::select('SELECT *
        FROM  transactions natural join transactions_info
        WHERE researcher_id = :rid AND transaction_id = :tid',['rid'=> $researcher_id, 'tid' => $transaction_id]);

      $items = DB::select('SELECT item_name, item_price, quantity, item_id, ra_id, research_nickname, item_code, CONCAT(SUBSTRING(ufis_account_number,1,14),item_code,SUBSTRING(ufis_account_number,19,32)) as "ufis_account_number"
        FROM  transactions natural join items natural join items_paid_from natural join research_accounts
        WHERE researcher_id = :rid AND transaction_id = :tid',['rid'=> $researcher_id, 'tid' => $transaction_id]);

      $comments = DB::select('SELECT comments.created_at, body_of_comment, comment_id, first_name, last_name
        FROM comments, accountants natural join user_info
        WHERE transaction_id = :tid AND comments.accountant_id = accountants.accountant_id', ['tid' => $transaction_id]);

      $accountant = DB::select('SELECT first_name, last_name
        FROM  transactions, user_info natural join accountants
        WHERE researcher_id = :rid AND transaction_id = :tid
          AND transactions.accountant_id = accountants.accountant_id',['rid'=> $researcher_id, 'tid' => $transaction_id]);

      $researcher = DB::select('SELECT first_name, last_name
        FROM  transactions, user_info natural join researchers
        WHERE transactions.researcher_id = :rid AND transaction_id = :tid
          AND transactions.researcher_id = researchers.researcher_id',['rid'=> $researcher_id, 'tid' => $transaction_id]);

      $images =  DB::select('SELECT image_path, image_id
        FROM transactions natural join transactions_info natural join transaction_images natural join images
        WHERE transactions.transaction_id = :tid', ['tid' => $transaction_id]);

      $response = array(
        'transaction_information' => $transaction_information,
        'items' => $items,
        'comments' => $comments,
        'accountant' => $accountant,
        'researcher' => $researcher,
        'images' => $images
      );
    });
   return $response;
  }

  /**
   * [getAllNotifications description]
   * This function will access the MariaDB and select all of
   * the notifications of the investigator
   * @param  [type]  $researcher_id - researcher id received via the request
   * @return [JSON] $results      - JSON response from the database
   *
   * JSON structure:
   * $results = {
   * rn_id - int
   * notification_body - string
   * marked_as_read - int
   * transaction_id - int
   * timestamp - DATE
   * }
   */
  public function getAllNotifications($researcher_id) {

    DB::transaction(function() use ($researcher_id, &$results)
    {

      $admin_timestamps = DB::select('SELECT rn_id, notification_body, marked_as_read, transaction_id, admin_timestamps.timestamp
        FROM  researcher_notifications NATURAL JOIN admin_timestamps
        WHERE researcher_id = :rid
        ORDER BY admin_timestamps.timestamp DESC',['rid'=> $researcher_id]);

      $accountants_timestamps = DB::select('SELECT rn_id, notification_body, marked_as_read, transaction_id, accountants_timestamps.timestamp
        FROM  researcher_notifications NATURAL JOIN accountants_timestamps
        WHERE researcher_id = :rid
        ORDER BY accountants_timestamps.timestamp DESC',['rid'=> $researcher_id]);

      $results = array(
        'notifications_from_admin' => $admin_timestamps,
        'notifications_from_accountant' => $accountants_timestamps
      );
    });

    return $results;

  }

  /**
   * [getTop10Notifications description]
   * This function will access the MariaDB and select the top 10 of
   * the notifications of the investigator
   * @param  [type]  $researcher_id - researcher id received via the request
   * @return [JSON] $results      - JSON response from the database
   *
   * JSON structure:
   * $results = {
   * rn_id - int
   * notification_body - string
   * marked_as_read - int
   * transaction_id - int
   * timestamp - DATE
   * }
   */
  public function getTop10Notifications($researcher_id) {

    DB::transaction(function() use ($researcher_id, &$results)
    {

      $notification_ids = DB::select('SELECT rn_id, at_id, admin_timestamp_id
        FROM  researcher_notifications
        WHERE researcher_id = :rid AND NOT (at_id IS NULL AND admin_timestamp_id IS NULL)
        ORDER BY rn_id DESC
        LIMIT 10',['rid'=> $researcher_id]);

      $notification_ids = json_decode(json_encode($notification_ids, true));
      $results = [];

      for($index = 0; $index < count($notification_ids); $index ++){
        $notification = (array) $notification_ids[$index];

        // Check if notification from accountant
        if($notification['at_id'] != NULL){
          $notification_info = DB::select('SELECT rn_id, notification_body, marked_as_read, transaction_id, accountants_timestamps.timestamp
            FROM  researcher_notifications NATURAL JOIN accountants_timestamps
            WHERE rn_id = :rnid',['rnid'=> $notification['rn_id']]);

          $notification_info = json_decode(json_encode($notification_info));
          $notification_info = (array) $notification_info[0];

          $results += array($index => array('rn_id' => $notification_info['rn_id'],
            'notification_body' => $notification_info['notification_body'],
            'marked_as_read' => $notification_info['marked_as_read'],
            'transaction_id' => $notification_info['transaction_id'],
            'timestamp' => $notification_info['timestamp']));
        }

        // Notification is from administrator
        elseif($notification['admin_timestamp_id'] != NULL) {
          $notification_info = DB::select('SELECT rn_id, notification_body, marked_as_read, transaction_id, admin_timestamps.timestamp
            FROM  researcher_notifications NATURAL JOIN admin_timestamps
            WHERE rn_id = :rnid',['rnid'=> $notification['rn_id']]);

          $notification_info = json_decode(json_encode($notification_info));
          $notification_info = (array) $notification_info[0];

          $results += array($index => array('rn_id' => $notification_info['rn_id'],
            'notification_body' => $notification_info['notification_body'],
            'marked_as_read' => $notification_info['marked_as_read'],
            'transaction_id' => $notification_info['transaction_id'],
            'timestamp' => $notification_info['timestamp']));
        }
      }
    });

    return $results;

  }

////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////INSERTS////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

  public function createNewResearchAccount(Request $request, $researcher_id) {

    $response = "Failed";
   DB::transaction(function() use ($researcher_id, &$response, $request) {


    json_decode($request);

      $principalI = DB::select('SELECT first_name, last_name
        FROM  user_info natural join researchers
        WHERE researcher_id = :rid',['rid'=> $researcher_id]);

      $principalI = json_decode(json_encode($principalI), true);
      $name = $principalI[0]['first_name'] .' '. $principalI[0]['last_name'];
      $nickname = $request["research_nickname"];
      $ufis_number = $request["ufis_account_number"];
      $unofficial_limit = $request["unofficial_budget"];
      $unofficial_remaining = $request["budget_remaining"];
      $frs_number = $request['frs_account_number'];
       $list_of_copi = $request["list_of_copi"];
      $is_notified = 0;

       $checkIfExist = DB::select('SELECT ufis_account_number FROM research_accounts WHERE ufis_account_number = :ufis_number',['ufis_number'=>$ufis_number]);

        if(empty(json_decode(json_encode($checkIfExist), true))){

          $dbResult = DB::insert("INSERT INTO research_accounts(research_nickname, ufis_account_number,frs_account_number,unofficial_budget, budget_remaining, be_notified,principal_investigator)
            VALUES(:nickname,:ufis_number,:frs_number,:unofficial_limit,:unofficial_remaining, :is_notified, :name);",
              ['nickname' => $nickname, 'ufis_number' => $ufis_number, 'frs_number' => $frs_number, 'unofficial_limit' => $unofficial_limit, 'unofficial_remaining' => $unofficial_remaining, 'is_notified' =>$is_notified, 'name' => $name]);

          if($dbResult) {
            $id = DB::connection() -> getPdo() -> lastInsertId();
          }

          DB::insert("INSERT INTO researcher_has_accounts (ra_id, researcher_id) VALUES(:ra_id, :researcher_id)", ['ra_id' => $id, 'researcher_id' => $researcher_id]);

          foreach ($list_of_copi as $value) {
            DB::insert("INSERT INTO researcher_has_accounts (ra_id, researcher_id) VALUES(:ra_id, :researcher_id)", ['ra_id' => $id, 'researcher_id' => $value]);
          }
          $response = "added";
      }
      else {
        $response ='exists';
      }
    });
    return $response;
  }

  public function createNewTransaction($researcher_id) {

      $file = Input::file();
      $data = Input::all();
    DB::transaction(function() use ($researcher_id, &$response, $file, $data) {

      $imageArray = array();
      $company_name = $data['company_name'];
      $date_bought = $data['date_bought'];
      $descJust = $data['description_justification'];
      $items = $data['items'];
      $receipt_number = $data['receipt_number'];
      $total = $data['total'];
      $transaction_number = $data['transaction_number'];

      $cycle = $this->postCycle($date_bought);

      $dbResult = DB::insert('INSERT INTO transactions(created_at, updated_at, billing_cycle, is_reconciliated, status,researcher_id, checked_pi)
      VALUES (CURRENT_TIMESTAMP, CURRENT_TIMESTAMP,  :cycle, 0, "unassigned", :rid, 1)',['rid'=>$researcher_id, 'cycle' => $cycle]);

      if($dbResult) {
        $trans_id = DB::connection() -> getPdo() -> lastInsertId();
      }

      $tinfo = DB::insert('INSERT INTO transactions_info(transaction_number, receipt_number, date_bought, company_name, description_justification, total, transaction_id)
        VALUES(:tn, :rn, :db, :cn, :dj, :total, :trans_id)', ['tn'=>$transaction_number, 'rn'=>$receipt_number, 'db'=>$date_bought, 'cn'=>$company_name
        , 'dj'=>$descJust, 'total'=>$total, 'trans_id'=>$trans_id]);

        if($tinfo) {
          $tinfo_id = DB::connection() -> getPdo() -> lastInsertId();
        //  $imageArray[] = $image_id;
        }


      foreach ($file['file'] as $image){

        $uuid = DB::select('SELECT UUID() as "uuid"');
        $uuid = json_decode(json_encode($uuid),true);

        $uuid = $uuid[0]['uuid'] . '-' . $image->getClientOriginalName();

        $destinationPath = storage_path() . '/uploads';
             if(!$image->move($destinationPath, $uuid)) {
                 return $this->errors(['message' => 'Error saving the file.', 'code' => 400]);
             }

        $destinationPath = '../../storage/uploads/' . $uuid;

        $image_call = DB::insert('INSERT INTO images(image_path)
          VALUES (:blob)' , ['blob' => $destinationPath]);

          if($image_call) {
            $image_id = DB::connection() -> getPdo() -> lastInsertId();
            $imageArray[] = $image_id;
          }
      }

      foreach($imageArray as $img) {
        DB::insert('INSERT INTO transaction_images(image_id, tinfo_id)
        VALUES (:img, :trans_id)', ['img' => $img, 'trans_id'=>$tinfo_id]);
      }

      foreach($items as $item) {
        $item_name = $item['item_name'];
        $item_price = $item['item_price'];
        $quantity = $item['quantity'];
        $list_of_accounts = $item['list_of_accounts'];


        $dbResult = DB::insert("INSERT INTO items(item_name, item_price, quantity, transaction_id, pi_allowed_item)
          VALUES(:item_name,:item_price,:quantity,:transaction_id, 1);",
            ['item_name' => $item_name, 'item_price' => $item_price, 'quantity' => $quantity, 'transaction_id' => $trans_id]);


        if($dbResult) {
          $id = DB::connection() -> getPdo() -> lastInsertId();
        }

        foreach ($list_of_accounts as $value) {
          DB::insert("INSERT INTO items_paid_from (ra_id, item_id) VALUES(:ra_id, :item_id)", ['ra_id' => $value, 'item_id' => $id]);

          $amountToSub = $item_price * $quantity;
          DB::update('UPDATE research_accounts
            SET budget_remaining = budget_remaining - :amountToSub
            WHERE ra_id = :ra_id', ['ra_id' => $value, 'amountToSub' => $amountToSub]);

          $researcher_name = DB::select('SELECT first_name, last_name
            FROM  user_info natural join researchers
            WHERE researcher_id = :rid',['rid'=> $researcher_id]);

          $researcher_name = json_decode(json_encode($researcher_name), true);
          $researcher_name = $researcher_name[0]['first_name'] .' '. $researcher_name[0]['last_name'];

          $needAuth = DB::select('SELECT be_notified
            FROM research_accounts
            WHERE ra_id = :ra_id AND be_notified = 1 AND principal_investigator != :name',['ra_id' => $value, 'name' => $researcher_name]);
          if(!empty($needAuth)) {
            DB::update('UPDATE items
              SET pi_allowed_item = 0
              WHERE item_id = :id',['id' => $id]);
            DB::update('UPDATE transactions
              SET checked_pi = 0, status = "Awaiting for PI approval"
              WHERE transaction_id = :tid', ['tid' => $trans_id]);
          }
        }

      }

      $name = DB::select('SELECT first_name, last_name
        FROM researchers NATURAL JOIN user_info
        WHERE researcher_id = :rid', ['rid' => $researcher_id]);

      $name = json_decode(json_encode($name), true);
      $name = $name[0];

      $full_name = $name['first_name'] . ' ' . $name['last_name'];

      DB::insert('INSERT INTO researchers_timestamps (action, timestamp, transaction_id, researcher_id, name)
        VALUES ("Created New Transaction", CURRENT_TIMESTAMP, :tid, :aid, :name)', ['tid' => $trans_id,
          'aid' => $researcher_id, 'name' => $full_name]);

    });
  }

  public function editItem(Request $request, $transaction_id) {

     DB::transaction(function() use ($transaction_id, &$response, $request) {
      json_decode($request);

      $item = $request['items'];

      //foreach($items as $item) {

        $item_name = $item['item_name'];
        $item_price = $item['item_price'];
        $quantity = $item['quantity'];
        $ra_id = $item['ra_id'];
      //  $response = $list_of_accounts;

        if(!empty($item['item_id'])) {
          DB::update('UPDATE items
            SET item_name = :item_name, item_price = :item_price, quantity = :quantity
            WHERE item_id = :item_id', ['item_name' => $item_name, 'item_price' => $item_price,
            'quantity' => $quantity, 'item_id' => $item['item_id']]);

          DB::delete('DELETE FROM items_paid_from WHERE item_id = :item_id AND ra_id = :ra_id', ['item_id' => $item['item_id'], 'ra_id' => $ra_id]);

          //foreach ($list_of_accounts as $value) {
            DB::insert("INSERT INTO items_paid_from (ra_id, item_id) VALUES(:ra_id, :item_id)", ['ra_id' => $ra_id, 'item_id' => $item['item_id']]);
          //}
          $response = "Item Updated";
        }

        // else {
        //
        //   $dbResult = DB::insert("INSERT INTO items(item_name, item_price, quantity, transaction_id)
        //     VALUES(:item_name,:item_price,:quantity,:transaction_id);",
        //       ['item_name' => $item_name, 'item_price' => $item_price, 'quantity' => $quantity, 'transaction_id' => $transaction_id]);
        //
        //
        //   if($dbResult) {
        //     $id = DB::connection() -> getPdo() -> lastInsertId();
        //   }
        //
        //   foreach ($list_of_accounts as $value) {
        //     DB::insert("INSERT INTO items_paid_from (ra_id, item_id) VALUES(:ra_id, :item_id)", ['ra_id' => $value, 'item_id' => $id]);
        //   }
        //   $response = "Item Updated";
        // }

      //}
      //////////////////////////////////OPTIONAL//////////////////////////////////////////////////////////////////////////////
      // timestamp and notification when editing transaction items
      // $transactions_info = DB::select('SELECT first_name, last_name, researcher_id, accountant_id
      //   FROM (researchers NATURAL JOIN user_info), transactions
      //   WHERE researchers.researcher_id = transactions.researcher_id
      //   AND transaction_id = :tid', ['tid' => $transaction_id]);
      //
      // $transactions_info = json_decode(json_encode($transactions_info), true);
      // $transactions_info = $transactions_info[0];
      //
      // $full_name = $transactions_info['first_name'] . ' ' . $transactions_info['last_name'];
      // $researcher_id = $transactions_info['researcher_id'];
      // $accountant_id = $transactions_info['accountant_id'];
      //
      // $notification_body = $full_name . " edited transaction's item list";
      //
      // $timestamp = DB::insert('INSERT INTO researchers_timestamps (action, timestamp, transaction_id, researcher_id, name)
      //   VALUES ("Transaction Items Edited", CURRENT_TIMESTAMP, :tid, :rid, :name)', ['tid' => $transaction_id,
      //   'rid' => $researcher_id, 'name' => $full_name]);
      //
      // if ($timestamp){
      //   $timestamp_id = DB::connection()->getPdo()->lastInsertId();
      // }
      //
      // $researcher = json_decode(json_encode($researcher), true);
      // $researcher_id = $researcher[0]['researcher_id'];
      //
      // DB::insert('INSERT INTO accountant_notifications (notification_body, marked_as_read, at_id, accountant_id)
      //   VALUES (:nb, 0, :atid, :rid)', ['nb' => $notification_body,
      //   'atid' => $timestamp_id, 'rid' => $accountant_id]);
    });
    return $response;
  }

  public function uploadImage(Request $request, $transaction_id) {

    $file = Input::file();

    DB::transaction(function() use ($transaction_id, &$response, $request, $file) {

      $tinfo_id = DB::select('SELECT tinfo_id FROM transactions NATURAL JOIN transactions_info WHERE transaction_id = :tid',
        ['tid' => $transaction_id]);

        $tinfo_id = json_decode(json_encode($tinfo_id),true);
        $tinfo_id = $tinfo_id[0]['tinfo_id'];

      foreach ($file['file'] as $image){

        $uuid = DB::select('SELECT UUID() as "uuid"');
        $uuid = json_decode(json_encode($uuid),true);

        $uuid = $uuid[0]['uuid'] . '-' . $image->getClientOriginalName();

        $destinationPath = storage_path() . '/uploads';
             if(!$image->move($destinationPath, $uuid)) {
                 return $this->errors(['message' => 'Error saving the file.', 'code' => 400]);
             }

        $destinationPath = '../../../storage/uploads/' . $uuid;


        $image_call = DB::insert('INSERT INTO images(image_path)
          VALUES (:blob)' , ['blob' => $destinationPath]);

          if($image_call) {
            $image_id = DB::connection() -> getPdo() -> lastInsertId();
            $imageArray[] = $image_id;
          }
      }

      foreach($imageArray as $img) {
        DB::insert('INSERT INTO transaction_images(image_id, tinfo_id)
        VALUES (:img, :trans_id)', ['img' => $img, 'trans_id'=>$tinfo_id]);
      }

    });

  }

  public function editResearchAccount(Request $request, $ra_id) {
    DB::transaction(function() use ($ra_id, &$response, $request) {

    json_decode($request);

    $nickname = $request["research_nickname"];
    $ufis_number = $request["ufis_account_number"];
    $unofficial_limit = $request["unofficial_budget"];
    $unofficial_remaining = $request["budget_remaining"];
    $frs_number = $request["frs_account_number"];
    $list_of_copi = $request["list_of_copi"];
    $is_notified = $request["is_notified"];
    $researcher_id = $request['researcher_id'];
    $response = 'Research Account Edit Failed';

      DB::update('UPDATE research_accounts
        SET research_nickname = :nickname, ufis_account_number =:ufis_number, frs_account_number =:frs_number,
          unofficial_budget=:unofficial_limit, budget_remaining = :unofficial_remaining, be_notified = :is_notified
        WHERE ra_id = :ra_id',['ra_id' => $ra_id, 'nickname' => $nickname, 'ufis_number' => $ufis_number, 'frs_number' => $frs_number, 'unofficial_limit' => $unofficial_limit, 'unofficial_remaining' => $unofficial_remaining,
        'is_notified' => $is_notified]);
      $response = 'Research Account Edit Successful';

      if(!empty($list_of_copi)) {
        DB::delete('DELETE FROM researcher_has_accounts WHERE ra_id = :ra_id AND researcher_id != :rid', ['ra_id' => $ra_id, 'rid' => $researcher_id]);

        foreach ($list_of_copi as $value) {
          DB::insert("INSERT INTO researcher_has_accounts (ra_id, researcher_id) VALUES(:ra_id, :researcher_id)", ['ra_id' => $ra_id, 'researcher_id' => $value]);
        }
      }
      else {
        DB::delete('DELETE FROM researcher_has_accounts WHERE ra_id = :ra_id AND researcher_id != :rid', ['ra_id' => $ra_id, 'rid' => $researcher_id]);
      }
    });
    return $response;
  }

  public function getResearchAccount($ra_id, $researcher_id) {

    $ra_info = DB::select('SELECT research_nickname, ufis_account_number, frs_account_number, unofficial_budget, budget_remaining, be_notified, principal_investigator
    FROM research_accounts
    WHERE ra_id = :ra_id',['ra_id' => $ra_id]);


    $list_of_copi = DB::select('	SELECT first_name, last_name, researcher_id
    FROM  researcher_has_accounts natural join research_accounts natural join researchers as R, user_info as UI
    WHERE researcher_id != :rid AND ra_id = :ra_id AND R.user_info_id = UI.user_info_id ',['rid'=> $researcher_id, 'ra_id' => $ra_id]);

    $response = array(
      'research_account_info' => $ra_info,
      'list_of_copi' => $list_of_copi
    );


    return $response;
  }

  public function editResearcherProfile(Request $request, $researcher_id) {
    $response = "Researcher info update failed";
    DB::transaction(function() use ($researcher_id, &$response, $request) {
      json_decode($request);
      $office = $request['office'];
      $department = $request['department'];
      $phone_number = $request['phone_number'];
      $job_title = $request['job_title'];
      $employee_id = $request['employee_id'];

      DB::update('UPDATE user_info natural join researchers
        SET office = :office, department = :department, phone_number = :phone_number, job_title = :job_title, employee_id = :employee_id
        WHERE researcher_id = :rid', ['office' => $office, 'department'=> $department, 'phone_number' => $phone_number,
          'job_title' => $job_title, 'rid'=>$researcher_id, 'employee_id' => $employee_id]);
      $response = "Researcher info update Successful";
    });

    return $response;
  }

  public function getImages($transaction_id) {

    $images =  DB::select('SELECT image_path
      FROM transactions natural join transactions_info natural join transaction_images natural join images
      WHERE transactions.transaction_id = :tid', ['tid' => $transaction_id]);

     return $images;

    }

  public function editTransactionInfo(Request $request, $transaction_id){

    $checkIfExist = DB::select('SELECT * FROM transactions natural join transactions_info WHERE transaction_id = :tid',['tid'=>$transaction_id]);

     if(!empty(json_decode(json_encode($checkIfExist), true))){
       json_decode($request);
       $transaction_number = $request['transaction_number'];
       $company_name = $request['company_name'];
       $receipt_date = $request['date_bought'];
       $justification = $request['description_justification'];
       $total = $request['total'];

       DB::update('UPDATE transactions_info
       SET company_name = :cn, date_bought = :db, transaction_number = :tn, description_justification = :dj, total = :total
       WHERE transaction_id = :tid', ['cn' => $company_name, 'db' => $receipt_date, 'tn' => $transaction_number, 'dj' => $justification, 'tid' => $transaction_id, 'total' => $total]);

      $researcher_info = DB::select('SELECT R.researcher_id, first_name, last_name
         FROM transactions, researchers as R, user_info as UI
         WHERE R.user_info_id = UI.user_info_id AND transaction_id = :tid AND transactions.researcher_id = R.researcher_id', ['tid' => $transaction_id]);
      $researcher_info = json_decode(json_encode($researcher_info), true);
      $researcher_info = $researcher_info[0];

      $full_name = $researcher_info['first_name'] . ' ' . $researcher_info['last_name'];

      DB::insert('INSERT INTO researchers_timestamps (action, timestamp, transaction_id, researcher_id, name)
        VALUES ("Edited Transaction", CURRENT_TIMESTAMP, :tid, :rid, :name)', ['tid' => $transaction_id,
          'rid' => $researcher_info['researcher_id'], 'name' => $full_name]);

          ////////////////////////////////////////////timestamp////////////////////////////////////////



          ////////////////////////////////////////////notification////////////////////////////////////////

       return response('Transaction Information Updated', 200);
     }
     else{
       return "Transaction Does Not Exist";
     }

  }

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
     * Gets All tof the reseachers timestamp per transaction
     * @param  int $transaction_id - transaction_id received via the request
     * @return JSON response - contains all of the timestamps made by a reseacher on the
     * chosen transaction
     */
    public function getResearcherTimestamps($transaction_id) {
      $response = DB::select('SELECT * FROM researchers_timestamps WHERE transaction_id = :tid',
        ['tid' => $transaction_id]);
        return $response;
    }

    /**
     * Gets All tof the accountants timestamp per transaction
     * @param  int $transaction_id - transaction_id received via the request
     * @return JSON response - contains all of the timestamps made by an accountant on the
     * chosen transaction
     */
    public function getAccountantTimestamps($transaction_id) {
      $response = DB::select('SELECT * FROM accountants_timestamps WHERE transaction_id = :tid',
        ['tid' => $transaction_id]);
      return $response;
    }

    /**
     * Gets All of the timestamps of the transaction
     * @param  int $transaction_id - transaction_id received via the request
     * @return JSON response - contains all (researchers + accountants)
     * of the timestamps made on the given transaction ordered by from oldest to newest
     */
    public function getAllTransactionTimestamps($transaction_id) {

      $response = DB::select('SELECT *
          FROM (SELECT * FROM accountants_timestamps
            union
            SELECT * FROM researchers_timestamps) as TS
          WHERE transaction_id = :tid
          ORDER BY timestamp ASC', ['tid' => $transaction_id]);
      return $response;
    }

    /**
     * [postMarkNotificationAsRead description]
     * This function will access the MariaDB and update
     * the selected notification's status to read
     *
     * @param  [int]  $notification_id - notification id received via the request
     * @return [string] $response     - string response from the database.
     *                                  If successful, response is "Mark as Read Successful"
    */
    public function postMarkNotificationAsRead($notification_id)
    {

      DB::transaction(function() use ($notification_id, &$response) {
        $audit = DB::update('UPDATE researcher_notifications
          SET marked_as_read = 1
          WHERE rn_id = :nid',
          ['nid'=> $notification_id]);

        $response = "Mark as Read Successful";
      });

      return $response;

    }

    public function getAllResearchAccounts($researcher_id) {
      $response = DB::select('SELECT research_nickname, ufis_account_number, budget_remaining, unofficial_budget, ra_id
      FROM  researcher_has_accounts natural join research_accounts natural join researchers natural join user_info
      WHERE researcher_id = :rid', ['rid' => $researcher_id]);

      return $response;
    }

    public function postCycle($request) {

      $month = date('m');
      $year =  date('Y');
      $receipt = str_replace("-", "/", $request);

      $lowerDayLimit = '18';
      $upperDayLimit = '17';

      $upperBound = $year . '/' . $month . '/' . $upperDayLimit;
      if($month === '01') {
        $lowerBound = ($year - 1) . '/' . ($month - 1) . '/' . $lowerDayLimit;
      }
      else {
        $lowerBound = $year . '/' . ($month - 1) . '/' . $lowerDayLimit;

      }


       $rec = DateTime::createFromFormat('Y/m/d', $receipt);
       $rec = $rec->getTimestamp();

        $low = DateTime::createFromFormat('Y/m/d', $lowerBound);
        $low = $low->getTimestamp();

        $high = DateTime::createFromFormat('Y/m/d', $upperBound);
        $high = $high->getTimestamp();

        $difference = $high - $rec;

       //if receipt date is on or before the limit date
        if($difference >= 0) {
          //OK... for upper bound now check lowerBound
          $difference = $rec - $low;
          //if receipt date is on or LATER of the start of the cycle
          if($difference >=0) {
            //OK.. MEANS that it is in range
              $monthNum  = $month;
              $dateObj   = DateTime::createFromFormat('!m', $monthNum);
              $monthName = $dateObj->format('F');
              return $monthName . ' ' . $year;
          }

          else {
            //si es menor
            $monthNum  = $month;
            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F');
            return $monthName . ' ' . $year . ' but it is from the last cycle';
          }

        }

        else {
          //se paso so next CYCLE
          $monthNum  = $month + 1;
          if($month === 12) {
            $year = $year + 1;
          }
          $dateObj   = DateTime::createFromFormat('!m', $monthNum);
          $monthName = $dateObj->format('F');
          return $monthName . ' ' . $year;
        }
    }

    public function auditItem($pi_allowed_item, $item_id, $transaction_id) {
        if($pi_allowed_item == 1) {
          DB::update('UPDATE items
            SET pi_allowed_item = 1
            WHERE item_id = :item_id', ['item_id' => $item_id]);
          $response = "Item has ben verified by the PI";
        // Now check if all items have been approved by the PIs
          $allItems = DB::select('SELECT pi_allowed_item
            FROM items
            WHERE transaction_id = :tid AND pi_allowed_item = 0', ['tid' => $transaction_id]);

          $allItems = json_decode(json_encode($allItems),true);
          if(empty($allItems)) {
            //All items have pi_allowed_item = 1 which means it does not need PI approval.
            DB::update('UPDATE transactions
              SET checked_pi = 1, status = "unassigned"
              WHERE transaction_id = :tid', ['tid' => $transaction_id]);
            $response = "All Items have been approved";
            return $response;
          }

        }
        elseif($pi_allowed_item == 0) {

          DB::update('UPDATE items
            SET pi_allowed_item = 0
            WHERE item_id = :item_id', ['item_id' => $item_id]);

          DB::update('UPDATE transactions
            SET status = "Item denied by PI"
            WHERE transaction_id = :tid', ['tid' => $transaction_id]);
          return "Item has been denied";
          }
      return $response;
    }

    public function deleteFile(Request $request, $transaction_id, $tinfo_id) {
      json_decode($request);
      $image_id = $request['image_id'];
      DB::delete('DELETE FROM transaction_images
        WHERE image_id = :image_id AND tinfo_id = :tinfo_id', ['image_id' => $image_id, 'tinfo_id' => $tinfo_id]);
      DB::delete('DELETE FROM images
        WHERE image_id = :image_id', ['image_id' => $image_id]);
      return "File has been deleted.";
    }

    public function deleteItem($item_id) {
      DB::update('DELETE FROM items_paid_from
      WHERE item_id = :item_id', ['item_id' => $item_id]);

      DB::update('DELETE FROM items
      WHERE item_id = :item_id', ['item_id' => $item_id]);

      return "Item has been deleted.";

    }
}
