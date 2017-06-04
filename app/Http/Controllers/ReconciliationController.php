<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;
use \DateTime;


class ReconciliationController extends Controller
{
    //
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function reconcileTransactions($file_path, $admin_id, $cycle)
    {

      $rows = Excel::load(base_path() . $file_path);
      config(['excel.import.heading' => false]);
      $rows = $rows->all();

      // Row counter
      $row_count = 0;

      // Search table first row column
      for($index = 0; $index < count($rows[0]); $index ++){

        // Table starting row found
        if(in_array("Report Date", json_decode(json_encode($rows[0][$index])), true)){
          $row_count = $index + 1;
          break;
        }
      }

      // Set table import first row
      config(['excel.import.startRow' => $row_count]);

      // Import with table header restore
      config(['excel.import.heading' => true]);

      // Read excel file from table starting row
      $rows = Excel::load(base_path() . $file_path)->all();
      $allTransactions = $rows[0];
      $response = [];
      $researcherTransactions = [];
      $report_cycle = "";

      // Extract all transactions from file
      foreach($allTransactions as $transaction){
        if($transaction['charge_amount'] != 0){
          $id = $transaction['card_member_acct._no.'];
          // First element
          if(empty($response)){
            $response = array($id
              => array($transaction['transaction_id']
                => array('product_type' => $transaction['product_type'],
                'last_name' => $transaction['last_name'],
                'first_name' => $transaction['first_name'],
                'middle_name' => $transaction['middle_name'],
                'prefix_name' => $transaction['prefix_name'],
                'suffix_name' => $transaction['suffix_name'],
                'full_name' => $transaction['full_name'],
                'card_member_acct._no.' => $transaction['card_member_acct._no.'],
                'guaranteed_status' => $transaction['guaranteed_status'],
                'employee_id' => $transaction['employee_id'],
                'control_acct._name' => $transaction['control_acct._name'],
                'control_acct._no.' => $transaction['control_acct._no.'],
                'cost_center' => $transaction['cost_center'],
                'universal_id' => $transaction['universal_id'],
                'email' => $transaction['email'],
                'card_member_reference' => $transaction['card_member_reference'],
                'domestic_or_international' => $transaction['domestic_or_international'],
                'transaction_limit_amount' => $transaction['transaction_limit_amount'],
                'monthly_limit_amount' => $transaction['monthly_limit_amount'],
                'business_process_date' => $transaction['business_process_date'],
                'charge_date' => $transaction['charge_date'],
                'roc_id' => $transaction['roc_id'],
                'transaction_id' => $transaction['transaction_id'],
                'transaction_description' => $transaction['transaction_description'],
                'supplier_name' => $transaction['supplier_name'],
                'supplier_no.' => $transaction['supplier_no.'],
                'mcc_group' => $transaction['mcc_group'],
                'mcc_no.' => $transaction['mcc_no.'],
                'mcc' => $transaction['mcc'],
                'supplier_reference' => $transaction['supplier_reference'],
                'supplier_address' => $transaction['supplier_address'],
                'supplier_city' => $transaction['supplier_city'],
                'supplier_stateprovince' => $transaction['supplier_stateprovince'],
                'supplier_postal_code' => $transaction['supplier_postal_code'],
                'supplier_country' => $transaction['supplier_country'],
                'industry' => $transaction['industry'],
                'supplier_chain' => $transaction['supplier_chain'],
                'supplier_brand' => $transaction['supplier_brand'],
                'preferred_supplier' => $transaction['preferred_supplier'],
                'preferred_supplier_list_id' => $transaction['preferred_supplier_list_id'],
                'submitted_currency' => $transaction['submitted_currency'],
                'charge_amount' => $transaction['charge_amount'],
                'credit_amount' => $transaction['credit_amount'],
                'no._of_charges' => $transaction['no._of_charges'],
                'no._of_credits' => $transaction['no._of_credits'],
                'previous_balance' => $transaction['previous_balance'],
                'closing_balance' => $transaction['closing_balance'],
                'submitted_currency_amount' => $transaction['submitted_currency_amount'],
                'jan_net_billed_amount' => $transaction['jan_net_billed_amount'],
                'feb_net_billed_amount' => $transaction['feb_net_billed_amount'],
                'mar_net_billed_amount' => $transaction['mar_net_billed_amount'],
                'apr_net_billed_amount' => $transaction['apr_net_billed_amount'],
                'may_net_billed_amount' => $transaction['may_net_billed_amount'],
                'jun_net_billed_amount' => $transaction['jun_net_billed_amount'],
                'jul_net_billed_amount' => $transaction['jul_net_billed_amount'],
                'aug_net_billed_amount' => $transaction['aug_net_billed_amount'],
                'sep_net_billed_amount' => $transaction['sep_net_billed_amount'],
                'oct_net_billed_amount' => $transaction['oct_net_billed_amount'],
                'nov_net_billed_amount' => $transaction['nov_net_billed_amount'],
                'dec_net_billed_amount' => $transaction['dec_net_billed_amount'],
                'ytd_net_billed_amount' => $transaction['ytd_net_billed_amount'],
                'ytd_no._of_charges' => $transaction['ytd_no._of_charges'],
                'report_date' => $transaction['report_date'])));
                $report_cycle = $this->getExcelCycle($transaction['report_date']);
          }
          else{
            // card_member_acct._no is not in the array
            if (array_key_exists($id, $response)) {
              $tempArray = &$response[$id];
              $tempArray += array($transaction['transaction_id']
                  => array('product_type' => $transaction['product_type'],
                  'last_name' => $transaction['last_name'],
                  'first_name' => $transaction['first_name'],
                  'middle_name' => $transaction['middle_name'],
                  'prefix_name' => $transaction['prefix_name'],
                  'suffix_name' => $transaction['suffix_name'],
                  'full_name' => $transaction['full_name'],
                  'card_member_acct._no.' => $transaction['card_member_acct._no.'],
                  'guaranteed_status' => $transaction['guaranteed_status'],
                  'employee_id' => $transaction['employee_id'],
                  'control_acct._name' => $transaction['control_acct._name'],
                  'control_acct._no.' => $transaction['control_acct._no.'],
                  'cost_center' => $transaction['cost_center'],
                  'universal_id' => $transaction['universal_id'],
                  'email' => $transaction['email'],
                  'card_member_reference' => $transaction['card_member_reference'],
                  'domestic_or_international' => $transaction['domestic_or_international'],
                  'transaction_limit_amount' => $transaction['transaction_limit_amount'],
                  'monthly_limit_amount' => $transaction['monthly_limit_amount'],
                  'business_process_date' => $transaction['business_process_date'],
                  'charge_date' => $transaction['charge_date'],
                  'roc_id' => $transaction['roc_id'],
                  'transaction_id' => $transaction['transaction_id'],
                  'transaction_description' => $transaction['transaction_description'],
                  'supplier_name' => $transaction['supplier_name'],
                  'supplier_no.' => $transaction['supplier_no.'],
                  'mcc_group' => $transaction['mcc_group'],
                  'mcc_no.' => $transaction['mcc_no.'],
                  'mcc' => $transaction['mcc'],
                  'supplier_reference' => $transaction['supplier_reference'],
                  'supplier_address' => $transaction['supplier_address'],
                  'supplier_city' => $transaction['supplier_city'],
                  'supplier_stateprovince' => $transaction['supplier_stateprovince'],
                  'supplier_postal_code' => $transaction['supplier_postal_code'],
                  'supplier_country' => $transaction['supplier_country'],
                  'industry' => $transaction['industry'],
                  'supplier_chain' => $transaction['supplier_chain'],
                  'supplier_brand' => $transaction['supplier_brand'],
                  'preferred_supplier' => $transaction['preferred_supplier'],
                  'preferred_supplier_list_id' => $transaction['preferred_supplier_list_id'],
                  'submitted_currency' => $transaction['submitted_currency'],
                  'charge_amount' => $transaction['charge_amount'],
                  'credit_amount' => $transaction['credit_amount'],
                  'no._of_charges' => $transaction['no._of_charges'],
                  'no._of_credits' => $transaction['no._of_credits'],
                  'previous_balance' => $transaction['previous_balance'],
                  'closing_balance' => $transaction['closing_balance'],
                  'submitted_currency_amount' => $transaction['submitted_currency_amount'],
                  'jan_net_billed_amount' => $transaction['jan_net_billed_amount'],
                  'feb_net_billed_amount' => $transaction['feb_net_billed_amount'],
                  'mar_net_billed_amount' => $transaction['mar_net_billed_amount'],
                  'apr_net_billed_amount' => $transaction['apr_net_billed_amount'],
                  'may_net_billed_amount' => $transaction['may_net_billed_amount'],
                  'jun_net_billed_amount' => $transaction['jun_net_billed_amount'],
                  'jul_net_billed_amount' => $transaction['jul_net_billed_amount'],
                  'aug_net_billed_amount' => $transaction['aug_net_billed_amount'],
                  'sep_net_billed_amount' => $transaction['sep_net_billed_amount'],
                  'oct_net_billed_amount' => $transaction['oct_net_billed_amount'],
                  'nov_net_billed_amount' => $transaction['nov_net_billed_amount'],
                  'dec_net_billed_amount' => $transaction['dec_net_billed_amount'],
                  'ytd_net_billed_amount' => $transaction['ytd_net_billed_amount'],
                  'ytd_no._of_charges' => $transaction['ytd_no._of_charges'],
                  'report_date' => $transaction['report_date']));
             }
            else{
              $response += array($id
                => array($transaction['transaction_id']
                  => array('product_type' => $transaction['product_type'],
                  'last_name' => $transaction['last_name'],
                  'first_name' => $transaction['first_name'],
                  'middle_name' => $transaction['middle_name'],
                  'prefix_name' => $transaction['prefix_name'],
                  'suffix_name' => $transaction['suffix_name'],
                  'full_name' => $transaction['full_name'],
                  'card_member_acct._no.' => $transaction['card_member_acct._no.'],
                  'guaranteed_status' => $transaction['guaranteed_status'],
                  'employee_id' => $transaction['employee_id'],
                  'control_acct._name' => $transaction['control_acct._name'],
                  'control_acct._no.' => $transaction['control_acct._no.'],
                  'cost_center' => $transaction['cost_center'],
                  'universal_id' => $transaction['universal_id'],
                  'email' => $transaction['email'],
                  'card_member_reference' => $transaction['card_member_reference'],
                  'domestic_or_international' => $transaction['domestic_or_international'],
                  'transaction_limit_amount' => $transaction['transaction_limit_amount'],
                  'monthly_limit_amount' => $transaction['monthly_limit_amount'],
                  'business_process_date' => $transaction['business_process_date'],
                  'charge_date' => $transaction['charge_date'],
                  'roc_id' => $transaction['roc_id'],
                  'transaction_id' => $transaction['transaction_id'],
                  'transaction_description' => $transaction['transaction_description'],
                  'supplier_name' => $transaction['supplier_name'],
                  'supplier_no.' => $transaction['supplier_no.'],
                  'mcc_group' => $transaction['mcc_group'],
                  'mcc_no.' => $transaction['mcc_no.'],
                  'mcc' => $transaction['mcc'],
                  'supplier_reference' => $transaction['supplier_reference'],
                  'supplier_address' => $transaction['supplier_address'],
                  'supplier_city' => $transaction['supplier_city'],
                  'supplier_stateprovince' => $transaction['supplier_stateprovince'],
                  'supplier_postal_code' => $transaction['supplier_postal_code'],
                  'supplier_country' => $transaction['supplier_country'],
                  'industry' => $transaction['industry'],
                  'supplier_chain' => $transaction['supplier_chain'],
                  'supplier_brand' => $transaction['supplier_brand'],
                  'preferred_supplier' => $transaction['preferred_supplier'],
                  'preferred_supplier_list_id' => $transaction['preferred_supplier_list_id'],
                  'submitted_currency' => $transaction['submitted_currency'],
                  'charge_amount' => $transaction['charge_amount'],
                  'credit_amount' => $transaction['credit_amount'],
                  'no._of_charges' => $transaction['no._of_charges'],
                  'no._of_credits' => $transaction['no._of_credits'],
                  'previous_balance' => $transaction['previous_balance'],
                  'closing_balance' => $transaction['closing_balance'],
                  'submitted_currency_amount' => $transaction['submitted_currency_amount'],
                  'jan_net_billed_amount' => $transaction['jan_net_billed_amount'],
                  'feb_net_billed_amount' => $transaction['feb_net_billed_amount'],
                  'mar_net_billed_amount' => $transaction['mar_net_billed_amount'],
                  'apr_net_billed_amount' => $transaction['apr_net_billed_amount'],
                  'may_net_billed_amount' => $transaction['may_net_billed_amount'],
                  'jun_net_billed_amount' => $transaction['jun_net_billed_amount'],
                  'jul_net_billed_amount' => $transaction['jul_net_billed_amount'],
                  'aug_net_billed_amount' => $transaction['aug_net_billed_amount'],
                  'sep_net_billed_amount' => $transaction['sep_net_billed_amount'],
                  'oct_net_billed_amount' => $transaction['oct_net_billed_amount'],
                  'nov_net_billed_amount' => $transaction['nov_net_billed_amount'],
                  'dec_net_billed_amount' => $transaction['dec_net_billed_amount'],
                  'ytd_net_billed_amount' => $transaction['ytd_net_billed_amount'],
                  'ytd_no._of_charges' => $transaction['ytd_no._of_charges'],
                  'report_date' => $transaction['report_date'])));
            }
          }
        }
      }

      // All transactions array keys
      $allKeys  = array_keys($response);

      // Extract all transactions from database
      foreach($allKeys as $amex_id) {
        $rows = $amex_id;
        $transactionsOfResearchers= DB::select('SELECT company_name, total, DATE_FORMAT(date_bought,"%m/%d/%Y") as "date_bought",
          transaction_id, researchers.researcher_id
          FROM transactions NATURAL JOIN transactions_info, researchers
          WHERE researchers.researcher_id = transactions.researcher_id AND amex_account_id = :amex_id
          AND billing_cycle = :bc', ['amex_id' => $amex_id, 'bc' => $report_cycle]);

        $transactionsOfResearchers = json_decode(json_encode($transactionsOfResearchers));
        $rows =$transactionsOfResearchers;
        for ($index = 0; $index < count($transactionsOfResearchers); $index++) {
          $transaction = (array)$transactionsOfResearchers[$index];
          if(empty($researcherTransactions)){
            $researcherTransactions = array($amex_id
              => array($transaction['transaction_id']
                => array('charge_date' => $transaction['date_bought'],
                'charge_amount' => $transaction['total'],
                'supplier_name' => $transaction['company_name'],
                'transaction_id' => $transaction['transaction_id'],
                'researcher_id' => $transaction['researcher_id'])));
          }
          else{
            // card_member_acct._no is in the array
            if (array_key_exists($amex_id, $researcherTransactions)) {
              $tempArray = &$researcherTransactions[$amex_id];
              $tempArray += array($transaction['transaction_id']
                  => array('charge_date' => $transaction['date_bought'],
                  'charge_amount' => $transaction['total'],
                  'supplier_name' => $transaction['company_name'],
                  'transaction_id' => $transaction['transaction_id'],
                  'researcher_id' => $transaction['researcher_id']));
             }
            else{
              $researcherTransactions += array($amex_id
                => array($transaction['transaction_id']
                  => array('charge_date' => $transaction['date_bought'],
                  'charge_amount' => $transaction['total'],
                  'supplier_name' => $transaction['company_name'],
                  'transaction_id' => $transaction['transaction_id'],
                  'researcher_id' => $transaction['researcher_id'])));
            }
          }
        }
      }

      // Check if DB transactions are empty
      if(empty($researcherTransactions)){
        return "Database has no transactions to compare.";
      }
      else{
        // Compare system transactions with AMEX status report transactions
        for($index = 0; $index < count($allKeys); $index ++){
          $excelKey= $allKeys[$index];

          if(array_key_exists($excelKey, $researcherTransactions)){
            foreach($response[$excelKey] as $transFromExcel) {

              foreach($researcherTransactions[$excelKey] as $researchTrans) {

                // Transaction reconciles
                if($transFromExcel['charge_date'] == $researchTrans['charge_date']
                  && $transFromExcel['charge_amount'] == $researchTrans['charge_amount']
                  && stripos($transFromExcel['supplier_name'], $researchTrans['supplier_name']) == "true") {

                  // Set is_reconcilated to 1 in the DB
                  DB::update('UPDATE transactions
                  SET is_reconciliated = 1
                  WHERE transaction_id = :tid', ['tid' => $researchTrans['transaction_id']]);

                  // Eliminate transaction from researcher's submited list
                  unset($researcherTransactions[$excelKey][$researchTrans['transaction_id']]);
                  if(empty($researcherTransactions[$excelKey])){
                    unset($researcherTransactions[$excelKey]);
                  }

                  // Eliminate transaction from amex account status list
                  unset($response[$excelKey][$transFromExcel['transaction_id']]);
                  if(empty($response[$excelKey])){
                    unset($response[$excelKey]);
                  }
                  break;
                }
              }
            }
          }
        }

        // Admin information
        //$response = json_encode($researcherTransactions);

        $admin_name = DB::select('SELECT first_name, last_name
          FROM administrators NATURAL JOIN user_info
          WHERE admin_id = :aid', ['aid' => $admin_id]);

        $admin_name = json_decode(json_encode($admin_name), true);
        $admin_name = $admin_name[0];

        $admin_full_name = $admin_name['first_name'] . ' ' . $admin_name['last_name'];

        // Notification for transactions not reconciled
        foreach($researcherTransactions as $researchTransactions){

          foreach ($researchTransactions as $transaction) {
            // Change transaction status to "Error in reconciliation"
            DB::update("UPDATE transactions
              SET status = 'Error in reconciliation'
              WHERE transaction_id = :tid",
              ['tid' => $transaction['transaction_id']]);

            // Admin timestamp
            $timestamp = DB::insert('INSERT INTO admin_timestamps (action, timestamp, transaction_id, admin_id, name)
              VALUES ("Transaction Error", CURRENT_TIMESTAMP, :tid, :aid, :name)',
              ['tid' => $transaction['transaction_id'], 'aid' => $admin_id, 'name' => $admin_full_name]);

            if ($timestamp){
              $timestamp_id = DB::connection()->getPdo()->lastInsertId();
            }

            $researcher_notification_body = "Your transaction did not reconcile.";

            DB::insert('INSERT INTO researcher_notifications (notification_body, marked_as_read, admin_timestamp_id, researcher_id)
              VALUES (:nb, 0, :atid, :rid)', ['nb' => $researcher_notification_body,
              'atid' => $timestamp_id, 'rid' => $transaction['researcher_id']]);

            //break;
          }
          //break;
        }

        // return $response;

        // Counter for file rows
        $n = 1;

        // Data for Excel File
        $data = [];

        // Excel File first row (Table Headers)
        $data[0] = array(
          'Product Type',
          'Last Name',
          'First Name',
          'Middle Name',
          'Prefix Name',
          'Suffix Name',
          'Full Name',
          'Card Member Acct. No.',
          'Guaranteed Status',
          'Employee Id',
          'Control Acct. Name',
          'Control Acct. No.',
          'Cost Center',
          'Universal Id',
          'Email',
          'Card Member Reference',
          'Domestic or International',
          'Transaction Limit Amount',
          'Monthly Limit Amount',
          'Business Process Date',
          'Charge Date',
          'ROC Id',
          'Transaction Id',
          'Transaction Description',
          'Supplier Name',
          'Supplier No.',
          'MCC Group',
          'MCC No.',
          'MCC',
          'Supplier Reference',
          'Supplier Address',
          'Supplier City',
          'Supplier Stateprovince',
          'Supplier Postal Code',
          'Supplier Country',
          'Industry',
          'Supplier Chain',
          'Supplier Brand',
          'Preferred Supplier',
          'Preferred Supplier List Id',
          'Submitted Currency',
          'Charge Amount',
          'Credit Amount',
          'No. of Charges',
          'No. of Credits',
          'Previous Balance',
          'Closing Balance',
          'Submitted Currency Amount',
          'Jan Net Billed Amount',
          'Feb Net Billed Amount',
          'Mar Net Billed Amount',
          'Apr Net Billed Amount',
          'May Net Billed Amount',
          'Jun Net Billed Amount',
          'Jul Net Billed Amount',
          'Aug Net Billed Amount',
          'Sep Net Billed Amount',
          'Oct Net Billed Amount',
          'Nov Net Billed Amount',
          'Dec Net Billed Amount',
          'YTD Net Billed Amount',
          'YTD No. of Charges',
          'Report Date'
        );

        //$response = json_decode(json_encode($response));
        // Add transaction data to array
        foreach ($response as $researcherTransactions) {
          foreach ($researcherTransactions as $transaction_info) {
            $data[$n] = $transaction_info;
            $n++;
          }
        }

        // Create Excel File
        Excel::create('ReportErrors', function($excel) use($data) {

          // Create Report Errors Sheet
          $excel->sheet('Reports', function($sheet) use($data) {
            // Add data to file
            $sheet->fromArray($data, null, 'A1', true, false);

            // Set font family
            $sheet->setFontFamily('Arial');

            // Set font size
            $sheet->setFontSize(8);

            // Manipulate first row cells
            for($index = 1; $index <= count($data[0]); $index ++){

              // Set first row background to light blue
              $sheet->row(1, function($row) {

                  // call cell manipulation methods
                  $row->setBackground('#009bbb');

                  // Set with font color
                  $row->setFontColor('#ffffff');;

                  // Set font weight to bold
                  $row->setFontWeight('bold');
              });
            }

            // Manipulate all rows
            for($index = 1; $index <= count($data); $index ++) {

              // Set height for a single row
              $sheet->setHeight($index, 25);
            }
          });

        })->save('xls');

        return "Reconciliation Finished";
        // return response()->file('storage/exports/ReportErrors.xls');
      }

  }

  /**
   * [getExcelCycle description]
   * This function convert the report date format from MM/DD/YYYY format to name and year format.
   * Example: May, 2017
   *
   * @return [string] $response     - string response with the converted date.
   *
  */
  public function getExcelCycle($report_date)
  {

    $response = "";

    if(substr($report_date, 0, 2) == "01"){
      $response = "January, " . substr($report_date, 6, 4);
    }

    elseif (substr($report_date, 0, 2) == "02"){
      $response = "February, " . substr($report_date, 6, 4);
    }

    elseif (substr($report_date, 0, 2) == "03"){
      $response = "March, " . substr($report_date, 6, 4);
    }

    elseif (substr($report_date, 0, 2) == "04"){
      $response = "April, " . substr($report_date, 6, 4);
    }

    elseif (substr($report_date, 0, 2) == "05"){
      $response = "May, " . substr($report_date, 6, 4);
    }

    elseif (substr($report_date, 0, 2) == "06"){
      $response = "June, " . substr($report_date, 6, 4);
    }

    elseif (substr($report_date, 0, 2) == "07"){
      $response = "July, " . substr($report_date, 6, 4);
    }

    elseif (substr($report_date, 0, 2) == "08"){
      $response = "August, " . substr($report_date, 6, 4);
    }

    elseif (substr($report_date, 0, 2) == "09"){
      $response = "September, " . substr($report_date, 6, 4);
    }

    elseif (substr($report_date, 0, 2) == "10"){
      $response = "October, " . substr($report_date, 6, 4);
    }

    elseif (substr($report_date, 0, 2) == "11"){
      $response = "November, " . substr($report_date, 6, 4);
    }

    elseif (substr($report_date, 0, 2) == "12"){
      $response = "December, " . substr($report_date, 6, 4);
    }

    return $response;

  }

  /**
   * [getReconciliationResult description]
   * This function returns the path of the generated Excel file with the result
   * of the reconciliation
   *
   * @return [string] $response   - string response with the path of the file.
   *
  */
  public function getReconciliationResult() {

    $response = "../../../storage/exports/ReportErrors.xls";

    return $response;

  }

  public function rolloverLogic() {

          $month = date('m');
          $day = date('d');
          $year =  date('Y');
          $today = $year . '/' . $month . '/' . $day;

          $lowerDayLimit = '18';
          $upperDayLimit = '17';

          $upperBound = $year . '/' . $month . '/' . $upperDayLimit;
          if($month === '01') {
            $lowerBound = ($year - 1) . '/' . ($month - 1) . '/' . $lowerDayLimit;
          }
          else {
            $lowerBound = $year . '/' . ($month - 1) . '/' . $lowerDayLimit;

          }


           $tod = DateTime::createFromFormat('Y/m/d', $today);
           $tod = $tod->getTimestamp();

            $low = DateTime::createFromFormat('Y/m/d', $lowerBound);
            $low = $low->getTimestamp();

            $high = DateTime::createFromFormat('Y/m/d', $upperBound);
            $high = $high->getTimestamp();

            $difference = $high - $tod;

           //if receipt date is on or before the limit date
            if($difference >= 0) {
              //OK... for upper bound now check lowerBound
              $difference = $tod - $low;
              //if receipt date is on or LATER of the start of the cycle
              if($difference >=0) {
                //OK.. MEANS that it is in range
                $monthNum  = $month;
                if($month === 12) {
                  $year = $year + 1;
                }
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $monthName = $dateObj->format('F');
                $newCycle = $monthName . ' ' . $year;

                $monthNum  = $month-1;
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $monthName = $dateObj->format('F');
                $oldCycle = $monthName . ' ' . $year;

                $transactionsToRoll = DB::select('SELECT transaction_id, is_reconciliated
                  FROM transactions
                  WHERE is_reconciliated = 0 AND status != "closed" AND billing_cycle = :oldCycle', ['oldCycle' => $oldCycle]);

                $transactionsToRoll = json_decode(json_encode($transactionsToRoll), true);

                foreach($transactionsToRoll as $transaction) {
                  $transaction_id = $transaction['transaction_id'];
                  DB::update('UPDATE transactions
                  SET status = "Rolled Over", billing_cycle = :newCycle
                  WHERE transaction_id = :tid', ['newCycle' => $newCycle, 'tid' => $transaction_id]);
                }

                  return "B-OK";
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
              $newCycle = $monthName . ' ' . $year;

              $monthNum  = $month;
              $dateObj   = DateTime::createFromFormat('!m', $monthNum);
              $monthName = $dateObj->format('F');
              $oldCycle = $monthName . ' ' . $year;

              $transactionsToRoll = DB::select('SELECT transaction_id, is_reconciliated
                FROM transactions
                WHERE is_reconciliated = 0 AND status != "closed" AND billing_cycle = :oldCycle', ['oldCycle' => $oldCycle]);

              $transactionsToRoll = json_decode(json_encode($transactionsToRoll), true);

              foreach($transactionsToRoll as $transaction) {
                $transaction_id = $transaction['transaction_id'];
                DB::update('UPDATE transactions
                SET status = "Rolled Over", billing_cycle = :newCycle
                WHERE transaction_id = :tid', ['newCycle' => $newCycle, 'tid' => $transaction_id]);
              }


              return "A-OK";
            }

  }
}
