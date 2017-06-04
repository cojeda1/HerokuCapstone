// ***************************************************************************************************
//                             App module with dependencies
// ***************************************************************************************************
var app = angular.module("myApp.investigator", ['ngRoute',
'ngAria',
'ngAnimate',
'angularUtils.directives.dirPagination',
'ngMaterial',
'ui.router',
'angularFileUpload',
'ngFileUpload'
]);


// ***************************************************************************************************
//                             App Configuration for states and routing
// ***************************************************************************************************
app.config(function($stateProvider, $urlRouterProvider){
  $stateProvider.state('addAcc', {
      url: '/addAccount',
      params: {'r_id':0},
      templateUrl:'invView/addAcc.html',                  //Add An Account
      controller: 'createAccount'
  });

  $stateProvider.state('invHome',{
    url:'/invHome',
    params: {'r_id':0},
    templateUrl: 'invView/invHome.php',                  //View Home
    controller:'homeCtrl'
  });

 $stateProvider.state('viewreportInv', {
   url:'/viewReport',
   params: {'t_id':0,
            'r_id':0},                            //View a Report
   templateUrl:'invView/viewreport.php',
   controller:'reportCtrl'
 });

 $stateProvider.state('viewTransactions', {
   url:'/viewTransactions',
   params: {'r_id':0},
   templateUrl:'invView/transRep.php',                    //View All Transactions
   controller:'tableCtrl'
 });

 $stateProvider.state('createreport', {
   url:'/createReport',
   params: {'r_id':0},
   templateUrl:'invView/createRep.php',                   //Create a Report
   controller:'createCtrl'
 });

 $stateProvider.state('viewaccount', {
   url:'/viewaccount',
   params: {'a_id': 0,                            //View An Account and Edit
            'p_id': 0,  //disable edit
            'r_id': 0},
   templateUrl:'invView/viewAccount.php',
   controller:'accountCtrl'
 });

 $stateProvider.state('viewprofile', {
   url:'/viewprofile',
   params: {'r_id':0},
   templateUrl:'invView/profile.php',                     //View profile and Edit
   controller:'profileCtrl'
 });
 $stateProvider.state('editreport', {
   url:'/editreport',
   params: {'t_id':0,
            'r_id':0},
   templateUrl:'invView/editRep.php',                     //View profile and Edit
   controller:'reportCtrl'
 });

 $stateProvider.state('cotransactions', {
   url:'/cotransactions',
   params: {'r_id':0},
   templateUrl:'invView/coTransaction.php',                     //View profile and Edit
   controller:'coCtrl'
 });

 $stateProvider.state('notifications', {
   url:'/notifications',
   params: {'r_id':0},
   templateUrl:'invView/allNotifs.php',                     //View profile and Edit
   controller:'notificationCtrl'
 });

 $stateProvider.state('audit', {
   url:'/audit',
   params: {'r_id':0,
            't_id':0,
            'ra_id': 0},
   templateUrl:'invView/coAudit.php',                     //View profile and Edit
   controller:'auditCtrl'
 });

 $stateProvider.state('reconciled', {
   url:'/reconciled',
   params: {'r_id':0},
   templateUrl:'invView/notReconciled.php',                     //View profile and Edit
   controller:'recCtrl'
 });
});
// ***************************************************************************************************
//                             Home Controller: invHome.html
// ***************************************************************************************************

app.controller('homeCtrl', ['$scope', '$http', '$state', '$stateParams', '$mdDialog', function($scope, $http, $state, $stateParams, $mdDialog){
                                          //Home Controller Routing
  $scope.viewProfile = function () {
    $state.go("viewprofile", {'r_id':sessionStorage.r_id});
  }

  $scope.createRep = function () {
    $state.go("createreport", {'r_id':sessionStorage.r_id});
  }

  $scope.viewTransactions = function() {
    $state.go('viewTransactions', {'r_id':sessionStorage.r_id})
  }

  $scope.addAccount = function(accountID) {
    $state.go('addAcc', {'r_id':sessionStorage.r_id});
  }

  $scope.viewHome = function () {
    $state.go('invHome', {'r_id':sessionStorage.r_id});
  }

  $scope.viewAccount = function (a_id) {
    $state.go('viewaccount', {'a_id':a_id,'p_id':$scope.p_id, 'r_id': sessionStorage.r_id})
  }

  $scope.viewCo = function() {
    $state.go('cotransactions', {'r_id':sessionStorage.r_id});
  }

  $scope.reconcile = function(){
    $state.go('reconciled', {'r_id':sessionStorage.r_id});
  }



                                            //Home Controller Variables
  $scope.user_info = [];
  $scope.r_account_info = [];
  $scope.copi_account_info = [];
  $scope.table = true;
  $scope.p_id = 1;
  sessionStorage.r_id = $scope.rid;
  $scope.typeUser = "Principal Investigator";

var token = localStorage.getItem("token");
var base64Url = token.split('.')[1];
var base64 = base64Url.replace('-', '+');
var base64 = base64Url.replace('_', '/');
var decoded = JSON.parse(window.atob(base64));
$scope.rid = decoded.rid;
sessionStorage.r_id = decoded.rid;
$http.defaults.headers.common['Authorization'] = 'Bearer ' + token;


                                            //Home Controller Functions
  $scope.changeValue = function(pid) {
    $scope.table = !$scope.table;           //Allows to switch between PI and COPI accounts
    if(pid===1){
      $scope.p_id = 1;
      $scope.table = true;
      $scope.typeUser = "Principal Investigator"
    }
    else{
      $scope.p_id = 2;
      $scope.table = false;
      $scope.typeUser = "Co-Investigator"
    }
    console.log($scope.p_id);
  }

  $scope.notifications = function() {
    $mdDialog.show({
      scope: $scope,
      preserveScope: true,
      controller: 'notifCtrl',
      templateUrl:'invView/notification.html',
      parent: angular.element(document.body),
      clickOutsideToClose: true
    })
  }


                                                                    //Home Controlleer GETS
  //Principal Investigator Research Accounts
  $http.get('http://localhost:8000/api/v1/researcher/allResearchAccountsPI/'+sessionStorage.r_id).then(function mySuccess(response) {
    $scope.r_account_info = response.data;
    console.log(response.data);
    }, function myFailure(response) {
      $scope.r_account_info = response.statusText;
    });

  //Researcher's info
  $http.get('http://localhost:8000/api/v1/researcher/individualResearcherInfo/'+sessionStorage.r_id).then(function mySuccess(response) {
    $scope.user_info = response.data;
    console.log(response.data);
    }, function myFailure(response) {
      $scope.user_info = response.statusText;
    });

  //Co principal investigator's Research Accounts
  $http.get('http://localhost:8000/api/v1/researcher/allResearchAccountsCOPI/'+sessionStorage.r_id).then(function mySuccess(response) {
    $scope.copi_account_info = response.data;
    console.log(response.data);
    }, function myFailure(response) {
      $scope.copi_account_info = response.statusText;
    });

}]);
//End of Home Controller


// ***************************************************************************************************
//                             Account Controller: viewAccount.php
// ***************************************************************************************************

app.controller('accountCtrl', ['$scope', '$http', '$state', '$stateParams', '$mdDialog', function($scope, $http, $state, $stateParams, $mdDialog){
  if($stateParams.r_id!==0){
    sessionStorage.r_id = $stateParams.r_id;
    sessionStorage.a_id = $stateParams.a_id;
    sessionStorage.p_id = $stateParams.p_id;
  }

  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  $scope.rid = decoded.rid;
  sessionStorage.r_id = decoded.rid;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;

                                                    //Account Controller Routing
  $scope.viewProfile = function () {
    $state.go("viewprofile", {'r_id':sessionStorage.r_id});
  }

  $scope.createRep = function () {
    $state.go("createreport", {'r_id':sessionStorage.r_id});
  }

  $scope.viewTransactions = function() {
    $state.go('viewTransactions', {'r_id':sessionStorage.r_id})
  }

  $scope.viewHome = function () {
    $state.go('invHome', {'r_id':sessionStorage.r_id});
  }

  $scope.viewAccount = function (a_id) {
    $state.go('viewaccount', {'a_id':sessionStorage.a_id,'p_id':sessionStorage.p_id, 'r_id':sessionStorage.r_id})
  }

  $scope.viewCo = function() {
    $state.go('cotransactions', {'r_id':sessionStorage.r_id});
  }

  $scope.reconcile = function(){
    $state.go('reconciled', {'r_id':sessionStorage.r_id});
  }

                                                //Account Controller Variables
  $scope.account_info = [];
  $scope.alert = 0;
  $scope.copi = [];
  $scope.researchers =[];
  // var rid = 1;
  // $scope.a_id = $stateParams.a_id;
  $scope.p_id = sessionStorage.p_id;
  $scope.copi_id = [];

                                                //Account Controller Functions
  $scope.notifications = function() {
    $mdDialog.show({
      scope: $scope,
      preserveScope: true,
      controller: 'notifCtrl',
      templateUrl:'invView/notification.html',
      parent: angular.element(document.body),
      clickOutsideToClose: true
    })
  }

  $scope.addresearcher = function(co_id){
    if($scope.copi.indexOf(co_id) === -1){
      $scope.copi.push(co_id);
    }
    console.log($scope.copi.indexOf(co_id));
  }

  $scope.deleteresearcher = function(co_id){
    var index = $scope.copi.indexOf(co_id);     //Delete researcher id from list
    $scope.copi.splice(index, 1);
  }

  $scope.answer = function(decision){
    if(decision===1){
      return "I want to be notified.";          //Determine PI decision to be notified
    }
    else{
      return "I do not want to be notified.";
    }
  }

  $scope.decision = function(value){
    $scope.alert = parseInt(value);             //New Decision in edit
    console.log($scope.alert);
  }

  $scope.disable = function(){
    console.log($scope.p_id)                    //Disable edit button for COPIs
    if(parseInt($scope.p_id)===1){
      return false;
    }
    else{
      return true;
    }
  }

  $scope.show = function(researcher){
    if($scope.copi.indexOf(researcher)!==-1){
      return false;                             //Toggle between select and deselect button
    }
    else{
      return true;
    }
  };

  $scope.editInfo = function(ev) {
    $mdDialog.show({
      contentElement:'#myContainer',
      parent: angular.element(document.body),
      targetEvent: ev,
      clickOutsideToClose: true
    })
  }

  $scope.addInv = function(ev) {
    $mdDialog.show({
      contentElement:'#myContainer1',
      parent: angular.element(document.body),
      targetEvent: ev,
      clickOutsideToClose: true
    })
  }

  $scope.hide = function() {
    $mdDialog.hide();
  }

  $scope.empty = function(){
    if($scope.copi.length > 0){
      return true;
    }
    else{
      return false;
    }
  }

                                                                    //Account Controller GETs
  //Researcher Info
  $http.get('http://localhost:8000/api/v1/researcher/individualResearchAccount/'+sessionStorage.a_id+'/'+sessionStorage.r_id).then(function mySuccess(response) {
      $scope.account_info = response.data;
      for(i = 0; i < $scope.account_info.list_of_copi.length; i++){
        $scope.copi.push($scope.account_info.list_of_copi[i]);
      }
      $scope.alert = $scope.account_info.research_account_info[0].be_notified;
      console.log($scope.copi);
    }, function myFailure(response) {
      $scope.account_info = response.statusText;
    });

    //All Researchers
    $http.get('http://localhost:8000/api/v1/researcher/allResearchers/'+sessionStorage.r_id).then(function mySuccess(response) {
        $scope.researchers = response.data;
        console.log($scope.researchers);
      }, function myFailure(response) {
        $scope.researchers = response.statusText;
      });


                                                              //Account Controller POSTs
  //Edit Account Information
  $scope.edit = function() {
    for(i = 0; i < $scope.copi.length; i++){
      $scope.copi_id.push($scope.copi[i].researcher_id);
    }

    $http({
      method: "POST",
      url:"http://localhost:8000/api/v1/researcher/editResearcherAccount/"+sessionStorage.a_id,
      headers: {'Content-Type' : 'application/json'},
      data:{
        research_nickname: document.getElementById('nickname').value,
        ufis_account_number: document.getElementById('ufis').value,
        frs_account_number: document.getElementById('frs').value,
        unofficial_budget: parseFloat(document.getElementById('budget').value),
        budget_remaining: parseFloat(document.getElementById('remaining').value),
        list_of_copi: $scope.copi_id,
        is_notified: parseInt($scope.alert),
        researcher_id: sessionStorage.r_id
      }
    }).then(function mySuccess(response){
        $scope.copi.length = 0;
        console.log(response.data);
        $mdDialog.hide();
        $http.get('http://localhost:8000/api/v1/researcher/individualResearchAccount/'+sessionStorage.a_id+'/'+sessionStorage.r_id).then(function mySuccess(response) {
            $scope.account_info = response.data;
            for(i = 0; i < $scope.account_info.list_of_copi.length; i++){
              $scope.copi.push($scope.account_info.list_of_copi[i]);
            }
            $scope.alert = $scope.account_info.research_account_info[0].be_notified;
            console.log($scope.account_info);
          }, function myFailure(response) {
            $scope.account_info = response.statusText;
          });
    }), function myError(response){
        console.log(response.data);
    };
  }

}]);
//End of Account Controller




// ***************************************************************************************************
//                             Report Controller: viewReport.php
// ***************************************************************************************************

app.controller('reportCtrl', ['$scope', '$http', '$state', '$stateParams', '$mdDialog', 'Upload', function ($scope, $http, $state, $stateParams, $mdDialog, Upload) {
  if($stateParams.r_id!==0){
    sessionStorage.r_id = $stateParams.r_id;
    sessionStorage.t_id = $stateParams.t_id;
  }

  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  $scope.rid = decoded.rid;
  sessionStorage.r_id = decoded.rid;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;

                                                  //Report Controller Routing
  $scope.viewProfile = function () {
    $state.go("viewprofile", {'r_id':sessionStorage.r_id});
  }

  $scope.createRep = function () {
    $state.go("createreport", {'r_id':sessionStorage.r_id});
  }

  $scope.viewTransactions = function() {
    $state.go('viewTransactions', {'r_id':sessionStorage.r_id})
  }

  $scope.viewHome = function () {
    $state.go('invHome', {'r_id':sessionStorage.r_id});
  }

  $scope.edit = function(){
    $state.go('editreport', {'t_id':sessionStorage.t_id, 'r_id':sessionStorage.r_id})
  }

  $scope.viewCo = function() {
    $state.go('cotransactions', {'r_id':sessionStorage.r_id});
  }

  $scope.reconcile = function(){
    $state.go('reconciled', {'r_id':sessionStorage.r_id});
  }

                                                //View Report Variables
  $scope.t_info = [];
  $scope.accounts = [];
  $scope.accountsCopi = [];
  $scope.accountID = -1;
  $scope.account_info = [];
  $scope.picture = [];
  //$scope.t_id = $stateParams.t_id;

                                                //View Report Functions
  $scope.items = [];

  $scope.notifications = function() {
    $mdDialog.show({
      scope: $scope,
      preserveScope: true,
      controller: 'notifCtrl',
      templateUrl:'invView/notification.html',
      parent: angular.element(document.body),
      clickOutsideToClose: true
    })
  }

  $scope.itemDialog = function(item) {
    $scope.items = item;
    console.log($scope.items);
    $mdDialog.show({
      contentElement:'#myContainer',
      parent: angular.element(document.body),
      clickOutsideToClose: true
    })
  };

  $scope.hide = function() {
    $mdDialog.hide();
  }

  $scope.show = function(a_id){
    if($scope.accountID === a_id){  //Toggle between select and deselect button for Accounts
      return false;
    }
    else{
      return true;
    }
  };

  $scope.addID = function(a_id){
    $scope.accountID = a_id;           //Add Account ID to list
    console.log($scope.accountID);
  }

  // $scope.deleteID = function(a_id){
  //   var index = $scope.accountID.indexOf(a_id); //Delete Account ID from list
  //   $scope.accountID.splice(index, 1);
  // }

  $scope.createItem = function() {
    $scope.account_info.push({
      item_price: parseFloat(document.getElementById('itemPrice').value),
      item_name: document.getElementById('itemName').value,                  //Add Item to List
      quantity: parseInt(document.getElementById('itemQuantity').value),
      list_of_accounts: $scope.accountID,
      item_id: $scope.items.item_id
    });
    $scope.accountID = [];
    $mdDialog.hide();
    console.log($scope.account_info);
  };

                                                //View Report GETs
  //Get individual transaction info
  $http.get('http://localhost:8000/api/v1/researcher/individualTransaction/'+sessionStorage.r_id+'/'+sessionStorage.t_id).then(function mySuccess(response) {
    $scope.t_info = response.data;
    console.log($scope.t_info);
    }, function myFailure(response) {
      $scope.t_info = response.statusText;
    });

  $scope.reload = function() {
    $http.get('http://localhost:8000/api/v1/researcher/individualTransaction/'+sessionStorage.r_id+'/'+sessionStorage.t_id).then(function mySuccess(response) {
      $scope.t_info.items = response.data.items;
      console.log($scope.t_info);
      }, function myFailure(response) {
        $scope.t_info = response.statusText;
      });
    }

  $scope.path = function(path){
    var substring = ".pdf";
    console.log(path);
    if(path.indexOf(substring) !== -1){
      return true;
    }
    else {
      return false;
    }
  }

  $scope.pdf = function(file){
    window.open(file);
  }

  $scope.pdf1 = function(file) {
    console.log(file);
    var pdf_url = URL.createObjectURL(file);
    window.open(pdf_url);
  }


  //Get all research accounts of user as PI
  $http.get('http://localhost:8000/api/v1/researcher/allResearchAccountsPI/'+sessionStorage.r_id).then(function mySuccess(response) {
      $scope.accounts = response.data;
    console.log(response.data);
    }, function myFailure(response) {
      $scope.accounts = response.statusText;
    });

  //Get all research accounts of user as COPI
  $http.get('http://localhost:8000/api/v1/researcher/allResearchAccountsCOPI/'+sessionStorage.r_id).then(function mySuccess(response) {
      $scope.accountsCOPI = response.data;
    console.log(response.data);
    }, function myFailure(response) {
      $scope.accounts = response.statusText;
    });

  $scope.item = function(){
    console.log(document.getElementById('itemName').value);
    $http({
      method: "POST",
      url:"http://localhost:8000/api/v1/researcher/editItem/"+sessionStorage.t_id,
      headers: {'Content-Type' : 'application/json'},
      data:{
        items: {
          item_price: parseFloat(document.getElementById('itemPrice').value),
          item_name: document.getElementById('itemName').value,                  //Add Item to List
          quantity: parseInt(document.getElementById('itemQuantity').value),
          ra_id: $scope.accountID,
          item_id: $scope.items.item_id
        }
      }
    }).then(function mySuccess(response){
        $scope.reload();
        console.log(response.data);
    }), function myError(response){
        console.log(response.data);
    };
  };

  $scope.change = function(){
    console.log($scope.t_info.transaction_information[0].date_bought);
    $http({
        method: "POST",
        url:"http://localhost:8000/api/v1/researcher/editTransactionInfo/"+sessionStorage.t_id,
        headers: {'Content-Type' : 'application/json'},
        data:{
          transaction_number: document.getElementById('tNumber').value,
          company_name: document.getElementById('company').value,
          date_bought: $scope.t_info.transaction_information[0].date_bought,
          description_justification: document.getElementById('justification').value,
          total: document.getElementById('total').value
        }
      }).then(function mySuccess(response){
          $state.go('viewTransactions', {'r_id':sessionStorage.r_id});
          console.log(response.data);
      }), function myError(response){
          console.log(response.data);
      };
    };


    $scope.deleteTrans = function() {
      $http({
          method: "DELETE",
          url:"http://localhost:8000/api/v1/researcher/deleteTrans/"+sessionStorage.t_id,
          headers: {'Content-Type' : 'application/json'},
        }).then(function mySuccess(response){
            $state.go('viewTransactions', {'r_id':sessionStorage.r_id});
            console.log(response.data);
        }), function myError(response){
            console.log(response.data);
        };
    }

    $scope.deleteItem = function(id) {
      $http({
          method: "DELETE",
          url:"http://localhost:8000/api/v1/researcher/deleteItem/"+id,
          headers: {'Content-Type' : 'application/json'}
        }).then(function mySuccess(response){
            $scope.reload();
            console.log(response.data);
        }), function myError(response){
            console.log(response.data);
        };
    }

  $scope.newPicture = function(){
    Upload.upload({
        url: 'http://localhost:8000/api/v1/researcher/upload/'+sessionStorage.t_id,
        method: 'POST',
        file: $scope.picture.new,
    }).then(function (resp) {
      $http.get('http://localhost:8000/api/v1/researcher/individualTransaction/'+sessionStorage.r_id+'/'+sessionStorage.t_id).then(function mySuccess(response) {
        $scope.t_info.images = response.data.images;
        console.log($scope.t_info);
        }, function myFailure(response) {
          $scope.t_info = response.statusText;
        });
        $scope.picture.new = [];
    }, function (resp) {
        console.log('Error status: ' + resp.status);
        console.log($scope.picture.new);
    }, function (evt) {
        var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
    });
  }

  $scope.deleteFile = function(id) {
    $http({
        method: "POST",
        url:"http://localhost:8000/api/v1/researcher/deleteFile/"+sessionStorage.t_id+"/"+$scope.t_info.transaction_information[0].tinfo_id,
        headers: {'Content-Type' : 'application/json'},
        data: {
          image_id: id
        }
      }).then(function mySuccess(response){
        $http.get('http://localhost:8000/api/v1/researcher/individualTransaction/'+sessionStorage.r_id+'/'+sessionStorage.t_id).then(function mySuccess(response) {
          $scope.t_info.images = response.data.images;
          console.log($scope.t_info);
          }, function myFailure(response) {
            $scope.t_info = response.statusText;
          });
          console.log(response.data);
      }), function myError(response){
          console.log(response.data);
      };
  }

}]);
//End of View Report Controller



// ***************************************************************************************************
//                             Transaction(Table) Controller: transRep.php
// ***************************************************************************************************

app.controller('tableCtrl', ['$scope', '$http', '$state', '$stateParams', '$mdDialog', function ($scope, $http, $state, $stateParams, $mdDialog) {
  if($stateParams.r_id!==0){
    sessionStorage.r_id = $stateParams.r_id;
  }

  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  $scope.rid = decoded.rid;
  sessionStorage.r_id = decoded.rid;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;

                            //Transaction Controller Routing
  $scope.viewProfile = function () {$state.go("viewprofile", {'r_id':sessionStorage.r_id});}
  $scope.createRep = function () {$state.go("createreport", {'r_id':sessionStorage.r_id});}
  $scope.viewTransactions = function() {$state.go('viewTransactions', {'r_id':sessionStorage.r_id})}
  $scope.viewReport = function(t_id) {$state.go('viewreportInv', {'t_id':t_id, 'r_id':sessionStorage.r_id})}
  $scope.viewHome = function () {$state.go('invHome', {'r_id':sessionStorage.r_id});}
  $scope.viewCo = function() {$state.go('cotransactions', {'r_id':sessionStorage.r_id});}

  $scope.reconcile = function(){
    $state.go('reconciled', {'r_id':sessionStorage.r_id});
  }

                                                    //Transaction Controller Variables
  var rid = 1;
  $scope.transactions =[];

  $scope.notifications = function() {
    $mdDialog.show({
      scope: $scope,
      preserveScope: true,
      controller: 'notifCtrl',
      templateUrl:'invView/notification.html',
      parent: angular.element(document.body),
      clickOutsideToClose: true
    })
  };

  //mddatepicker configuration
  $scope.months = ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sep','Oct', 'Nov', 'Dec'];
  $scope.years = ['2017', '2018','2019','2020','2021', '2022', '2023', '2024','2025', '2026', '2027', '2028','2029', '2030'];
  $scope.myDate = new Date();
  $scope.month = $scope.months[$scope.myDate.getUTCMonth()];
  $scope.year = $scope.myDate.getUTCFullYear();
  $scope.formattedDate = $scope.months[$scope.myDate.getMonth()]+ "-"+ $scope.myDate.getUTCFullYear();
//end of md Datepicker configuration
//functions
$scope.viewCycle = function()
{
  var year = $scope.year;
  var month = $scope.month;
  $scope.formattedDate = month+ "-"+ year;
  console.log(year + " "+ month);
  console.log('here');
  $http({
    method: 'GET',
    url: 'http://localhost:8000/api/v1/researcher/allTransactions/'+rid+'/'+month+'/'+year
  }).then(function successCallback(response) {
    $scope.transactions = response.data;
    for(var i =0; i<$scope.transactions.length; i++){
      $scope.transactions[i].first_name = $scope.transactions[i].first_name+" "+$scope.transactions[i].last_name;
    }
    console.log(response.data);
    }, function errorCallback(response) {
      // called asynchronously if an error occurs
      // or server returns response with an error status.
    });

}
                                                    //Transaction Controller GETs
  //Get all transaction info to populate table
  $http.get('http://localhost:8000/api/v1/researcher/allTransactions/'+sessionStorage.r_id).then(function mySuccess(response) {
    $scope.transactions = response.data;
    console.log(response.data);
    }, function myFailure(response) {
      $scope.transactions = response.statusText;
    });

}]);
//End of Transaction Controller


// ***************************************************************************************************
//                             Create Transaction Controller: createRep.php
// ***************************************************************************************************

app.controller('createCtrl', ['$scope', '$http', '$state', 'Upload', '$stateParams', '$mdDialog','$filter', function ($scope, $http, $state, Upload, $stateParams, $mdDialog, $filter) {
  if($stateParams.r_id!==0){
    sessionStorage.r_id = $stateParams.r_id;
  }

  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  $scope.rid = decoded.rid;
  sessionStorage.r_id = decoded.rid;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;

                                                  //Create Controller Routing
  $scope.viewProfile = function () {
    $state.go("viewprofile", {'r_id':sessionStorage.r_id});
  }

  $scope.createRep = function () {
    $state.go("createreport", {'r_id':sessionStorage.r_id});
  }

  $scope.viewTransactions = function() {
    $state.go('viewTransactions', {'r_id':sessionStorage.r_id})
  }

  $scope.viewReport = function() {
    $state.go('viewreportInv', {'r_id':sessionStorage.r_id})
  }

  $scope.viewHome = function () {
    $state.go('invHome', {'r_id':sessionStorage.r_id});
  }

  $scope.viewCo = function() {
    $state.go('cotransactions', {'r_id':sessionStorage.r_id});
  }

  $scope.reconcile = function(){
    $state.go('reconciled', {'r_id':sessionStorage.r_id});
  }

                                              //Create Controller Variables
  $scope.accounts = [];
  $scope.accountsCOPI = [];
  $scope.model = '';
  $scope.account_info = [];
  $scope.accountID = [];
  $scope.picture = [];
  $scope.picture.files = [];

  $scope.maxDate = new Date();
  var itemCount = 0;
                                              //Create Controller Functions


  document.querySelector("#number").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
  });

  document.querySelector("#receipt").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
  });

  document.querySelector("#itemQuantity").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
  });

  document.querySelector("#total").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 46 || evt.which > 57)
    {
        evt.preventDefault();
    }
    if (evt.keyCode === 46 && document.getElementById('total').value.split('.').length === 2) {
        evt.preventDefault();
    }
  });

  document.querySelector("#itemPrice").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 46 || evt.which > 57)
    {
        evt.preventDefault();
    }
    if (evt.keyCode === 46 && document.getElementById('itemPrice').value.split('.').length === 2) {
        evt.preventDefault();
    }
  });

  $scope.show = function(a_id){
    if($scope.accountID.indexOf(a_id)!==-1){  //Toggle between select and deselect button for Accounts
      return false;
    }
    else{
      return true;
    }
  };

  $scope.addID = function(a_id){
    $scope.accountID.push(a_id);            //Add Account ID to list
    console.log($scope.accountID);
  }

  $scope.deleteID = function(a_id){
    var index = $scope.accountID.indexOf(a_id); //Delete Account ID from list
    $scope.accountID.splice(index, 1);
  }

  $scope.addItem = function(ev) {
    if(document.getElementById('itemName').value.trim() == ""){
      $mdDialog.show(
         $mdDialog.alert()
         .parent(angular.element(document.querySelector('#popupContainer')))
         .clickOutsideToClose(true)
         .title('Error')
         .textContent('It seems you left some fields')
         .ariaLabel('Alert')
         .ok('Ok')
         .targetEvent(ev)
     );
    }
    else {
    $scope.account_info.push({
        item_price: parseFloat(document.getElementById('itemPrice').value),
        item_name: document.getElementById('itemName').value,                  //Add Item to List
        quantity: parseInt(document.getElementById('itemQuantity').value),
        list_of_accounts: $scope.accountID
      });
    }
    $scope.accountID = [];
    $mdDialog.hide();
    $(".reset").val("");
    console.log($scope.account_info);
    itemCount = itemCount+1;
  };

  $scope.temp = function() {
    console.log($scope.account_info);
  }

  $scope.submit = function() {
        console.log($scope.picture.files)
    };

  $scope.itemDialog = function(ev) {
    $mdDialog.show({
      contentElement:'#myContainer',
      parent: angular.element(document.body),
      targetEvent: ev,
      clickOutsideToClose: true
    })
  };

  $scope.notifications = function() {
    $mdDialog.show({
      scope: $scope,
      preserveScope: true,
      controller: 'notifCtrl',
      templateUrl:'invView/notification.html',
      parent: angular.element(document.body),
      clickOutsideToClose: true
    })
  };

  $scope.hide = function(){
    $mdDialog.hide();
  };

  $scope.deleteItem = function(item){
    var index = $scope.account_info.indexOf(item);
    $scope.account_info.splice(index, 1);
    itemCount = itemCount - 1;
  }

  $scope.remove = function(file) {
    var index = $scope.picture.files.indexOf(file);
    $scope.picture.files.splice(index, 1);
  }

  $scope.path = function(path){
    var substring = ".pdf";
    console.log(path);
    if(path.indexOf(substring) !== -1){
      return true;
    }
    else {
      return false;
    }
  }

  $scope.pdf = function(file) {
    console.log(file);
    var pdf_url = URL.createObjectURL(file);
    window.open(pdf_url);
  }

                                                                    //Create Controller GETs
  //Get all research accounts of user as PI
  $http.get('http://localhost:8000/api/v1/researcher/allResearchAccountsPI/'+sessionStorage.r_id).then(function mySuccess(response) {
      $scope.accounts = response.data;
    console.log(response.data);
    }, function myFailure(response) {
      $scope.accounts = response.statusText;
    });

  //Get all research accounts of user as COPI
  $http.get('http://localhost:8000/api/v1/researcher/allResearchAccountsCOPI/'+sessionStorage.r_id).then(function mySuccess(response) {
      $scope.accountsCOPI = response.data;
    console.log(response.data);
    }, function myFailure(response) {
      $scope.accounts = response.statusText;
    });

                                                                  //Create Controller POSTs
  //Post to create transaction
  $scope.submitTrans = function (ev) {
    if(document.getElementById('number').value.trim() == "" ||
        document.getElementById('receipt').value.trim() == ""  ||
        document.getElementById('location').value.trim() == "" ||
        document.getElementById('just').value.trim() == ""){
          $mdDialog.show(
            $mdDialog.alert()
            .parent(angular.element(document.querySelector('#popupContainer')))
            .clickOutsideToClose(true)
            .title('Error')
            .textContent('One or many of the fields seems to be empty!')
            .ariaLabel('Alert')
            .ok('Ok')
            .targetEvent(ev)
          );
        }
        else if (itemCount==0) {
             $mdDialog.show(
                $mdDialog.alert()
                .parent(angular.element(document.querySelector('#popupContainer')))
                .clickOutsideToClose(true)
                .title('Error')
                .textContent('The item list seems to be empty!')
                .ariaLabel('Alert')
                .ok('Ok')
                .targetEvent(ev)
            );
        }
      else if ($scope.picture.files == null || $scope.picture.files.length === 0) {
        $mdDialog.show(
           $mdDialog.alert()
           .parent(angular.element(document.querySelector('#popupContainer')))
           .clickOutsideToClose(true)
           .title('Error')
           .textContent('You seem to have forgotten to upload a receipt image')
           .ariaLabel('Alert')
           .ok('Ok')
           .targetEvent(ev)
       );
      }
      else{
            Upload.upload({
                url: 'http://localhost:8000/api/v1/researcher/createNewTransaction/'+sessionStorage.r_id,
                method: 'POST',
                file: $scope.picture.files,
                data: {
                      'transaction_number': document.getElementById('number').value,
                      'receipt_number': document.getElementById('receipt').value,
                      'date_bought': $filter('date')($scope.myDate, 'yyyy-MM-dd'),
                      'company_name': document.getElementById('location').value,
                      'description_justification': document.getElementById('just').value,
                      'total': parseFloat(document.getElementById('total').value),
                      'items': $scope.account_info,
                      'targetPath' : '/media/'
                }
            }).then(function (resp) {
                console.log(resp.data);
                console.log($scope.picture.files);
                $scope.viewTransactions();
            }, function (resp) {
              console.log('Error status: ' + resp.status);
            }, function (evt) {
                var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
            });

          }
}

}]);
//End of Create Transaction Controller



// ***************************************************************************************************
//                             Create Account Controller: addAcc.html
// ***************************************************************************************************

app.controller('createAccount', ['$scope','$http','$state', '$stateParams', '$mdDialog', function($scope, $http, $state, $stateParams, $mdDialog) {
  if($stateParams.r_id!==0){
    sessionStorage.r_id = $stateParams.r_id;
  }

  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  $scope.rid = decoded.rid;
  sessionStorage.r_id = decoded.rid;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;

                                                        //Create Account Controller Routing
  $scope.viewProfile = function () {
    $state.go("viewprofile", {'r_id':sessionStorage.r_id});
  }

  $scope.createRep = function () {
    $state.go("createreport", {'r_id':sessionStorage.r_id});
  }

  $scope.viewTransactions = function() {
    $state.go('viewTransactions', {'r_id':sessionStorage.r_id})
  }

  $scope.viewHome = function () {
    $state.go('invHome', {'r_id':sessionStorage.r_id});
  }

  $scope.viewCo = function() {
    $state.go('cotransactions', {'r_id':sessionStorage.r_id});
  }

  $scope.reconcile = function(){
    $state.go('reconciled', {'r_id':sessionStorage.r_id});
  }

                                                      //Create Account Controller Variables
  $scope.alert = 1;
  $scope.researcher = [];
  $scope.researcher_id = [];
  $scope.temp = 0;
  $scope.select = "Select";
  $scope.isValid = true;


                                                      //Create Account Controller Functions
  $scope.show = function(researcher){
    if($scope.researcher_id.indexOf(researcher)!==-1){  //Toggle between select and deselect for COPIs
      return false;
    }
    else{
      return true;
    }
  };

  $scope.decision = function(value){
    $scope.alert = parseInt(value);               //Decision to be notified
    console.log($scope.alert);
  }

  $scope.addresearcher = function(co_id){
    $scope.researcher_id.push(co_id);             //Add COPI ID to list
    console.log($scope.researcher_id);
  }

  $scope.deleteresearcher = function(co_id){
    var index = $scope.researcher_id.indexOf(co_id);  //Delete COPI ID from list
    $scope.researcher_id.splice(index, 1);
  }

  $scope.notifications = function() {
    $mdDialog.show({
      scope: $scope,
      preserveScope: true,
      controller: 'notifCtrl',
      templateUrl:'invView/notification.html',
      parent: angular.element(document.body),
      clickOutsideToClose: true
    })
  }

  document.querySelector("#ufis1").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
  });

  document.querySelector("#ufis2").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
  });

  document.querySelector("#ufis3").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
  });

  document.querySelector("#ufis4").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
  });

  document.querySelector("#ufis5").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
  });

  document.querySelector("#ufis6").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
  });

  document.querySelector("#ufis7").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
  });

  document.querySelector("#frs1").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
  });

  document.querySelector("#frs2").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
  });

  document.querySelector("#budget").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 46 || evt.which > 57)
    {
        evt.preventDefault();
    }
    if (evt.keyCode === 46 && document.getElementById('budget').value.split('.').length === 2) {
        evt.preventDefault();
    }
  });

                                                                        //Ceate Account Controller GETs
  //Get all researcher info
  $http.get('http://localhost:8000/api/v1/researcher/allResearchers/'+sessionStorage.r_id).then(function mySuccess(response) {
      console.log(sessionStorage.r_id)
      for(i = 0; i < response.data; i++){
        if(rid===response.data[i].researcher_id){
          response.data.splice(i, 1);
        }
      }
      $scope.researchers = response.data;
    }, function myFailure(response) {
      $scope.researchers = response.statusText;
    });

                                                      //Create Account Controller POSTs
  //Post new Account
  $scope.submit = function(ev) {
    console.log("Entered");
    if(document.getElementById('nickname').value.trim() == ""){
        console.log("case 1");
        $mdDialog.show(
           $mdDialog.alert()
           .parent(angular.element(document.querySelector('#popupContainer')))
           .clickOutsideToClose(true)
           .title('Error')
           .textContent('One or many fields seem to be empty!')
           .ariaLabel('Alert')
           .ok('Ok')
           .targetEvent(ev)
       );
      }
      else if($scope.researcher_id.length === 0){
        console.log("case 2");
        $mdDialog.show(
           $mdDialog.alert()
           .parent(angular.element(document.querySelector('#popupContainer')))
           .clickOutsideToClose(true)
           .title('Error')
           .textContent('You seem to have not chosen any Co-Investigators!')
           .ariaLabel('Alert')
           .ok('Ok')
           .targetEvent(ev)
       );
      }
      else if(document.getElementById('ufis1').value.length<5 ||
              document.getElementById('ufis2').value.length<3 ||
              document.getElementById('ufis3').value.length<3 ||
              document.getElementById('ufis4').value.length<4 ||
              document.getElementById('ufis5').value.length<3 ||
              document.getElementById('ufis6').value.length<11 ||
              document.getElementById('ufis7').value.length<2 ||
              document.getElementById('frs1').value.length<1 ||
              document.getElementById('frs2').value.length<5) {

                console.log("case not long enough");
                $mdDialog.show(
                   $mdDialog.alert()
                   .parent(angular.element(document.querySelector('#popupContainer')))
                   .clickOutsideToClose(true)
                   .title('Error')
                   .textContent('The UFIS or FRS number fields do not have the proper length!')
                   .ariaLabel('Alert')
                   .ok('Ok')
                   .targetEvent(ev)
               );
      }
      else{
        console.log("case 3");
        var ufis = document.getElementById('ufis1').value+"."
        +document.getElementById('ufis2').value+"."
        +document.getElementById('ufis3').value+"."
        +document.getElementById('ufis4').value+"."
        +document.getElementById('ufis5').value+"."
        +document.getElementById('ufis6').value+"."
        +document.getElementById('ufis7').value;
        console.log()
        var frs = document.getElementById('frs1').value+"-"
                  +document.getElementById('frs2').value;
        $http({
          method: "POST",
          url:"http://localhost:8000/api/v1/researcher/createNewResearchAccount/"+sessionStorage.r_id,
          headers: {'Content-Type' : 'application/json'},
          data:{
            research_nickname: document.getElementById('nickname').value,
            ufis_account_number: ufis,
            frs_account_number: frs,
            unofficial_budget: parseFloat(document.getElementById('budget').value),
            budget_remaining: parseFloat(document.getElementById('budget').value),
            list_of_copi: $scope.researcher_id,
            is_notified: parseInt($scope.value)
          }
        }).then(function mySuccess(response){
            console.log(response.data);
            console.log(ufis);
             $scope.viewHome();
        }), function myError(response){
            console.log(response.data);
        };
      }
  }
}]);
//End of Create Account Controller



// ***************************************************************************************************
//                            Profile Controller: profile.php
// ***************************************************************************************************
app.controller('profileCtrl', ['$scope', '$http', '$state', '$stateParams', '$mdDialog', function($scope, $http, $state, $stateParams, $mdDialog) {
  if($stateParams.r_id !== 0){
    sessionStorage.r_id = $stateParams.r_id;
  }

  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  $scope.rid = decoded.rid;
  sessionStorage.r_id = decoded.rid;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;

                                                                //Profile Controller Routing
  $scope.viewProfile = function () {
    $state.go("viewprofile", {'r_id':sessionStorage.r_id});
  }

  $scope.createRep = function () {
    $state.go("createreport", {'r_id':sessionStorage.r_id});
  }

  $scope.viewTransactions = function() {
    $state.go('viewTransactions', {'r_id':sessionStorage.r_id})
  }

  $scope.viewHome = function () {
    $state.go('invHome', {'r_id':sessionStorage.r_id});
  }

  $scope.viewCo = function() {
    $state.go('cotransactions', {'r_id':sessionStorage.r_id});
  }

  $scope.reconcile = function(){
    $state.go('reconciled', {'r_id':sessionStorage.r_id});
  }

                                                                //Profile Controller Variables
  $scope.profile_info = [];
  $scope.warning = false;
  $scope.warning1 = false;



                                                                //Profile Controller Functions

  document.querySelector("#number").addEventListener("keypress", function (evt) {
  if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
      evt.preventDefault();
    }
  });

  document.querySelector("#id").addEventListener("keypress", function (evt) {
  if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
      evt.preventDefault();
    }
  });

  $scope.hide = function(){
    $mdDialog.hide();
  }

  $scope.dialogBut = function(ev) {
    $mdDialog.show({
      contentElement:'#myContainer',
      parent: angular.element(document.body),
      targetEvent: ev,
      clickOutsideToClose: true
    })
  }

  $scope.notifications = function() {
    $mdDialog.show({
      scope: $scope,
      preserveScope: true,
      controller: 'notifCtrl',
      templateUrl:'invView/notification.html',
      parent: angular.element(document.body),
      clickOutsideToClose: true
    })
  }



                                                                //Profile Controller GETs
  //Get all user info
  $http.get('http://localhost:8000/api/v1/researcher/individualResearcherInfo/'+sessionStorage.r_id).then(function mySuccess(response) {
      $scope.profile_info = response.data;
      console.log(response.data);
    }, function myFailure(response) {
      $scope.profile_info = response.statusText;
    });

                                                                //Profile Controller POSTs
    //POST to edit profile information
    $scope.change = function() {
      if(document.getElementById('number').value.length !== 9){
        $scope.warning = true;
      }
      else if(document.getElementById('id').value.trim() == ""||
              document.getElementById('title').value.trim() == "" ||
              document.getElementById('department').value.trim() == "" ||
              document.getElementById('office').value.trim() == ""){
        $scope.warning1=true;
      }
      else{
        $scope.warning = false;
        $scope.warning1 = false;
        $http({
          method: "POST",
          url:"http://localhost:8000/api/v1/researcher/editResearcher/"+sessionStorage.r_id,
          headers: {'Content-Type' : 'application/json'},
          data:{
            office: document.getElementById('office').value,
            department: document.getElementById('department').value,
            phone_number: document.getElementById('number').value,
            job_title: document.getElementById('title').value,
            employee_id: document.getElementById('id').value
          }
        }).then(function mySuccess(response){
            console.log(response.data);
            $http.get('http://localhost:8000/api/v1/researcher/individualResearcherInfo/'+sessionStorage.r_id).then(function mySuccess(response) {
                $scope.profile_info = response.data;
                console.log(response.data);
                $mdDialog.hide();
              }, function myFailure(response) {
                $scope.profile_info = response.statusText;
              });
        }), function myError(response){
            console.log(response.data);
        };
      }
    }

}]);
//End of Profile Controller

// ***************************************************************************************************
//                             CO-PI Transactions Controller: coTransaction.html
// ***************************************************************************************************
app.controller('coCtrl', ['$scope', '$state', '$http', '$stateParams', '$mdDialog', function($scope, $state, $http, $stateParams, $mdDialog){

  $scope.viewProfile = function () {$state.go("viewprofile", {'r_id':sessionStorage.r_id});}
  $scope.createRep = function () {$state.go("createreport", {'r_id':sessionStorage.r_id});}
  $scope.viewTransactions = function() {$state.go('viewTransactions', {'r_id':sessionStorage.r_id})}
  $scope.viewHome = function () {$state.go('invHome', {'r_id':sessionStorage.r_id});}
  $scope.viewCo = function() {$state.go('cotransactions', {'r_id':sessionStorage.r_id});}
  $scope.audit = function(t_id, ra_id) {$state.go('audit', {'r_id':sessionStorage.r_id, 't_id': t_id, 'ra_id': ra_id});}

  $scope.reconcile = function(){
    $state.go('reconciled', {'r_id':sessionStorage.r_id});
  }

  if($stateParams.r_id !== 0){
    sessionStorage.r_id = $stateParams.r_id;
  }

  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  $scope.rid = decoded.rid;
  sessionStorage.r_id = decoded.rid;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;

  $scope.coTransactions = [];

  $scope.notifications = function() {
    $mdDialog.show({
      scope: $scope,
      preserveScope: true,
      controller: 'notifCtrl',
      templateUrl:'invView/notification.html',
      parent: angular.element(document.body),
      clickOutsideToClose: true
    })
  }
  //mddatepicker configuration
  $scope.months = ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sep','Oct', 'Nov', 'Dec'];
  $scope.years = ['2017', '2018','2019','2020','2021', '2022', '2023', '2024','2025', '2026', '2027', '2028','2029', '2030'];
  $scope.myDate = new Date();
  $scope.month = $scope.months[$scope.myDate.getUTCMonth()];
  $scope.year = $scope.myDate.getUTCFullYear();
  $scope.formattedDate = $scope.months[$scope.myDate.getMonth()]+ "-"+ $scope.myDate.getUTCFullYear();

  //$scope.maxDate = new Date();
  $scope.myDate = new Date();
  $scope.formattedDate = $scope.months[$scope.myDate.getMonth()]+ "-"+ $scope.myDate.getUTCFullYear();
  //end of md Datepicker configuration
  //functions
  $scope.viewCycle = function()
  {
    var year = $scope.year;
    var month = $scope.month;
    $scope.formattedDate = month+ "-"+ year;
    console.log(year + " "+ month);
    console.log('here');
  $http({
    method: 'GET',
    url: 'http://localhost:8000/api/v1/researcher/getAllTransactionToApprove/'+sessionStorage.r_id+'/'+month+'/'+year
  }).then(function successCallback(response) {
    $scope.coTransactions = response.data;
    for(var i =0; i<$scope.coTransactions.length; i++){
      $scope.coTransactions[i].first_name = $scope.coTransactions[i].first_name + " "+$scope.coTransactions[i].last_name;
    }
    console.log(response.data);
    }, function errorCallback(response) {
      // called asynchronously if an error occurs
      // or server returns response with an error status.
    });

  }
  $scope.viewAll = function(){
    $http.get('http://localhost:8000/api/v1/researcher/getAllTransactionToApprove/'+sessionStorage.r_id).then(function mySuccess(response) {
        $scope.coTransactions = response.data;
        $scope.formattedDate = "All";
        console.log(response.data);
      }, function myFailure(response) {
        console.log(response);
      });
  }
  $http.get('http://localhost:8000/api/v1/researcher/getAllTransactionToApprove/'+sessionStorage.r_id).then(function mySuccess(response) {
      $scope.coTransactions = response.data;
      $scope.formattedDate = "All";
      console.log(response.data);
    }, function myFailure(response) {
      console.log(response);
    });

}]);


// ***************************************************************************************************
//                             MdDialog Notifications Controller: notification.html
// ***************************************************************************************************
app.controller('notifCtrl', function($scope, $http, $state, $mdDialog, $stateParams){

  $scope.salsa = "salsa";
  console.log($scope.rid);
  sessionStorage.r_id = $scope.rid;
  $scope.notification = [];


  $scope.close = function () {
    $mdDialog.hide();
  }

  $scope.notifs = function() {
    console.log(sessionStorage.r_id);
    $state.go('notifications', {'r_id':$scope.rid});
    $mdDialog.hide();
  }

  $http.get('http://localhost:8000/api/v1/researcher/topNotifications/'+sessionStorage.r_id).then(function mySuccess(response) {
      $scope.notification = response.data;
      console.log(response.data);
    }, function myFailure(response) {
      $scope.profile_info = response.statusText;
    });


});
//End of notifications dialog controller


// ***************************************************************************************************
//                             Notifications Controller: allNotifs.php
// ***************************************************************************************************
app.controller('notificationCtrl',function($scope, $http, $state, $mdDialog, $stateParams){

  $scope.viewProfile = function () {
    $state.go("viewprofile", {'r_id':sessionStorage.r_id});
  }

  $scope.createRep = function () {
    $state.go("createreport", {'r_id':sessionStorage.r_id});
  }

  $scope.viewTransactions = function() {
    $state.go('viewTransactions', {'r_id':sessionStorage.r_id})
  }

  $scope.viewHome = function () {
    $state.go('invHome', {'r_id':sessionStorage.r_id});
  }

  $scope.viewCo = function() {
    $state.go('cotransactions', {'r_id':sessionStorage.r_id});
  }

  $scope.reconcile = function(){
    $state.go('reconciled', {'r_id':sessionStorage.r_id});
  }

  if($stateParams.r_id !== 0){
    sessionStorage.r_id = $stateParams.r_id;
  }
  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  $scope.rid = decoded.rid;
  sessionStorage.r_id = decoded.rid;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;


  $scope.notifs = [];

  $scope.notifications = function() {
    $mdDialog.show({
      scope: $scope,
      preserveScope: true,
      controller: 'notifCtrl',
      templateUrl:'invView/notification.html',
      parent: angular.element(document.body),
      clickOutsideToClose: true
    })
  };

  $http.get('http://localhost:8000/api/v1/researcher/allNotifications/'+sessionStorage.r_id).then(function mySuccess(response) {
      $scope.notifs = response.data;
      console.log(response.data);
    }, function myFailure(response) {
      console.log(response);
    });

});
//End of All Notifications Controller


// ***************************************************************************************************
//                             Audit Co_investigator Controller: coAudit.php
// ***************************************************************************************************
app.controller('auditCtrl', ['$scope', '$http', '$state', '$stateParams', '$mdDialog', function($scope, $http, $state, $stateParams, $mdDialog) {
  if($stateParams.r_id !== 0){
    sessionStorage.r_id = $stateParams.r_id;
    sessionStorage.t_id = $stateParams.t_id;
    sessionStorage.ra_id = $stateParams.ra_id;
  }
                                                                //Profile Controller Routing
  $scope.viewProfile = function () {
    $state.go("viewprofile", {'r_id':sessionStorage.r_id});
  }

  $scope.createRep = function () {
    $state.go("createreport", {'r_id':sessionStorage.r_id});
  }

  $scope.viewTransactions = function() {
    $state.go('viewTransactions', {'r_id':sessionStorage.r_id})
  }

  $scope.viewHome = function () {
    $state.go('invHome', {'r_id':sessionStorage.r_id});
  }

  $scope.viewCo = function() {
    $state.go('cotransactions', {'r_id':sessionStorage.r_id});
  }

  $scope.reconcile = function(){
    $state.go('reconciled', {'r_id':sessionStorage.r_id});
  }

  $scope.t_info = [];
  $scope.accounts = [];

  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  $scope.rid = decoded.rid;
  sessionStorage.r_id = decoded.rid;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;

  $scope.show = function(ra_id){
      if($scope.accounts.indexOf(ra_id)!==-1){
        return true;
      }
      else {
        return false;
      }
  };

  console.log(sessionStorage.r_id);
  console.log(sessionStorage.t_id);
  console.log(sessionStorage.ra_id);

  $http.get('http://localhost:8000/api/v1/researcher/individualTransaction/'+sessionStorage.ra_id+'/'+sessionStorage.t_id).then(function mySuccess(response) {
    $scope.t_info = response.data;
    console.log(response.data);
    }, function myFailure(response) {
      $scope.t_info = response.statusText;
    });


  $http.get('http://localhost:8000/api/v1/researcher/allResearchAccountsPI/'+sessionStorage.r_id).then(function mySuccess(response) {
      for(i=0;i<response.data.length;i++){
        $scope.accounts.push(response.data[i].ra_id);
      }
      console.log($scope.accounts);
      console.log(response.data);
    }, function myFailure(response) {
      $scope.r_account_info = response.statusText;
    });


    $scope.audit = function(decision, id) {

      $http({
        method: "PUT",
        url:"http://localhost:8000/api/v1/researcher/auditItem/"+decision+"/"+sessionStorage.t_id+"/"+id,
        headers: {'Content-Type' : 'application/json'},
      }).then(function mySuccess(response){
          console.log(decision);
          console.log(response.data);
      }), function myError(response){
          console.log(response.data);
      };
    }

}]);
//End of Audit Controller


// ***************************************************************************************************
//                             Reconciliation Error Controller: error.php
// ***************************************************************************************************
app.controller('recCtrl', ['$scope', '$http', '$state', '$stateParams', '$mdDialog', function($scope, $http, $state, $stateParams, $mdDialog) {
  if($stateParams.r_id !== 0){
    sessionStorage.r_id = $stateParams.r_id;
  }
                                                                //Profile Controller Routing
  $scope.viewProfile = function () {
    $state.go("viewprofile", {'r_id':sessionStorage.r_id});
  }

  $scope.createRep = function () {
    $state.go("createreport", {'r_id':sessionStorage.r_id});
  }

  $scope.viewTransactions = function() {
    $state.go('viewTransactions', {'r_id':sessionStorage.r_id})
  }

  $scope.viewHome = function () {
    $state.go('invHome', {'r_id':sessionStorage.r_id});
  }

  $scope.viewCo = function() {
    $state.go('cotransactions', {'r_id':sessionStorage.r_id});
  }

  $scope.reconcile = function(){
    $state.go('reconciled', {'r_id':sessionStorage.r_id});
  }


  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  $scope.rid = decoded.rid;
  sessionStorage.r_id = decoded.rid;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;
  
  $scope.info = [];

  $scope.notifications = function() {
    $mdDialog.show({
      scope: $scope,
      preserveScope: true,
      controller: 'notifCtrl',
      templateUrl:'invView/notification.html',
      parent: angular.element(document.body),
      clickOutsideToClose: true
    })
  };

  $http.get('http://localhost:8000/api/v1/researcher/transactionsNotReconciliated/'+sessionStorage.r_id).then(function mySuccess(response) {
    $scope.info = response.data;
    console.log(response.data);
    }, function myFailure(response) {
      $scope.info = response.statusText;
      console.log($scope.info);
    });


}]);
//End of Not Reconciled Controller




// ***************************************************************************************************
//                            Testing Area
// ***************************************************************************************************

app.controller('imageCtrl', ['$scope', 'Upload','$http', function ($scope, Upload, $http) {

  $scope.img = [];

  $http.get('http://localhost:8000/api/v1/file/view/1').then(function mySuccess(response) {
      $scope.img = response.data;
      console.log($scope.img);
    }, function myFailure(response) {
      $scope.profile_info = response.statusText;
    });

}]);
