<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AccountantTransactionController extends Controller
{

  ////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////SELECTS////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
 /**
  * [getAssignedTransactions description]
  * This function will access the MariaDB and select all of
  * the transactions assigned to the an investigator
  *
  * @param  [int]  $accountant_id - accountant id received via the request
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
  * first_name - string
  * last_name - string
  * }
 */
 public function getAssignedTransactions($accountant_id)
 {

    DB::transaction(function() use ($accountant_id, &$results) {
      $results = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, transactions_info.company_name, transactions_info.date_bought,
        user_info.first_name, user_info.last_name
        FROM (transactions NATURAL JOIN transactions_info), (user_info NATURAL JOIN researchers)
        WHERE transactions.researcher_id = researchers.researcher_id AND transactions.accountant_id = :aid',
        ['aid'=> $accountant_id]);
    });

    return $results;

  }

  /**
   * [getTransaction description]
   * This function will access the MariaDB and select all of
   * the selected transaction's information
   *
   * @param  [int]  transaction_id - transaction id received via the request
   * @return [JSON] $results      - JSON response from the database
   *
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
   * $notes = {
   * comment_id - int
   * created_at - DATE
   * updated_at - DATE
   * body_of_note - string
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
  */
  public function getTransaction($accountant_id, $transaction_id)
  {

    DB::transaction(function() use ($transaction_id, $accountant_id, &$results) {
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

      $notes = DB::select('SELECT notes.*, user_info.first_name, user_info.last_name
        FROM notes, (accountants NATURAL JOIN user_info)
        WHERE notes.accountant_id = accountants.accountant_id AND notes.transaction_id = :tid AND notes.accountant_id = :aid',
        ['tid'=> $transaction_id, 'aid'=> $accountant_id]);

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
        'notes' => $notes,
        'accountant' => $accountant,
        'researcher' => $researcher,
        'credit_card' => $credit_card,
        'images' => $images,
        'date' => date('Y-m-d H:i:s')
      );
    });

    return $results;

  }

  /**
   * [getValidatedTransactions description]
   * This function will access the MariaDB and select all of
   * the validated transactions of the selected accountant
   *
   * @param  [int]  accountant - accountant id received via the request
   * @return [JSON] $results   - JSON response from the database
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
   * first_name - string
   * last_name - string
   * }
  */
  public function getValidatedTransactions($accountant_id)
  {

    DB::transaction(function() use ($accountant_id, &$results) {
      $results = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, user_info.first_name, user_info.last_name
        FROM (transactions NATURAL JOIN transactions_info), (user_info NATURAL JOIN researchers)
        WHERE transactions.researcher_id = researchers.researcher_id AND transactions.accountant_id = :aid
        AND transactions.status = "approved"',
        ['aid'=> $accountant_id ]);
    });

    return $results;

  }

  /**
   * [getUnassignedTransactions description]
   * This function will access the MariaDB and select all of
   * the validated transactions of the selected accountant
   *
   * @return [JSON] $results   - JSON response from the database
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
   * first_name - string
   * last_name - string
   * }
  */
  public function getUnassignedTransactions()
  {

    DB::transaction(function() use (&$results) {
      $results = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, user_info.first_name, user_info.last_name
        FROM (transactions NATURAL JOIN transactions_info), (user_info NATURAL JOIN researchers)
        WHERE transactions.researcher_id = researchers.researcher_id AND transactions.status = "unassigned"');
    });

    return $results;

  }

  /**
   * [getAllTransactions description]
   * This function will access the MariaDB and select all of
   * the transactions in the database
   *
   * @return [JSON] $results   - JSON response from the database
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
   * first_name - string
   * last_name - string
   * }
  */
  public function getAllTransactions()
  {

    DB::transaction(function() use (&$results) {
      $results = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, transactions_info.company_name,
        transactions_info.date_bought, user_info.first_name, user_info.last_name
        FROM (transactions NATURAL JOIN transactions_info), (user_info NATURAL JOIN researchers)
        WHERE transactions.researcher_id = researchers.researcher_id AND transactions.checked_pi = 1'); //  AND transactions.checked_pi = 1 - for when the PI validation is completed
    });

    return $results;

  }

  /**
   * [getAccountantPassword description]
   * This function will access the MariaDB and select the password
   * from the selected accountant
   *
   * @param   [int]  accountant_id - accountant id received via the request
   * @return [JSON] $results      - JSON response from the database
   *
   * JSON structure:
   * $results = {
   * password - string
   * }
  */
  public function getAccountantPassword($accountant_id)
  {

    DB::transaction(function() use ($accountant_id, &$results) {
      $results = DB::select('SELECT password
        FROM accountants NATURAL JOIN user_info
        WHERE accountant_id = :aid' ,
        ['aid'=> $accountant_id]);
    });

    return $results;

  }

  /**
   * [getAllNotifications description]
   * This function will access the MariaDB and select all of
   * the notifications of the accountant
   * @param  [type]  $accountant_id - accountant id received via the request
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
  public function getAllNotifications($accountant_id) {

    DB::transaction(function() use ($accountant_id, &$results)
    {

      $admin_timestamps = DB::select('SELECT an_id, notification_body, marked_as_read, transaction_id, admin_timestamps.timestamp
        FROM  accountant_notifications NATURAL JOIN admin_timestamps
        WHERE accountant_id = :aid
        ORDER BY admin_timestamps.timestamp DESC',['aid'=> $accountant_id]);

      $accountants_timestamps = DB::select('SELECT an_id, notification_body, marked_as_read, transaction_id, accountants_timestamps.timestamp
        FROM  accountant_notifications NATURAL JOIN accountants_timestamps
        WHERE accountant_id = :aid
        ORDER BY accountants_timestamps.timestamp DESC',['aid'=> $accountant_id]);

      $results = array(
        'admin_assign' => $admin_timestamps,
        'accountant_assign' => $accountants_timestamps
      );
    });

    return $results;

  }

  /**
   * [getTop10Notifications description]
   * This function will access the MariaDB and select the top 10 of
   * the notifications of the accountant
   * @param  [type]  $accountant_id - accountant id received via the request
   * @return [JSON] $results      - JSON response from the database
   *
   * JSON structure:
   * $results = {
   * an_id - int
   * notification_body - string
   * marked_as_read - int
   * transaction_id - int
   * timestamp - DATE
   * }
   */
  public function getTop10Notifications($accountant_id) {

    DB::transaction(function() use ($accountant_id, &$results)
    {

      $notification_ids = DB::select('SELECT an_id, at_id, admin_timestamp_id
        FROM  accountant_notifications
        WHERE accountant_id = :aid AND NOT (at_id IS NULL AND admin_timestamp_id IS NULL)
        ORDER BY an_id DESC
        LIMIT 10',['aid'=> $accountant_id]);

      $notification_ids = json_decode(json_encode($notification_ids, true));
      $results = [];

      for($index = 0; $index < count($notification_ids); $index ++){
        $notification = (array) $notification_ids[$index];

        // Check if notification from accountant
        if($notification['at_id'] != NULL){
          $notification_info = DB::select('SELECT an_id, notification_body, marked_as_read, transaction_id, accountants_timestamps.timestamp
            FROM  accountant_notifications NATURAL JOIN accountants_timestamps
            WHERE an_id = :anid',['anid'=> $notification['an_id']]);

          $notification_info = json_decode(json_encode($notification_info));
          $notification_info = (array) $notification_info[0];

          $results += array($index => array('an_id' => $notification_info['an_id'],
            'notification_body' => $notification_info['notification_body'],
            'marked_as_read' => $notification_info['marked_as_read'],
            'transaction_id' => $notification_info['transaction_id'],
            'timestamp' => $notification_info['timestamp']));
        }

        // Notification is from administrator
        elseif($notification['admin_timestamp_id'] != NULL) {
          $notification_info = DB::select('SELECT an_id, notification_body, marked_as_read, transaction_id, admin_timestamps.timestamp
            FROM  accountant_notifications NATURAL JOIN admin_timestamps
            WHERE an_id = :anid',['anid'=> $notification['an_id']]);

          $notification_info = json_decode(json_encode($notification_info));
          $notification_info = (array) $notification_info[0];

          $results += array($index => array('an_id' => $notification_info['an_id'],
            'notification_body' => $notification_info['notification_body'],
            'marked_as_read' => $notification_info['marked_as_read'],
            'transaction_id' => $notification_info['transaction_id'],
            'timestamp' => $notification_info['timestamp']));
        }
      }
    });

    return $results;

  }

  /**
   * [getAssignedTransactionsInProgress description]
   * This function will access the MariaDB and select all of
   * the assigned transactions of the selected accountant that are in progress
   *
   * @return [JSON] $results   - JSON response from the database
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
   * first_name - string
   * last_name - string
   * }
  */
  public function getAssignedTransactionsInProgress($accountant_id)
  {

    DB::transaction(function() use ($accountant_id, &$results) {
      $results = DB::select('SELECT DISTINCT transactions.*, transactions_info.total, user_info.first_name, user_info.last_name
        FROM (transactions NATURAL JOIN transactions_info), (user_info NATURAL JOIN researchers)
        WHERE transactions.researcher_id = researchers.researcher_id AND transactions.status = "in progress"
        AND transactions.accountant_id = :aid',
        ['aid' => $accountant_id]);
    });

    return $results;

  }

  ////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////UPDATES////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
  /**
   * [putAuditTransaction description]
   * This function will access the MariaDB and update
   * the selected transaction's status
   *
   * @param  [int]  transaction_id - transaction id received via the request
   *         [string] report_status - new status of the transaction report
   *                                  received via the request
   * @return [string] $response     - string response from the database.
   *                                  If successful, response is "Audit Successful"
  */
  public function putAuditTransaction($transaction_id, $report_status, $accountant_id)
  {

    DB::transaction(function() use ($transaction_id, $report_status, $accountant_id, &$response) {
      $audit = DB::update('UPDATE transactions
        SET status= :rs
        WHERE transaction_id = :tid',
        ['tid'=> $transaction_id, 'rs'=> $report_status]);

      $name = DB::select('SELECT first_name, last_name
        FROM accountants NATURAL JOIN user_info
        WHERE accountant_id = :aid', ['aid' => $accountant_id]);

      $name = json_decode(json_encode($name), true);
      $name = $name[0];

      $full_name = $name['first_name'] . ' ' . $name['last_name'];

      $accountant_audition_result = "";
      $notification_body = "";

      if($report_status == "denied"){
        $accountant_audition_result = "Denied Transaction";
        $notification_body = "Your transaction was denied by " . $full_name . ".";
      }
      elseif ($report_status == "approved") {
        $accountant_audition_result = "Approved Transaction";
        $notification_body = "Your transaction was approved by " . $full_name . ".";

        $items = DB::select('SELECT item_id, ra_id, item_price, quantity
            FROM transactions natural join transactions_info natural join items natural join items_paid_from
            WHERE transaction_id = :tid', ['tid' => $transaction_id]);
        $items = json_decode(json_encode($items), true);
        if(!empty($items)) {
          foreach($items as $item) {
            $amount = $item['item_price'] * $item['quantity'];
            DB::update('UPDATE research_accounts
              SET budget_remaining = budget_remaining + :amount
              WHERE ra_id = :ra_id', ['amount' => $amount, 'ra_id' => $item['ra_id']]);
          }
        }
      }
      elseif ($report_status == "escalated") {
        $accountant_audition_result = "Escalated Transaction";
        $notification_body = "Your transaction was escalated by " . $full_name . ".";
      }
      elseif ($report_status == "closed") {
        $accountant_audition_result = "Escalated Transaction";
        $notification_body = "Your transaction was closed by " . $full_name . ".";
      }
      else{
        $accountant_audition_result = "Unathorized Charge in Transaction";
        $notification_body = "Your transaction has an unathorized charge found by " . $full_name . ".";
      }

      $timestamp = DB::insert('INSERT INTO accountants_timestamps (action, timestamp, transaction_id, accountant_id, name)
        VALUES (:rs, CURRENT_TIMESTAMP, :tid, :aid, :name)', ['tid' => $transaction_id,
        'aid' => $accountant_id, 'name' => $full_name, 'rs' => $accountant_audition_result]);

      if ($timestamp){
        $timestamp_id = DB::connection()->getPdo()->lastInsertId();
      }

      $researcher = DB::select('SELECT researchers.researcher_id
        FROM researchers,transactions
        WHERE transaction_id = :tid AND researchers.researcher_id = transactions.researcher_id', ['tid' => $transaction_id]);

      $researcher = json_decode(json_encode($researcher), true);
      $researcher_id = $researcher[0]['researcher_id'];

      DB::insert('INSERT INTO researcher_notifications (notification_body, marked_as_read, at_id, researcher_id)
        VALUES (:nb, 0, :atid, :rid)', ['nb' => $notification_body,
        'atid' => $timestamp_id, 'rid' => $researcher_id]);

      $response = "Audit Successful";
    });

    return $response;

  }

  /**
   * [putAssignTransaction description]
   * This function will access the MariaDB and update
   * the selected transaction's accountant_id and status
   *
   * @param  [int]  transaction_id - transaction id received via the request
   *         [int]  accountant_id  - transaction id received via the request
   * @return [string] $response     - string response from the database.
   *                                  If successful, response is "Assign Successful"
  */
  public function putAssignTransaction($transaction_id, $accountant_id)
  {

    DB::transaction(function() use ($accountant_id, $transaction_id, &$response) {
      $results = DB::update('UPDATE transactions
        SET accountant_id= :aid, status = "in progress"
        WHERE transaction_id = :tid',
        ['tid'=> $transaction_id, 'aid'=> $accountant_id]);

      $name = DB::select('SELECT first_name, last_name
        FROM accountants NATURAL JOIN user_info
        WHERE accountant_id = :aid', ['aid' => $accountant_id]);

      $name = json_decode(json_encode($name), true);
      $name = $name[0];

      $full_name = $name['first_name'] . ' ' . $name['last_name'];

      $timestamp = DB::insert('INSERT INTO accountants_timestamps (action, timestamp, transaction_id, accountant_id, name)
        VALUES ("Assigned Transaction", CURRENT_TIMESTAMP, :tid, :aid, :name)', ['tid' => $transaction_id,
        'aid' => $accountant_id, 'name' => $full_name]);

      if ($timestamp){
        $timestamp_id = DB::connection()->getPdo()->lastInsertId();
      }

      $notification_body = "You assigned a transaction to yourself";

      DB::insert('INSERT INTO accountant_notifications (notification_body, marked_as_read, at_id, accountant_id)
        VALUES (:nb, 0, :atid, :aid)', ['nb' => $notification_body,
        'atid' => $timestamp_id, 'aid' => $accountant_id]);

      $response = "Assign Successful";
    });

    return $response;

  }

  /**
   * [putEditComment description]
   * This function will access the MariaDB and update
   * the selected comment's information
   *
   * @param  [int]  comment_id - comment id received via the request
   *         [JSON]  $request  - comment's new info received via the request
   * @return [string] $response     - string response from the database.
   *                                  If successful, response is "Edit Successful"
   *
   * JSON structure:
   * $request = {
   * updated_at - DATE
   * body_of_comment - string
   * }
  */
  public function putEditComment($comment_id, Request $request)
  {

    DB::transaction(function() use ($comment_id, $request) {
      $resquest = json_decode($request);

      $results = DB::update('UPDATE comments
        SET body_of_comment = :boc, updated_at = :uat
        WHERE comment_id = :cid',
        ['boc'=> $request['body_of_comment'], 'uat'=> $request['updated_at'], 'cid'=> $comment_id]);

      $accountant_info = DB::select('SELECT comments.accountant_id, comments.transaction_id, first_name, last_name
        FROM comments natural join accountants, user_info
        WHERE accountants.user_info_id = user_info.user_info_id and comment_id = :cid',
        ['cid' => $comment_id]);

      $accountant_info = json_decode(json_encode($accountant_info), true);
      $accountant_info = $accountant_info[0];

      $full_name = $accountant_info['first_name'] . ' ' . $accountant_info['last_name'];

      DB::insert('INSERT INTO accountants_timestamps (action, timestamp, transaction_id, accountant_id, name)
        VALUES ("Edited Comment", CURRENT_TIMESTAMP, :tid, :aid, :name)', ['tid' => $accountant_info['transaction_id'],
          'aid' => $accountant_info['accountant_id'], 'name' => $full_name]);


    });
    $response = "Edit Successful";
    return $response;

  }

  /**
   * [putEditNote description]
   * This function will access the MariaDB and update
   * the selected note's information
   *
   * @param  [int]  note_id - note id received via the request
   *         [JSON]  $request  - comment's new info received via the request
   * @return [string] $response     - string response from the database.
   *                                  If successful, response is "Edit Note Successful"
   *
   * JSON structure:
   * $request = {
   * updated_at - DATE
   * body_of_note - string
   * }
  */
  public function putEditNote($note_id, Request $request)
  {

    DB::transaction(function() use ($note_id, $request) {
      $resquest = json_decode($request);

      $results = DB::update('UPDATE notes
        SET body_of_note = :bon, updated_at = :uat
        WHERE note_id = :nid',
        ['bon'=> $request['body_of_note'], 'uat'=> $request['updated_at'], 'nid'=> $note_id]);

      $accountant_info = DB::select('SELECT notes.accountant_id, notes.transaction_id, first_name, last_name
        FROM notes natural join accountants, user_info
        WHERE accountants.user_info_id = user_info.user_info_id and note_id = :nid',
        ['nid' => $note_id]);

      $accountant_info = json_decode(json_encode($accountant_info), true);
      $accountant_info = $accountant_info[0];

      $full_name = $accountant_info['first_name'] . ' ' . $accountant_info['last_name'];

      DB::insert('INSERT INTO accountants_timestamps (action, timestamp, transaction_id, accountant_id, name)
        VALUES ("Edited Note", CURRENT_TIMESTAMP, :tid, :aid, :name)', ['tid' => $accountant_info['transaction_id'],
          'aid' => $accountant_info['accountant_id'], 'name' => $full_name]);
    });
    $response = "Edit Note Successful";
    return $response;

  }

  public function putEditResearchAccount($item_id, $item_code) {
    $response = 'Item Code Number edit failed';
    DB::transaction(function() use ($item_id, &$response, $item_code) {
      DB::update('UPDATE items
        SET item_code = :ic
        WHERE item_id = :item_id', ['item_id' => $item_id, 'ic' => $item_code]);
      $response = 'Item Code number update was successful';
    });
    return $response;
  }

  ////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////INSERTS////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
  /**
   * [postCommentTransaction description]
   * This function will access the MariaDB and insert a new comment by
   * the selected accountant
   *
   * @param  [int]  accountant_id - accountant id received via the request
   *         [JSON] $request - comment information received via the request
   * @return [string] $response  - string response from the database.
   *                                If successful, responce is "Post Comment Successful"
   *
   * JSON structure:
   * $request = {
   * transaction_id - int
   * created_at - DATE
   * updated_at - DATE
   * body_of_comment - string
   * }
  */
  public function postCommentTransaction($accountant_id, Request $request)
  {

    DB::transaction(function() use ($accountant_id, &$response, $request) {
      $resquest = json_decode($request);

      $results = DB::insert('INSERT INTO comments (comment_id, created_at, updated_at, body_of_comment, transaction_id, accountant_id)
        VALUES (NULL, CURRENT_TIMESTAMP, :ua, :boc, :tid, :aid)',
        ['tid'=> $request['transaction_id'], 'aid'=> $accountant_id,
        'ua'=> $request['updated_at'], 'boc'=> $request['body_of_comment']]);

      $name = DB::select('SELECT first_name, last_name
        FROM accountants NATURAL JOIN user_info
        WHERE accountant_id = :aid', ['aid' => $accountant_id]);

      $name = json_decode(json_encode($name), true);
      $name = $name[0];

      $full_name = $name['first_name'] . ' ' . $name['last_name'];

      DB::insert('INSERT INTO accountants_timestamps (action, timestamp, transaction_id, accountant_id, name)
        VALUES ("New Comment", CURRENT_TIMESTAMP, :tid, :aid, :name)', ['tid' => $request['transaction_id'],
          'aid' => $accountant_id, 'name' => $full_name]);
      });
    $response = "Post Comment Successful";
    return $response;

  }

  /**
   * [postNoteTransaction description]
   * This function will access the MariaDB and insert a new note by
   * the selected accountant
   *
   * @param  [int]  accountant_id - accountant id received via the request
   *         [JSON] $request - comment information received via the request
   * @return [string] $response  - string response from the database.
   *                                If successful, responce is "Post Note Successful"
   *
   * JSON structure:
   * $request = {
   * transaction_id - int
   * created_at - DATE
   * updated_at - DATE
   * body_of_note - string
   * }
  */
  public function postNoteTransaction($accountant_id, Request $request)
  {

    DB::transaction(function() use ($accountant_id, &$response, $request) {
      $resquest = json_decode($request);

      $results = DB::insert('INSERT INTO notes (note_id, created_at, updated_at, body_of_note, accountant_id, transaction_id)
        VALUES (NULL, CURRENT_TIMESTAMP, :ua, :bon, :aid, :tid)',
        ['tid'=> $request['transaction_id'], 'aid'=> $accountant_id,
        'ua'=> $request['updated_at'], 'bon'=> $request['body_of_note']]);

        $name = DB::select('SELECT first_name, last_name
          FROM accountants NATURAL JOIN user_info
          WHERE accountant_id = :aid', ['aid' => $accountant_id]);

        $name = json_decode(json_encode($name), true);
        $name = $name[0];

        $full_name = $name['first_name'] . ' ' . $name['last_name'];

        DB::insert('INSERT INTO accountants_timestamps (action, timestamp, transaction_id, accountant_id, name)
          VALUES ("New Note", CURRENT_TIMESTAMP, :tid, :aid, :name)', ['tid' => $request['transaction_id'],
            'aid' => $accountant_id, 'name' => $full_name]);

    });
    $response = "Post Note Successful";
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
      $audit = DB::update('UPDATE accountant_notifications
        SET marked_as_read = 1
        WHERE an_id = :nid',
        ['nid'=> $notification_id]);

      $response = "Mark as Read Successful";
    });

    return $response;

  }

  ////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////DELETES////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
  /**
   * [deleteComment description]
   * This function will access the MariaDB and delete
   * the selected comment
   *
   * @param  [int]  comment_id - comment id received via the request
   * @return [string] $response     - string response from the database.
   *                                  If successful, response is "Delete Successful"
  */
  public function deleteComment($comment_id)
  {

    DB::transaction(function() use ($comment_id) {


    $accountant_info = DB::select('SELECT comments.accountant_id, comments.transaction_id, first_name, last_name
      FROM comments natural join accountants, user_info
      WHERE accountants.user_info_id = user_info.user_info_id and comment_id = :cid',
      ['cid' => $comment_id]);

    $accountant_info = json_decode(json_encode($accountant_info), true);
    $accountant_info = $accountant_info[0];

    $full_name = $accountant_info['first_name'] . ' ' . $accountant_info['last_name'];

    DB::insert('INSERT INTO accountants_timestamps (action, timestamp, transaction_id, accountant_id, name)
      VALUES ("Deleted Comment", CURRENT_TIMESTAMP, :tid, :aid, :name)', ['tid' => $accountant_info['transaction_id'],
        'aid' => $accountant_info['accountant_id'], 'name' => $full_name]);

      $results = DB::delete('DELETE FROM comments
        WHERE comment_id = :cid',
        ['cid'=> $comment_id]);
    });
    $response = "Delete Successful";
    return $response;

  }

  /**
   * [deleteNote description]
   * This function will access the MariaDB and delete
   * the selected note
   *
   * @param  [int]  note_id - note id received via the request
   * @return [string] $response     - string response from the database.
   *                                  If successful, response is "Delete Note Successful"
  */
  public function deleteNote($note_id)
  {

    DB::transaction(function() use ($note_id) {

      $accountant_info = DB::select('SELECT notes.accountant_id, notes.transaction_id, first_name, last_name
        FROM notes natural join accountants, user_info
        WHERE accountants.user_info_id = user_info.user_info_id and note_id = :nid',
        ['nid' => $note_id]);

      $accountant_info = json_decode(json_encode($accountant_info), true);
      $accountant_info = $accountant_info[0];

      $full_name = $accountant_info['first_name'] . ' ' . $accountant_info['last_name'];

      DB::insert('INSERT INTO accountants_timestamps (action, timestamp, transaction_id, accountant_id, name)
        VALUES ("Deleted Note", CURRENT_TIMESTAMP, :tid, :aid, :name)', ['tid' => $accountant_info['transaction_id'],
          'aid' => $accountant_info['accountant_id'], 'name' => $full_name]);


      $results = DB::delete('DELETE FROM notes
        WHERE note_id = :nid',
        ['nid'=> $note_id]);
    });
    $response = "Delete Note Successful";
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

  public function deleteFile(Request $request, $transaction_id, $tinfo_id) {
    json_decode($request);
    $image_id = $request['image_id'];
    DB::delete('DELETE FROM transaction_images
      WHERE image_id = :image_id AND tinfo_id = :tinfo_id', ['image_id' => $image_id, 'tinfo_id' => $tinfo_id]);
    DB::delete('DELETE FROM images
      WHERE image_id = :image_id', ['image_id' => $image_id]);
    return "File has been deleted.";
  }

}
