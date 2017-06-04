app = angular.module("myApp.accountant", ['ngAria','ngAnimate','angularUtils.directives.dirPagination','ngMaterial','ui.router']);
//STATE CONFIGURATION
app.config(function($stateProvider, $urlRouterProvider){
  $stateProvider.state('viewreportAcc', {
      url: '/viewreport',
      params:{'tid':0},
      templateUrl:'accountantView/viewreport.php',
      controller: 'ACCviewReportCntrl',
  });
  $stateProvider.state('accHome',{
    url:'/accHome',
    templateUrl: 'accountantView/homeview.php',
    controller:'myCtrl'
  });
 $stateProvider.state('reportsOpen', {
   url:'/reportsOpen',
   templateUrl:'accountantView/reporthistory.php',
   controller:'rhcntrl'
 });
 $stateProvider.state('myHistory', {
   url:'/myHistory',
   templateUrl:'accountantView/auditedReports.php',
   controller: 'auditAccCtrl'
 });
 $stateProvider.state('myNotifications', {
   url:'/myNotifications',
   templateUrl:'accountantView/allNotifs.php',
   controller: 'notificationCtrl'
 });
});

//CONTROLLERS:
app.controller('loginCtrl', ['$scope', '$http', '$state', function($scope, $http, $state){
  $scope.homeOpen = function(){$state.go("accHome");}
}]);
////************************************************************************///
///       DIALOG PASSSWORD VIEW CONTROLLER                                  ///
////************************************************************************///
app.controller('dialogCntrl',['$scope', '$mdDialog', function($scope, $mdDialog){
  $scope.hide = function(){$mdDialog.hide();}
  $scope.cancel = function(){$mdDialog.cancel();}
  $scope.answer = function(answer){$mdDialog.hide(answer);}
}]);
////************************************************************************///
///       VIEW REPORT HISTORY CONTROLLER                                    ///
////************************************************************************///
app.controller('rhcntrl',['$scope', '$http','$state', '$mdDialog',function($scope, $http, $state,$mdDialog){
  ///****Report history page controller**///
  //Variables:
  var offset = new Date();
  var m = offset.getMonth();
  var y = offset.getFullYear();

  $scope.currentNavItem = 'Reports';
  $scope.pageSize = 10;
  //mddatepicker configuration
  $scope.months = ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sep','Oct', 'Nov', 'Dec'];
  $scope.years = ['2017', '2018','2019','2020','2021', '2022', '2023', '2024','2025', '2026', '2027', '2028','2029', '2030'];
  $scope.statuses = ['Unassigned', 'All'];
  $scope.myDate = new Date();
  $scope.month = $scope.months[$scope.myDate.getUTCMonth()];
  $scope.year = $scope.myDate.getUTCFullYear();
  $scope.formattedDate = $scope.months[$scope.myDate.getMonth()]+ "-"+ $scope.myDate.getUTCFullYear();
  $scope.status = 'All';
  //end of md Datepicker configuration
  var token = localStorage.getItem("token");
  console.log(token);
  var base64Url = token.split('.')[1];
  console.log(base64Url);
  console.log(typeof base64Url);
  var base64 = base64Url.replace('-', '+');
  console.log(base64);
  var base64 = base64Url.replace('_', '/');
   console.log(base64);
  var decoded = JSON.parse(window.atob(base64));
  console.log("decoded: ");
  console.log(decoded);
  console.log(decoded.aid);
  $scope.userid = decoded.aid;
  sessionStorage.aid = decoded.aid;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;
  //functions
  $scope.viewCycle = function()
  {
    var year = $scope.year;
    var month = $scope.month;
    $scope.formattedDate = month+ "-"+ year;
    console.log(year + " "+ month);
    console.log('here');
    if($scope.status == "Unassigned"){
      var url1 = "http://localhost:8000/api/v1/accountant/transactionsUnassigned/"+month+'/'+year
    }
    else if($scope.status == "Assigned to me"){
      var url1 = "http://localhost:8000/api/v1/accountant/transactionsAssigned/"+sessionStorage.aid+'/'+month+'/'+year
    }
    else{
      var url1 = 'http://localhost:8000/api/v1/accountant/transactions/'+month+'/'+year
    }
    $http({
      method: 'GET',
      url: url1
    }).then(function successCallback(response) {
      $scope.reports = response.data;
      for(var i =0; i<$scope.reports.length; i++){
        $scope.reports[i].first_name = $scope.reports[i].first_name + " "+$scope.reports[i].last_name;
      }
      console.log(response.data);
      }, function errorCallback(response) {
        // called asynchronously if an error occurs
        // or server returns response with an error status.
      });
      $scope.viewAll = function(){
        $scope.status ="All";
        $scope.formattedDate =" ";
        console.log($scope.status);
        console.log($scope.formattedDate);
        $http({
          method: 'GET',
          url: 'http://localhost:8000/api/v1/accountant/transactions'
        }).then(function successCallback(response) {
          $scope.reports = response.data;
          for(var i =0; i<$scope.reports.length; i++){
            $scope.reports[i].first_name = $scope.reports[i].first_name + " "+$scope.reports[i].last_name;
          }
          console.log(response.data);
          }, function errorCallback(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
          });
      }

  }
  //Functions:
  $scope.homeOpen = function(){
    console.log("entered");
    $state.go("accHome");}
  $scope.reportsOpen = function(){$state.go("reportsOpen");}
  $scope.auditedReport= function(){console.log("here");$state.go("myHistory");}
  $scope.transactID = function(report){$state.go('viewreportAcc', {'tid':report}, {reload:true});}

  $scope.notifications = function(ev) {
    $mdDialog.show({
      scope: $scope,
      preserveScope: true,
      controller: 'notifCtrl',
      templateUrl:'accountantView/notificationDialog.html',
      parent: angular.element(document.body),
      targetEvent: ev,
      clickOutsideToClose: true
    })
  }
  var year = $scope.year;
  var month = $scope.month;
  $http({
     method: "GET",
     url: 'http://localhost:8000/api/v1/accountant/transactions/'+month+'/'+year
  }).then(function mySuccess(response){
      $scope.reports = response.data;
      for(var i =0; i<$scope.reports.length; i++){
        $scope.reports[i].first_name = $scope.reports[i].first_name + " "+$scope.reports[i].last_name;
      }
      console.log(response.data);
  }), function myError(response){
      console.log("Error!!");
  };
  $scope.tableSort = function(keyname){
      $scope.sortKey = keyname;
      $scope.reverse = !$scope.reverse;
  }
}]);
////************************************************************************///
///       HOME VIEW CONTROLLER                                              ///
////************************************************************************///
app.controller('myCtrl',['$scope','$http','$state', '$mdDialog', function($scope, $http,$state,$mdDialog) {
        //Variables:
        $scope.userid= 4;
        $scope.pageSize = 10;
        $scope.reports =[];
        $scope.currentNavItem = 'Home';
       //functions
        $scope.transactID = function(report){
          $state.go('viewreportAcc', {'tid':report}, {reload:true});
        }
        $scope.typeReport = 'Assigned';
        $scope.changeTypeReport = function(str){
          $scope.typeReport = str;
        }
        $scope.homeOpen = function(){$state.go("accHome");}
        $scope.reportsOpen = function(){$state.go("reportsOpen");}
        $scope.auditedReport= function(){$state.go("myHistory");}
        //mddatepicker configuration
        $scope.months = ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sep','Oct', 'Nov', 'Dec'];
        $scope.years = ['2017', '2018','2019','2020','2021', '2022', '2023', '2024','2025', '2026', '2027', '2028','2029', '2030'];
        $scope.statuses = ['Assigned to me','Unassigned', 'All'];
        $scope.myDate = new Date();
        $scope.month = $scope.months[$scope.myDate.getUTCMonth()];
        $scope.year = $scope.myDate.getUTCFullYear();
        $scope.formattedDate = $scope.months[$scope.myDate.getMonth()]+ "-"+ $scope.myDate.getUTCFullYear();
        $scope.status = "All"
        $scope.formattedDate = "";
        //end of md Datepicker configuration
        //functions

        $scope.notifications = function(ev) {
          $mdDialog.show({
            scope: $scope,
            preserveScope: true,
            controller: 'notifCtrl',
            templateUrl:'accountantView/notificationDialog.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose: true
          })
        }

        var token = localStorage.getItem("token");
        console.log(token);
        var base64Url = token.split('.')[1];
        console.log(base64Url);
        console.log(typeof base64Url);
        var base64 = base64Url.replace('-', '+');
        console.log(base64);
        var base64 = base64Url.replace('_', '/');
         console.log(base64);
        var decoded = JSON.parse(window.atob(base64));
        console.log("decoded: ");
        console.log(decoded);
        console.log(decoded.aid);
        $scope.userid = decoded.aid;
        sessionStorage.aid = decoded.aid;
        $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        ///GETS
        $http({
           method: "GET",
           url: "http://localhost:8000/api/v1/accountant/transactionsAssignedInProgress/"+sessionStorage.aid
        }).then(function mySuccess(response){
            $scope.reports = response.data;
            for(var i =0; i<$scope.reports.length; i++){
              $scope.reports[i].first_name = $scope.reports[i].first_name + " "+$scope.reports[i].last_name;
            }
            console.log(response.data);
        }), function myError(response){
            console.log("Error!!");
        };

}]);
////************************************************************************///
///       VIEW REPORT CONTROLLER                                            ///
////************************************************************************///
app.controller('ACCviewReportCntrl', ['$scope','$http','$state','$stateParams','$mdDialog',function($scope, $http, $state, $stateParams, $mdDialog){
  ///Variables
  //$scope.userid = 4;
  var token = localStorage.getItem("token");
  console.log(token);
  var base64Url = token.split('.')[1];
  console.log(base64Url);
  console.log(typeof base64Url);
  var base64 = base64Url.replace('-', '+');
  console.log(base64);
  var base64 = base64Url.replace('_', '/');
   console.log(base64);
  var decoded = JSON.parse(window.atob(base64));
  console.log("decoded: ");
  console.log(decoded);
  console.log(decoded.aid);
  $scope.userid = decoded.aid;
  sessionStorage.aid = decoded.aid;
  $scope.tI = [];
  $scope.comments = [];
  $scope.tItems =[];

  //change a specific number in the accountantnumber
  $scope.noneditmode = true;
  $scope.editmode = false;
  $scope.editMode = function(ins){
     $scope.editmode = true;
     $scope.noneditmode = false;
     $scope.inserts = ins.split('.');
     $scope.nums4 = parseInt($scope.inserts[3]);
     $scope.choosen = ins;
   }
  $scope.editAcc = function(nums4,raid){
    //PUT request goes here!
    console.log(raid);
    console.log(raid + document.getElementById("editAccountNumber"+""+raid).value);
    $http({
       method:"PUT",
       url: "http://localhost:8000/api/v1/accountant/editResearchAccountNumber/"+raid+"/"+document.getElementById("editAccountNumber"+""+raid).value,
     }).then(function mySuccess(response){
         console.log(response.data);
         $state.reload();
         console.log('here');
         $scope.editmode = false;
         $scope.noneditmode = true;
     }), function myError(response){
       console.log(response.data);
     };

  }
  $scope.backToNoneEditMode = function(){$scope.editmode = false;$scope.noneditmode = true;}
  //end of change of specific number

  if($stateParams.tid != 0){
    $scope.theTid = $stateParams.tid;
    sessionStorage.transactionID = $scope.theTid;
  }
  console.log("Transaction ID: "+sessionStorage.transactionID);
  ///Functions
  $scope.homeOpen = function(){$state.go("accHome");}
  $scope.reportsOpen = function(){$state.go("reportsOpen");}
  $scope.auditedReport= function(){$state.go("myHistory");}
  $scope.hide = function(){$mdDialog.hide();}
  $scope.cancel = function(){$mdDialog.cancel();}
  $scope.answer = function(answer){$mdDialog.hide(answer);}

  $scope.notifications = function(ev) {
    $mdDialog.show({
      scope: $scope,
      preserveScope: true,
      controller: 'notifCtrl',
      templateUrl:'accountantView/notificationDialog.html',
      parent: angular.element(document.body),
      targetEvent: ev,
      clickOutsideToClose: true
    })
  }
  ///PUT!
  $scope.assignAccountant = function(){
    $http({
       method:"PUT",
       url: "http://localhost:8000/api/v1/accountant/assign/"+sessionStorage.transactionID+"/"+$scope.userid,
     }).then(function mySuccess(response){
         console.log(response.data);
         $state.reload();
     }), function myError(response){
       console.log(response.data);
     };
    ///END OF PUT
    console.log("here!");
  }
  //POSTS
  $scope.leaveComment = function(ev){
    $scope.leftComment = document.getElementById("comment").value;
    console.log("comment"+$scope.leftComment);
    if($scope.leftComment == null || $scope.leftComment=="" || $scope.leftComment.trim() == ""){
      $mdDialog.show(
        $mdDialog.alert()
        .parent(angular.element(document.querySelector('#popupContainer')))
        .clickOutsideToClose(true)
        .title('Error')
        .textContent('Please insert valid comment')
        .ariaLabel('Alert')
        .ok('Ok')
        .targetEvent(ev)
   );
    }
    else{
      $http({
        method: "POST",
        url:"http://localhost:8000/api/v1/accountant/comment/"+$scope.userid,
        headers: {'Content-Type' : 'application/json'},
        data:{
          created_at: Date.now(),
          updated_at: Date.now(),
          body_of_comment:$scope.leftComment,
          transaction_id:sessionStorage.transactionID
        }
      }).then(function mySuccess(response){
          console.log(response.data);
          $state.reload();
      }), function myError(response){
        console.log(response.data);
      };
    }
  }
  $scope.leaveNote = function(ev){
      $scope.leftNote = document.getElementById("note").value;
      if($scope.leftNote == null || $scope.leftNote==""|| $scope.leftNote.trim()==""){
        $mdDialog.show(
          $mdDialog.alert()
          .parent(angular.element(document.querySelector('#popupContainer')))
          .clickOutsideToClose(true)
          .title('Error')
          .textContent('Please insert valid note')
          .ariaLabel('Alert')
          .ok('Ok')
          .targetEvent(ev)
        );
      }
      else{
          $http({
            method: "POST",
            url:"http://localhost:8000/api/v1/accountant/note/"+$scope.userid,
            headers: {'Content-Type' : 'application/json'},
            data:{
              created_at: Date.now(),
              updated_at: Date.now(),
              body_of_note:$scope.leftNote,
              transaction_id:sessionStorage.transactionID
            }
          }).then(function mySuccess(response){
              console.log(response.data);
              $state.reload();
          }), function myError(response){
            console.log(response.data);
          };
    }
  }
  //DIALOG PUTS::
  $scope.customPrompt= function(ev, stringy){
        $mdDialog.show({
        controller:'dialogCntrl',
        templateUrl:'accountantView/pwdDialog.html',
        parent: angular.element(document.body),
        targetEvent: ev,
        clickoutsiteToClose:true
      })
      .then(function(answer){
        console.log("inserted password "+answer);
        console.log("saved password" +$scope.password[0].password);
        if(answer == null || answer == "" ||answer.trim()==""|| answer != $scope.password[0].password ){
            //DIALOG
            $mdDialog.show(
              $mdDialog.alert()
              .parent(angular.element(document.querySelector('#popupContainer')))
              .clickOutsideToClose(true)
              .title('Error')
              .textContent('Wrong password')
              .ariaLabel('Alert')
              .ok('Ok')
              .targetEvent(ev)
            );
        }
        else{
        ///PUT!
        $http({
           method:"PUT",
           url: "http://localhost:8000/api/v1/accountant/audit/"+sessionStorage.transactionID+"/"+stringy+"/"+$scope.userid,
         }).then(function mySuccess(response){
              $state.reload();
             console.log(response.data);
         }), function myError(response){
           console.log(response.data);
         };
        ///END OF PUT
        }
      },
      function(){
        console.log("Dialog cancelled")
      });

  };
  $scope.editNote = function(ev, noteId){
    console.log(noteId);
    console.log("here");
      $mdDialog.show({
        controller:'dialogCntrl',
        templateUrl:'editCommenTemp.html',
        parent: angular.element(document.body),
        targetEvent: ev,
        clickoutsiteToClose:true
      })
      .then(function(answer){
        console.log("new note"+ answer);
        if(answer == null || answer == ""|| answer.trim()==""){

        }
        else {
          ///PUT!
          $http({
             method:"PUT",
             url: " http://localhost:8000/api/v1/accountant/editNote/"+noteId,
             data:{
               updated_at: Date.now(),
               body_of_note:answer,
             }
           }).then(function mySuccess(response){
               console.log(response.data);
               $state.reload();
           }), function myError(response){
             console.log(response.data);
           };
          ///END OF PUT
        }

      },
      function(){
        console.log("Dialog cancelled");
      });
  }
  $scope.editComment= function(ev,commentId){
      console.log("here");
        $mdDialog.show({
          controller:'ACCviewReportCntrl',
          templateUrl:'editCommenTemp.html',
          parent: angular.element(document.body),
          targetEvent: ev,
          clickoutsiteToClose:true
        })
        .then(function(answer){
          console.log("new comment"+ answer);
          if(answer == null || answer == ""|| answer.trim()==""){
            //do nothing
          }
          else{
            ///PUT!
            $http({
               method:"PUT",
               url: " http://localhost:8000/api/v1/accountant/editComment/"+commentId.comment_id,
               data:{
                 updated_at: Date.now(),
                 body_of_comment:answer,
               }
             }).then(function mySuccess(response){
                 console.log(response.data);
                 $state.reload();
             }), function myError(response){
               console.log(response.data);
             };
            ///END OF PUT
            }
        },
        function(){
          console.log("Dialog cancelled");
        });
  };
  ///DELETE:
  $scope.deleteNote = function(noteId, ev){
    console.log("here"+noteId);

    $http({
      method:"DELETE",
      url:"http://localhost:8000/api/v1/accountant/deleteNote/"+noteId
    }).then(function mySuccess(response){
      console.log(response.data);
      $mdDialog.show(
        $mdDialog.alert()
        .parent(angular.element(document.querySelector('#popupContainer')))
        .clickOutsideToClose(true)
        .title('Confirmation')
        .textContent('Note succesfully deleted')
        .ariaLabel('Delete Note')
        .ok('Ok')
        .targetEvent(ev)
      );
      $state.reload();
    }), function myError(response){
      console.log(response.data);
    };

  }
  $scope.deleteComment = function(commentId, ev){
    console.log(commentId);
    $http({
      method:"DELETE",
      url:"http://localhost:8000/api/v1/accountant/deleteComment/"+commentId
    }).then(function mySuccess(response){
      console.log(response.data);
      $mdDialog.show(
        $mdDialog.alert()
        .parent(angular.element(document.querySelector('#popupContainer')))
        .clickOutsideToClose(true)
        .title('Confirmation')
        .textContent('succesfully deleted comment')
        .ariaLabel('Confirmation')
        .ok('Ok')
        .targetEvent(ev)
      );
      $state.reload();
    }), function myError(response){
      console.log(response.data);
    };
  };
  //GETS::
  //transcation info get
  $http({
    method: "GET",
    url:"http://localhost:8000/api/v1/researcher/getImages"+"/"+sessionStorage.transactionID
  }).then(function mySuccess(response){
      $scope.images = response.data;
      console.log(response.data);
  }), function myError(response){
    console.log(response.data);
  };
  $http({
    method: "GET",
    url:"http://localhost:8000/api/v1/accountant/password"+"/"+$scope.userid
  }).then(function mySuccess(response){
      $scope.password = response.data;
      console.log(response.data);
  }), function myError(response){
    console.log(response.data);
  };

  $http({
    method: "GET",
    url:"http://localhost:8000/api/v1/accountant/transaction"+"/"+$scope.userid+"/"+sessionStorage.transactionID
  }).then(function mySuccess(response){
      $scope.trans_info = response.data.transaction_info;
      $scope.comments = response.data.comments;
      $scope.trans_items = response.data.items;
      $scope.notes = response.data.notes;
      $scope.researcher = response.data.researcher;
      $scope.accountant = response.data.accountant;
      $scope.credit_card = response.data.credit_card;
      console.log(  $scope.trans_info[0].accountant_id + "userid"+$scope.userid);


  }), function myError(response){
    console.log(response.data);
  };
}]);
////************************************************************************///
///       VIEW Audited Reports CONTROLLER                                   ///
////************************************************************************///
app.controller('auditAccCtrl', ['$scope','$http','$state','$stateParams','$mdDialog',function($scope, $http, $state, $stateParams, $mdDialog){
  //transactions get
  var token = localStorage.getItem("token");
  console.log(token);
  var base64Url = token.split('.')[1];
  console.log(base64Url);
  console.log(typeof base64Url);
  var base64 = base64Url.replace('-', '+');
  console.log(base64);
  var base64 = base64Url.replace('_', '/');
   console.log(base64);
  var decoded = JSON.parse(window.atob(base64));
  console.log("decoded: ");
  console.log(decoded);
  console.log(decoded.aid);
  $scope.userid = decoded.aid;
  $scope.homeOpen = function(){
    console.log('Open home');
    $state.go("accHome");}
  $scope.reportsOpen = function(){$state.go("reportsOpen");}
  $scope.auditedReport= function(){$state.go("myHistory");}
  $scope.transactID = function(report){$state.go('viewreport', {'tid':report}, {reload:true});}
  $scope.currentNavItem = "Audited";
  $scope.auditedTrans = [];

  $scope.notifications = function(ev) {
    $mdDialog.show({
      scope: $scope,
      preserveScope: true,
      controller: 'notifCtrl',
      templateUrl:'accountantView/notificationDialog.html',
      parent: angular.element(document.body),
      targetEvent: ev,
      clickOutsideToClose: true
    })
  }
  //mddatepicker configuration
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
      url: 'http://localhost:8000/api/v1/accountant/transactionsValidated/'+$scope.userid+'/'+month+'/'+year
    }).then(function successCallback(response) {
      $scope.auditedTrans = response.data;
      for(var i =0; i<$scope.auditedTrans.length; i++){
        $scope.auditedTrans[i].first_name = $scope.auditedTrans[i].first_name + " "+$scope.auditedTrans[i].last_name;
      }
      console.log(response.data);
      }, function errorCallback(response) {
        // called asynchronously if an error occurs
        // or server returns response with an error status.
      });

  }

$http({
  method: "GET",
  url:"http://localhost:8000/api/v1/accountant/transactionsValidated/"+$scope.userid
}).then(function mySuccess(response){
    console.log("HEREEE WEE");
    console.log(response.data);
    $scope.auditedTrans = response.data;
    for(var i =0; i<$scope.auditedTrans.length; i++){
      $scope.auditedTrans[i].first_name = $scope.auditedTrans[i].first_name + " "+$scope.auditedTrans[i].last_name;
      console.log("WEPA:"+$scope.auditedTrans[i].first_name);
    }
}), function myError(response){
  console.log(response.data);
};



}]);

////************************************************************************///
///       Notification Dialog CONTROLLER                                    ///
////************************************************************************///

app.controller('notifCtrl', function($scope, $http, $state, $mdDialog, $stateParams){

  $scope.notification = [];
  $scope.a_id = 3;

  $scope.notifs = function() {
    $mdDialog.hide();
    $state.go('myNotifications');
  }

  $scope.close = function () {
    $mdDialog.hide();
  }

  $http.get('http://localhost:8000/api/v1/accountant/topNotifications/'+$scope.a_id).then(function mySuccess(response) {
      $scope.notification = response.data;
      console.log(response.data);
    }, function myFailure(response) {
      $scope.profile_info = response.statusText;
    });


});


// ***************************************************************************************************
//                             Notifications Controller: allNotifs.php
// ***************************************************************************************************
app.controller('notificationCtrl', function($scope, $http, $state, $mdDialog, $stateParams){

  $scope.homeOpen = function(){$state.go("accHome");}
  $scope.reportsOpen = function(){$state.go("reportsOpen");}
  $scope.auditedReport= function(){$state.go("myHistory");}

  $scope.notifs = [];
  var a_id = 3;
  sessionStorage.a_id = a_id;

  $scope.notifications = function(ev) {
    $mdDialog.show({
      scope: $scope,
      preserveScope: true,
      controller: 'notifCtrl',
      templateUrl:'accountantView/notificationDialog.html',
      parent: angular.element(document.body),
      targetEvent: ev,
      clickOutsideToClose: true
    })
  }


  $http.get('http://localhost:8000/api/v1/accountant/allNotifications/'+sessionStorage.a_id).then(function mySuccess(response) {
      $scope.notifs = response.data;
      console.log(response.data);
    }, function myFailure(response) {
      $scope.profile_info = response.statusText;
    });

});
//End of All Notifications Controller
