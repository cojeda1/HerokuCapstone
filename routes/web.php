<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
$app->post('/login', function () use ($app) {
    return view('index');
});

$app->get('/', function () use ($app) {
    return "test";
});
$app->group(['middleware' => 'auth'], function () use ($app) {
    $app->group(['middleware'=>'cors'], function($app) {
    $app->group(['prefix' => 'api/v1/accountant'], function($app) {
      // Accountant

      //Accountant's Get requests
      $app->get('/transactionsAssigned/{accountant_id}','AccountantTransactionController@getAssignedTransactions');
      $app->get('/transactionsAssignedInProgress/{accountant_id}','AccountantTransactionController@getAssignedTransactionsInProgress');
      $app->get('/transaction/{accountant_id}/{transaction_id}','AccountantTransactionController@getTransaction');
      $app->get('/transactionItems/{transaction_id}','AccountantTransactionController@getTransactionItemList');
      $app->get('/transactionComments/{transaction_id}','AccountantTransactionController@getTransactionComments');
      $app->get('/transactionsValidated/{accountant_id}','AccountantTransactionController@getValidatedTransactions');
      $app->get('/transactionsUnassigned','AccountantTransactionController@getUnassignedTransactions');
      $app->get('/transactions','AccountantTransactionController@getAllTransactions');
      $app->get('/transactionNotes/{transaction_id}/{accountant_id}','AccountantTransactionController@getTransactionNotes');
      $app->get('/password/{accountant_id}','AccountantTransactionController@getAccountantPassword');
      $app->get('/getAccountantsTimestamps/{transaction_id}', 'AccountantTransactionController@getAccountantTimestamps');
      $app->get('/getResearchersTimestamps/{transaction_id}', 'AccountantTransactionController@getResearcherTimestamps');
      $app->get('/allTransactionTimestamps/{transaction_id}', 'AccountantTransactionController@getAllTransactionTimestamps');
      $app->get('/allNotifications/{accountant_id}', 'AccountantTransactionController@getAllNotifications');
      $app->get('/topNotifications/{accountant_id}', 'AccountantTransactionController@getTop10Notifications');
      //Accountant's GET Request using cycles
      $app->get('/transactionsAssigned/{accountant_id}/{month}/{year}','AccountantCycleController@getAssignedTransactions');
      $app->get('/transactionsValidated/{accountant_id}/{month}/{year}','AccountantCycleController@getValidatedTransactions');
      $app->get('/transactionsUnassigned/{month}/{year}','AccountantCycleController@getUnassignedTransactions');
      $app->get('/transactions/{month}/{year}','AccountantCycleController@getAllTransactions');
      //Accountant's put requests
      $app->put('/assign/{transaction_id}/{accountant_id}','AccountantTransactionController@putAssignTransaction');
      $app->put('/audit/{transaction_id}/{report_status}/{accountant_id}','AccountantTransactionController@putAuditTransaction');
      $app->put('/editComment/{comment_id}','AccountantTransactionController@putEditComment');
      $app->put('/editNote/{note_id}','AccountantTransactionController@putEditNote');
      $app->put('/editResearchAccountNumber/{item_id}/{item_code}', 'AccountantTransactionController@putEditResearchAccount');
      //Accountant's posts requests
      $app->post('/comment/{accountant_id}','AccountantTransactionController@postCommentTransaction');
      $app->post('/note/{accountant_id}','AccountantTransactionController@postNoteTransaction');
      $app->post('/markNotificationAsRead/{notification_id}', 'AccountantTransactionController@postMarkNotificationAsRead');
      $app->post('deleteFile/{transaction_id}/{tinfo_id}', 'AccountantTransactionController@deleteFile');
      //Accountant's delete requests
      $app->delete('/deleteComment/{comment_id}','AccountantTransactionController@deleteComment');
      $app->delete('/deleteNote/{note_id}','AccountantTransactionController@deleteNote');
    });


      $app->group(['prefix' => 'api/v1/researcher'], function($app)
      {
        $app->get('/allResearchAccountsPI/{researcher_id}', 'ResearcherController@getAllResearchAccounts_PI');
        $app->get('/allResearchAccountsCOPI/{researcher_id}', 'ResearcherController@getAllResearchAccounts_COPI');
        $app->get('/individualResearcherInfo/{researcher_id}', 'ResearcherController@getResearcherInfo');
        $app->get('/allTransactions/{researcher_id}', 'ResearcherController@getAllTransactions');
        $app->get('/individualTransaction/{researcher_id}/{transaction_id}', 'ResearcherController@getIndividualTransaction');
        $app->get('/allResearchers/{researcher_id}','ResearcherController@getAllResearchers');
        $app->get('/individualResearchAccount/{ra_id}/{researcher_id}', 'ResearcherController@getResearchAccount');
        $app->get('/getImages/{transaction_id}', 'ResearcherController@getImages');
        $app->get('/getAccountantsTimestamps/{transaction_id}', 'ResearcherController@getAccountantTimestamps');
        $app->get('/getResearchersTimestamps/{transaction_id}', 'ResearcherController@getResearcherTimestamps');
        $app->get('/allTransactionTimestamps/{transaction_id}', 'ResearcherController@getAllTransactionTimestamps');
        $app->get('/allNotifications/{researcher_id}', 'ResearcherController@getAllNotifications');
        $app->get('/topNotifications/{researcher_id}', 'ResearcherController@getTop10Notifications');
        $app->get('/getAllTransactionToApprove/{researcher_id}', 'ResearcherController@getAllTransactionToApprove');
        $app->get('/getAllResearchAccounts/{researcher_id}', 'ResearcherController@getAllResearchAccounts');
        //
        $app->get('/allTransactions/{researcher_id}/{month}/{year}', 'ResearcherCycleController@getAllTransactions');
        $app->get('/getAllTransactionToApprove/{researcher_id}/{month}/{year}', 'ResearcherCycleController@getAllTransactionToApprove');
        $app->get('/transactionsNotReconciliated/{researcher_id}','ResearcherCycleController@getAllTransactionsNotReconciliated');
        $app->get('/transactionsNotReconciliatedCycle/{researcher_id}/{month}/{year}','ResearcherCycleController@getTransactionsNotReconciliatedCycle');
        //

        $app->post('/createNewResearchAccount/{researcher_id}','ResearcherController@createNewResearchAccount');
        $app->post('/createNewTransaction/{researcher_id}','ResearcherController@createNewTransaction');
        $app->post('/editItem/{transaction_id}', 'ResearcherController@editItem');
        $app->post('/editTransactionInfo/{transaction_id}', 'ResearcherController@editTransactionInfo');
        $app->post('/upload/{transaction_id}','ResearcherController@uploadImage');
        $app->post('/editResearcher/{researcher_id}', 'ResearcherController@editResearcherProfile');
        $app->post('/editResearcherAccount/{ra_id}', 'ResearcherController@editResearchAccount');
        $app->post('/markNotificationAsRead/{notification_id}', 'ResearcherController@postMarkNotificationAsRead');
        $app->post('/deleteFile/{transaction_id}/{tinfo_id}', 'ResearcherController@deleteFile');

        $app->put('/auditItem/{pi_allowed_item}/{transaction_id}/{item_id}', 'ResearcherController@auditItem');

        $app->delete('/deleteTrans/{transaction_id}', 'ResearcherController@deleteTransaction');
        $app->delete('/deleteItem/{item_id}', 'ResearcherController@deleteItem');
      });

      // Administrator
      $app->group(['prefix' => 'api/v1/administrator'], function($app) {
        //Administrator's get
        $app->get('/transactionsUnassigned','AdministratorTransactionController@getUnassignedTransactions');
        $app->get('/transactionsAssigned','AdministratorTransactionController@getAssignedTransactions');
        $app->get('/transactionsNotReconciliated','AdministratorCycleController@getAllTransactionsNotReconciliated');
        $app->get('/transactionsNotReconciliatedCycle/{month}/{year}','AdministratorCycleController@getTransactionsNotReconciliatedCycle');
        //$app->get('/allAccountants','AdministratorTransactionController@allAccountants');
        $app->get('/individualResearcher/{researcher_id}','AdministratorTransactionController@getIndividualResearcher' );
        $app->get('/allAccountants','AdministratorTempController@getAllAccountants');
        $app->get('/allResearchers','AdministratorTransactionController@getAllResearchers');
        $app->get('/getAccountant/{accountant_id}','AdministratorTempController@getAccountant');
        $app->get('/getIndividualTransaction/{researcher_id}/{transaction_id}','AdministratorTempController@getIndividualTransaction');
        $app->get('/allTransactions', 'AdministratorTransactionController@getAllTransactions');
        $app->get('/allCreditCards', 'AdministratorTransactionController@getAllCreditCards');
        $app->get('/getActiveCreditCard/{researcher_id}', 'AdministratorTransactionController@getActiveCreditCard');

        $app->get('/getIndividualResearcher/{researcher_id}', 'AdministratorTransactionController@getIndividualResearcher');
        $app->get('/researchersAssignedToAccountant/{accountant_id}','AdministratorTempController@getResearchersAssignedToAccountant');
        //GETS using cycles
        $app->get('/transactionsUnassigned/{month}/{year}','AdministratorCycleController@getUnassignedTransactions');
        $app->get('/transactionsAssigned/{month}/{year}','AdministratorCycleController@getAssignedTransactions');
        $app->get('/allTransactions/{month}/{year}', 'AdministratorCycleController@getAllTransactions');
        $app->get('/individualAdministrator/{admin_id}', 'AdministratorTransactionController@getIndividualAdministrator');
        $app->get('/allAdministrators', 'AdministratorTransactionController@getAllAdministrators');


        //Administrator's post
        $app->post('/assignTransaction','AdministratorTempController@assignTransaction');
        $app->post('/createResearcher', 'AdministratorTempController@postCreateResearcher');
        $app->post('/createAccountant', 'AdministratorTempController@postCreateAccountant');
        $app->post('/createAdministrator', 'AdministratorTempController@postCreateAdministrator');
        $app->post('/createNewCreditCard/{researcher_id}', 'AdministratorTransactionController@addNewCreditCard');
        $app->post('/editCreditCard/{cc_id}', 'AdministratorTransactionController@editCreditCard');
        $app->post('/uploadExcel','AdministratorTempController@postUploadExcelFile');
        //Administrator's PUTS ** not working for now **
        $app->put('/editAccountant/{accountant_id}', 'AdministratorTempController@putEditAccountant');
        $app->put('/editResearcher/{researcher_id}', 'AdministratorTempController@putEditResearcher');
        $app->put('/assignResearchersToAccountant/{accountant_id}', 'AdministratorTempController@putAssignResearchersToAccountant');
        $app->put('/disableAdmin/{admin_id}', 'AdministratorTransactionController@disableAdmin');
        $app->get('/assignedTrans', 'AdministratorTempController@getAssignedTransactions');
        //Administrator's DELETES
        $app->delete('/deleteTrans/{transaction_id}', 'AdministratorTempController@deleteTransaction');
        $app->delete('/deleteAdmin/{admin_id}', 'AdministratorTempController@deleteAdministrator');
      });

        $app->get('/please','ReconciliationController@reconcileTransactions');
        $app->get('/rollover', 'ReconciliationController@rolloverLogic');
        $app->get('/reconciliationResult','ReconciliationController@getReconciliationResult');
        $app->post('/restore/{email}', 'PasswordRecoveryController@restorePassword');
      });

    $app->group(['prefix' => 'api/v1/password'], function($app) {
      $app->put('/restore', 'PasswordRecoveryController@restorePassword');
    });

});

$app->post('/testHash','TransactionController@passwordCheck');


$app->group(['prefix' => 'api/v1/file'], function($app) {
  $app->post('/file', 'FileController@saveFile');
  $app->get('list', 'FileController@getFileList');
  $app->get('view/{filename}', 'FileController@viewFile');
  $app->delete('delete', 'FileController@deleteFile');

});
