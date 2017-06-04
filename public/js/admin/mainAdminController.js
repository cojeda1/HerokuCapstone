//out in another file app.js
app = angular.module("myApp.admin", ['ngRoute',
    'ngAria',
    'ngAnimate',
    'angularUtils.directives.dirPagination',
    'ngMaterial',
    'ui.router',
    'angularFileUpload',
    'ngFileUpload']);
//STATE CONFIGURATION:
app.config(function($stateProvider){
  ///*******************************///
  ///      NAV HOME                 ///
  ///******************************///
  $stateProvider.state('adminHome', {
    url:'/home',
    templateUrl: 'adminView/admnHome.php',
    controller: 'admnhomeCtrl'
  });
  ///*******************************///
  ///      NAV CREATE USER         ///
  ///******************************///
  $stateProvider.state('createAcc',{
    url:'/createAccountant',
    templateUrl: 'adminView/adminAddAccountant.php',
    controller:'createAccCntrl'
  });
  ///*******************************///
  ///          NAV VIEW             ///
  ///******************************///
  $stateProvider.state('viewUsers',{
    url:'/viewUser',
    templateUrl: 'adminView/userList.php',
    controller:'listCtrl'
  });
  $stateProvider.state('viewCreditCards',{
    url: '/viewCreditCards',
    templateUrl: 'adminView/adminCreditCards.php',
    controller: 'crediCardsctrl'
  });
  ///*******************************///
  /// NAV VIEW - Investigator       ///
  ///******************************///
  $stateProvider.state('viewInvestigator',{
    url: '/viewInv',
    params: {'iid':0},
    templateUrl: 'adminView/viewInvestigatorInformation.php',
    controller: 'viewAnInvCntrl'
  });
  ///*******************************///
  /// NAV VIEW - Accountant         ///
  ///******************************///
  $stateProvider.state('viewAccountant',{
    url: '/viewAccountant',
    params: {'aid':0},
    templateUrl: 'adminView/viewAccountantInformation.php',
    controller: 'viewAnAccCntrl'
  });
  ///*******************************///
  /// NAV VIEW - Admin              ///
  ///******************************///
  $stateProvider.state('viewAdmin',{
    url: '/viewAdmin',
    params: {'adid':0},
    templateUrl: 'viewAdminInformation.php',
    controller: 'viewAnAdminCntrl'
  });
  ///****************************************///
  /// NAV VIEW - Accountant-Edit Accountant ///
  ///***************************************///
  $stateProvider.state('editAccountant', {
    url:'/editAcc',
    params: {'aid':0},
    templateUrl: 'adminView/adminEditAccountant.php',
    controller: 'editAccCntrl'
  });
  ///****************************************///
  /// Investigator-Edit Investigator ///
  ///***************************************///
  $stateProvider.state('editInvestigator', {
    url:'/editInv',
    params: {'r_id':0},
    templateUrl: 'adminView/adminEditInvestigator.php',
    controller: 'editInvCntrl'
  });

  ///****************************************///
  /// Investigator-Create Investigator ///
  ///***************************************///
  $stateProvider.state('createInvestigator', {
    url:'/createInv',
    templateUrl: 'adminView/adminAddInv.php',
    controller: 'createInv'
  });
  ///****************************************///
  /// Investigator-Create Administrator ///
  ///***************************************///
  $stateProvider.state('createAdministrator', {
    url:'/createAdmin',
    templateUrl: 'adminAddAdmin.php',
    controller: 'createAdminctrl'
  });

  ///****************************************///
  /// Purrchase Report-View Cycle ///
  ///***************************************///
  $stateProvider.state('cycle', {
    url:'/viewCycle',
    templateUrl: 'adminView/adminCyclePR.php',
    controller: 'viewCycle'
  });

  ///****************************************///
  /// Purrchase Report-View Purchase ///
  ///***************************************///
  $stateProvider.state('purchase', {
    url:'/purchase',
    params: {'t_id':0},
    templateUrl: 'adminView/admnViewReport.php',
    controller: 'viewReportCntrl'
  });

  ///****************************************///
  /// Purrchase Report-Edit Purchase ///
  ///***************************************///
  $stateProvider.state('editReport', {
    url:'/editPR',
    params: {'t_id':0},
    templateUrl: 'adminView/adminViewPR.php',
    controller: 'editInvCntrl'
  });
  ///****************************************///
  ///         Excel Upload                  ///
  ///***************************************///
  $stateProvider.state('upload', {
    url:'/upload',
    templateUrl: 'adminUpload.php',
    controller: 'uploadCtrl'
  });
  ///****************************************///
  ///          Excel Results                ///
  ///***************************************///
  $stateProvider.state('results', {
    url:'/results',
    templateUrl: 'reconciliationResult.php',
    controller: 'resultCtrl'
  });
});
//Controllers:
////************************************************************************///
///       HOME VIEW  CONTROLLER                                             ///
////************************************************************************///
app.controller('admnhomeCtrl',['$scope', '$http','$state', function($scope, $http, $state){
  //Navigation Bar
  $scope.homeOpen = function(){$state.go('adminHome');}
  $scope.usersOpen = function(){$state.go('viewUsers');}
  $scope.ccOpen = function(){$state.go('viewCreditCards');}
  $scope.createAccOpen = function(){$state.go('createAcc');}
  $scope.viewCycle = function(){$state.go('cycle');}
  $scope.createInv = function(){$state.go('createInvestigator');}
  $scope.createAdmin = function(){$state.go('createAdministrator');}
  $scope.excelUpload = function(){$state.go('upload');}
  $scope.excelResults = function(){$state.go('results');}
  //GETS
  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  var admin_id = decoded.admin_id;
  sessionStorage.admin_id = decoded.admin_id;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;
  ///**Unassigned Transactions***///
  //**Assigned Transactions**//
  $http({
     method: "GET",
     url: "http://localhost:8000/api/v1/administrator/allTransactions"
  }).then(function mySuccess(response){
      $scope.reports = response.data;
      for(var i =0; i<$scope.reports.length; i++){
        $scope.reports[i].researcher_first_name = $scope.reports[i].researcher_first_name + " "+$scope.reports[i].researcher_last_name;
        $scope.reports[i].accountant_first_name = $scope.reports[i].accountant_first_name + " "+$scope.reports[i].accountant_last_name;
      }

      console.log(response.data);
  }), function myError(response){
      console.log("Error!!");
  };
$scope.purchase = function(t_id){
$state.go('purchase', {'t_id':t_id});
}
  $scope.tableSort = function(keyname){
      console.log(keyname);
      $scope.sortKey = keyname;
      $scope.reverse = !$scope.reverse;
  }

}]);
////************************************************************************///
///       VIEW Investigator/Accountant CONTROLLER                           ///
////************************************************************************///
app.controller('listCtrl',['$scope','$http','$state' ,function($scope, $http, $state, $watch) {
  //Navigation Bar
  $scope.homeOpen = function(){$state.go('adminHome');}
  $scope.usersOpen = function(){$state.go('viewUsers');}
  $scope.ccOpen = function(){$state.go('viewCreditCards');}
  $scope.createAccOpen = function(){$state.go('createAcc');}
  $scope.viewCycle = function(){$state.go('cycle');}
  $scope.createInv = function(){$state.go('createInvestigator');}
  $scope.createAdmin = function(){$state.go('createAdministrator');}
  $scope.excelUpload = function(){$state.go('upload');}
  $scope.excelResults = function(){$state.go('results');}

            $scope.currentNavItem = "view1";
            $scope.pageSize = 10;
            $scope.typeUser = 'Accountant'
            $scope.users =[];
            var token = localStorage.getItem("token");
            var base64Url = token.split('.')[1];
            var base64 = base64Url.replace('-', '+');
            var base64 = base64Url.replace('_', '/');
            var decoded = JSON.parse(window.atob(base64));
            var admin_id = decoded.admin_id;
            sessionStorage.admin_id = decoded.admin_id;
            $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            //For ng-init
            $scope.viewAccountant = function(accountantId){
              console.log("here"+accountantId);
              $state.go('viewAccountant', {'aid':accountantId});
            }
            $scope.viewInv = function(invId){
              $state.go('viewInvestigator', {'iid':invId});
            }
            $scope.viewAdmin = function(adminId){
              $state.go('viewAdmin', {'adid':adminId})
            }
            $http({
               method: "GET",
               url: "http://localhost:8000/api/v1/administrator/allAccountants"
            }).then(function mySuccess(response){
                $scope.accountants = response.data;
                for(var i =0; i<$scope.accountants.length; i++){
                  $scope.accountants[i].accountant_info.first_name = $scope.accountants[i].accountant_info.first_name + "  "+$scope.accountants[i].accountant_info.last_name;
                }
                console.log(response.data);
            }), function myError(response){
                console.log("accountants");
                console.log(response.data);
            };
            $http({
               method: "GET",
               url: "http://localhost:8000/api/v1/administrator/allResearchers"
            }).then(function mySuccess(response){
                $scope.investigators = response.data;
                for(var i =0; i<$scope.investigators.length; i++){
                  $scope.investigators[i].researcher_first_name = $scope.investigators[i].researcher_first_name + " "+$scope.investigators[i].researcher_last_name;
                  $scope.investigators[i].accountant_first_name = $scope.investigators[i].accountant_first_name + " "+$scope.investigators[i].accountant_last_name;
                }
                console.log(response.data);
            }), function myError(response){
                console.log(response.data);
            };
            $http({
               method: "GET",
               url: "http://localhost:8000/api/v1/administrator/allAdministrators"
            }).then(function mySuccess(response){
                $scope.admins = response.data;
                for(var i =0; i<$scope.admins.length; i++){
                  $scope.admins[i].first_name = $scope.admins[i].first_name + "  "+$scope.admins[i].last_name;
                }
                console.log(response.data);
            }), function myError(response){
                console.log("accountants");
                console.log(response.data);
            };
            $scope.changeTypeUser = function(strng){
              $scope.typeUser = strng;
              console.log("typeUser: "+$scope.typeUser);
            }

            $scope.tableSort = function(keyname){
                $scope.sortKey = keyname;
                $scope.reverse = !$scope.reverse;
            }

    }]);

////************************************************************************///
///       View an Accountant                                                ///
////************************************************************************///
app.controller('viewAnAccCntrl', ['$scope', '$http', '$state','$stateParams', '$mdDialog', function($scope,$http,$state,$stateParams,$mdDialog){
  //Navigation Bar
  $scope.homeOpen = function(){$state.go('adminHome');}
  $scope.usersOpen = function(){$state.go('viewUsers');}
  $scope.ccOpen = function(){$state.go('viewCreditCards');}
  $scope.createAccOpen = function(){$state.go('createAcc');}
  $scope.viewCycle = function(){$state.go('cycle');}
  $scope.createInv = function(){$state.go('createInvestigator');}
  $scope.createAdmin = function(){$state.go('createAdministrator');}
  $scope.excelUpload = function(){$state.go('upload');}
  $scope.excelResults = function(){$state.go('results');}

  $scope.hide = function(){$mdDialog.hide();}
  $scope.cancel = function(){$mdDialog.cancel();}
  $scope.answer = function(answer){$mdDialog.hide(answer);}
  if($stateParams.aid !=0){
   $scope.theaid = $stateParams.aid;
   sessionStorage.aid = $scope.theaid;
  }
  console.log(sessionStorage.aid);
  $scope.editAccountant = function(){
    console.log('here!');
    $state.go('editAccountant', {aid:sessionStorage.aid});
  }
  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  var admin_id = decoded.admin_id;
  sessionStorage.admin_id = decoded.admin_id;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;

  $http({
     method: "GET",
     url: "http://localhost:8000/api/v1/administrator/researchersAssignedToAccountant/"+sessionStorage.aid
  }).then(function mySuccess(response){
      $scope.assigned_investigators = response.data;
      console.log(response.data);
  }), function myError(response){
      console.log(response.data);
  };
  $http({
     method: "GET",
     url: "http://localhost:8000/api/v1/administrator/getAccountant/"+sessionStorage.aid
  }).then(function mySuccess(response){
      $scope.acc = response.data.accountant_information;
      $scope.recent_Transactions = response.data.recent_Transactions;
        for(var i =0; i<$scope.recent_Transactions.length; i++){
          $scope.recent_Transactions[i].researcherFirstName = $scope.recent_Transactions[i].researcherFirstName +" "+$scope.recent_Transactions[i].researcherlastName;
        }
      console.log("accountant_information: ")
      console.log($scope.acc);
  }), function myError(response){
      console.log(response.data);
  };

}]);
////************************************************************************///
///       View an Admin                                              ///
////************************************************************************///
app.controller('viewAnAdminCntrl', ['$scope', '$http', '$state','$stateParams', '$mdDialog', function($scope,$http,$state,$stateParams,$mdDialog){
  //Navigation Bar
  $scope.homeOpen = function(){$state.go('home');}
  $scope.usersOpen = function(){$state.go('viewUsers');}
  $scope.ccOpen = function(){$state.go('viewCreditCards');}
  $scope.createAccOpen = function(){$state.go('createAcc');}
  $scope.viewCycle = function(){$state.go('cycle');}
  $scope.createInv = function(){$state.go('createInvestigator');}
  $scope.createAdmin = function(){$state.go('createAdministrator');}
  $scope.excelUpload = function(){$state.go('upload');}
  $scope.excelResults = function(){$state.go('results');}

  $scope.hide = function(){$mdDialog.hide();}
  $scope.cancel = function(){$mdDialog.cancel();}
  $scope.answer = function(answer){$mdDialog.hide(answer);}
  if($stateParams.adid !=0){
   $scope.theadid = $stateParams.adid;
   sessionStorage.adid = $scope.theadid;
  }
  console.log(sessionStorage.adid);
  $scope.disableAdmin = function(ev){
    console.log('here!');
    var confirm = $mdDialog.confirm()
    .title("Are you sure you want to disable the admin?")
    .targetEvent(ev)
    .ok('Yes')
    .cancel('Cancel');
    $mdDialog.show(confirm).then(function() {
      $http({
            method: "PUT",
            url:"http://localhost:8000/api/v1/administrator/disableAdmin/"+sessionStorage.adid,
            headers: {'Content-Type' : 'application/json'},
          }).then(function mySuccess(response){
              console.log(response.data);
              $state.go('viewAdmin', {aid:sessionStorage.adid},{reload:true});
          }), function myError(response){
              console.log(response.data);
          };
    });
  }

  $http({
     method: "GET",
     url: "http://localhost:8000/api/v1/administrator/individualAdministrator/"+sessionStorage.adid
  }).then(function mySuccess(response){
      $scope.admin_info = response.data;
      console.log(response.data);
  }), function myError(response){
      console.log(response.data);
  };
}]);
////************************************************************************///
///       edit an Accountat                                             ///
////************************************************************************///
app.controller('editAccCntrl', ['$scope', '$http', '$state','$stateParams', '$mdDialog', function($scope,$http,$state,$stateParams,$mdDialog){
  $scope.hide = function(){$mdDialog.hide();}
  $scope.cancel = function(){$mdDialog.cancel();}
  $scope.answer = function(answer){$mdDialog.hide(answer);}
  //Navigation Bar
  $scope.homeOpen = function(){$state.go('adminHome');}
  $scope.usersOpen = function(){$state.go('viewUsers');}
  $scope.ccOpen = function(){$state.go('viewCreditCards');}
  $scope.createAccOpen = function(){$state.go('createAcc');}
  $scope.viewCycle = function(){$state.go('cycle');}
  $scope.createInv = function(){$state.go('createInvestigator');}
  $scope.createAdmin = function(){$state.go('createAdministrator');}
  $scope.excelUpload = function(){$state.go('upload');}
  $scope.excelResults = function(){$state.go('results');}
  //End of Navigation Bar
  $scope.close = function(){$state.go('viewAccountant', {aid:sessionStorage.aid})}

  $scope.assigned_investigators =[];
  if($stateParams.aid !=0){
   $scope.theaid = $stateParams.aid;
   sessionStorage.aid = $scope.theaid;
  }

  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  var admin_id = decoded.admin_id;
  sessionStorage.admin_id = decoded.admin_id;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;

  $scope.addInv= function(ev){
    $mdDialog.show({
      controller: 'viewAnAccCntrl',
      templateUrl:'addInvDialog.html',
      parent: angular.element(document.body),
      targetEvent: ev,
      clickOutsideToClose: true,
      fullscreen: $scope.customFullscreen
    })
    .then(function(answer){
        $scope.assigned_investigators.push(
          {researcher_id: answer.researcher_id,
           first_name: answer.researcher_first_name,
           last_name: answer.researcher_last_name,
          }
        );

    }, function(){

    });
  }
  $scope.deleteInv = function(ai){
    var index = $scope.assigned_investigators.indexOf(ai);
    $scope.assigned_investigators.splice(index, 1);
  }
 var rids=[];
  $scope.test = function(ev){
    console.log("here in done");
    var arrayLength = $scope.assigned_investigators.length;
    for(var i =0 ; i<arrayLength; i++)
      rids.push($scope.assigned_investigators[i].researcher_id);
      if(document.getElementById('firstName').value.trim() == "" ||
    document.getElementById('lastName').value.trim() == "" || document.getElementById('email').value.trim() == ""
    || document.getElementById('office').value.trim() =="" || document.getElementById('department').value.trim() =="" ||
    document.getElementById('phoneNumber').value.trim() =="" || document.getElementById('job').value.trim()==""){
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
  else{
      console.log(rids);
      console.log(document.getElementById('firstName').value);
      console.log(document.getElementById('lastName').value);
      console.log(document.getElementById('office').value);
      console.log(document.getElementById('department').value);
      console.log(document.getElementById('phoneNumber').value);
      console.log(document.getElementById('job').value);
      console.log(document.getElementById('email').value);

  $http({
        method: "PUT",
        url:"http://localhost:8000/api/v1/administrator/editAccountant/"+sessionStorage.aid,
        headers: {'Content-Type' : 'application/json'},
        data:{
            first_name: document.getElementById('firstName').value,
            last_name: document.getElementById('lastName').value,
            office: document.getElementById('office').value,
            department: document.getElementById('department').value,
            phone_number: document.getElementById('phoneNumber').value,
            job_title: document.getElementById('job').value,
            email: document.getElementById('email').value,
            password: '1234',
            created_at: Date.now(),
            updated_at: Date.now(),
            list_of_researchers: rids
        }
      }).then(function mySuccess(response){
          console.log(response.data);
          $state.go('viewAccountant', {aid:sessionStorage.aid},{reload:true});
      }), function myError(response){
          console.log(response.data);
      };
    }
  }
  $http({
     method: "GET",
     url: "http://localhost:8000/api/v1/administrator/researchersAssignedToAccountant/"+sessionStorage.aid
  }).then(function mySuccess(response){
      $scope.assigned_investigators = response.data;
      $scope.rids = response.data.researcher_id;
      console.log(response.data);
  }), function myError(response){
      console.log(response.data);
  };
  $http({
     method: "GET",
     url: "http://localhost:8000/api/v1/administrator/getAccountant/"+sessionStorage.aid
  }).then(function mySuccess(response){
      $scope.acc = response.data.accountant_information;
      $scope.recent_Transactions = response.data.recent_Transactions;
      console.log($scope.acc);
  }), function myError(response){
      console.log(response.data);
  };
}]);
////************************************************************************///
///       View an Investigator                                              ///
////************************************************************************///
app.controller('viewAnInvCntrl', ['$scope', '$http', '$state','$stateParams', '$mdDialog', function($scope,$http,$state,$stateParams,$mdDialog){
  //Navigation Bar
  $scope.homeOpen = function(){$state.go('adminHome');}
  $scope.usersOpen = function(){$state.go('viewUsers');}
  $scope.ccOpen = function(){$state.go('viewCreditCards');}
  $scope.createAccOpen = function(){$state.go('createAcc');}
  $scope.viewCycle = function(){$state.go('cycle');}
  $scope.createInv = function(){$state.go('createInvestigator');}
  $scope.createAdmin = function(){$state.go('createAdministrator');}
  $scope.excelUpload = function(){$state.go('upload');}
  $scope.excelResults = function(){$state.go('results');}
  //End of Navigation Bar
  if($stateParams.iid !=0){
   $scope.theIid = $stateParams.iid;
   sessionStorage.invID = $scope.theIid;
  }
  console.log(sessionStorage.invID);
  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  var admin_id = decoded.admin_id;
  sessionStorage.admin_id = decoded.admin_id;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;
  $http({
     method: "GET",
     url: "http://localhost:8000/api/v1/administrator/getIndividualResearcher/"+sessionStorage.invID
  }).then(function mySuccess(response){
      $scope.researcher_info = response.data.researcher_info;
      $scope.purchase_reports = response.data.purchase_reports;
      $scope.creditCards = response.data.credit_card;
      $scope.activeCard = response.data.activeCard;
      $scope.accountantInfo = response.data.accountant_info;
      console.log(response.data);
  }), function myError(response){
      console.log(response.data);
  };

  $scope.edit = function(){
    $state.go('editInvestigator', {'r_id':sessionStorage.invID});
  }
}]);
////************************************************************************///
///       Create Accountant                                                 ///
////************************************************************************///
app.controller('createAccCntrl',['$scope', '$http','$state','$mdDialog', function($scope, $http, $state, $mdDialog){
      //Navigation Bar
      $scope.homeOpen = function(){$state.go('adminHome');}
      $scope.usersOpen = function(){$state.go('viewUsers');}
      $scope.ccOpen = function(){$state.go('viewCreditCards');}
      $scope.createAccOpen = function(){$state.go('createAcc');}
      $scope.viewCycle = function(){$state.go('cycle');}
      $scope.createInv = function(){$state.go('createInvestigator');}
      $scope.createAdmin = function(){$state.go('createAdministrator');}
      $scope.excelUpload = function(){$state.go('upload');}
      $scope.excelResults = function(){$state.go('results');}
      //End of Navigation Bar

      $scope.selected_researchers = [];
      $scope.rids =[];
      $scope.hide = function(){$mdDialog.hide();}
      $scope.cancel = function(){$mdDialog.cancel();}
      $scope.answer = function(answer){$mdDialog.hide(answer);}

      var token = localStorage.getItem("token");
      var base64Url = token.split('.')[1];
      var base64 = base64Url.replace('-', '+');
      var base64 = base64Url.replace('_', '/');
      var decoded = JSON.parse(window.atob(base64));
      var admin_id = decoded.admin_id;
      sessionStorage.admin_id = decoded.admin_id;
      $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;

      $scope.deleteInv = function(rid){
        var index = $scope.selected_researchers.indexOf(rid);
        var index2 = $scope.rids.indexOf(rid.reaserchers_id);
        $scope.selected_researchers.splice(index, 1);
        $scope.rids.splice(index2, 1);
      }
      $scope.addInv = function(ev){
        $mdDialog.show({
          controller: 'createAccCntrl',
          templateUrl:'addInvDialog.html',
          parent: angular.element(document.body),
          targetEvent: ev,
          clickOutsideToClose: true,
          fullscreen: $scope.customFullscreen
        })
        .then(function(answer){
            console.log(answer);
            $scope.selected_researchers.push(answer);
            $scope.rids.push(answer.researcher_id);

        }, function(){

        });
      }
$scope.createAccountant = function(ev){
      if(document.getElementById('firstName').value.trim() == "" ||
    document.getElementById('lastName').value.trim() == "" || document.getElementById('email').value.trim() == ""
    || document.getElementById('office').value.trim() =="" || document.getElementById('department').value.trim() =="" ||
    document.getElementById('phoneNumber').value.trim() =="" || document.getElementById('job').value.trim()==""){
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
    else{
      console.log("here in else");
       $http({
            method: "POST",
            url:"http://localhost:8000/api/v1/administrator/createAccountant",
            headers: {'Content-Type' : 'application/json'},
            data:{
                first_name: document.getElementById('firstName').value,
                last_name: document.getElementById('lastName').value,
                office: document.getElementById('office').value,
                department: document.getElementById('department').value,
                phone_number: document.getElementById('phoneNumber').value,
                job_title: document.getElementById('job').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                created_at: Date.now(),
                updated_at: Date.now(),
                list_of_researchers: $scope.rids
            }
          }).then(function mySuccess(response){
              console.log(response.data);
              $state.go('viewUsers');
          }), function myError(response){
              console.log(response.data);
          };
      }
    }
          $http({
             method: "GET",
             url: "http://localhost:8000/api/v1/administrator/allResearchers"
          }).then(function mySuccess(response){
              $scope.reaserchers = response.data;
              console.log(response.data);
          }), function myError(response){
              console.log(response.data);
          };
    }]);
////************************************************************************///
///       VIEW admin Credit Cards CONTROLLER                                ///
////************************************************************************///
app.controller('crediCardsctrl',['$scope','$http','$state', function($scope, $http, $state){
  //Navigation Bar
  $scope.homeOpen = function(){$state.go('adminHome');}
  $scope.usersOpen = function(){$state.go('viewUsers');}
  $scope.ccOpen = function(){$state.go('viewCreditCards');}
  $scope.createAccOpen = function(){$state.go('createAcc');}
  $scope.viewCycle = function(){$state.go('cycle');}
  $scope.createInv = function(){$state.go('createInvestigator');}
  $scope.createAdmin = function(){$state.go('createAdministrator');}
  $scope.excelUpload = function(){$state.go('upload');}
  $scope.excelResults = function(){$state.go('results');}
  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  var admin_id = decoded.admin_id;
  sessionStorage.admin_id = decoded.admin_id;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;

  //Gets
  $http({
     method: "GET",
     url: "http://localhost:8000/api/v1/administrator/allCreditCards"
  }).then(function mySuccess(response){
      $scope.creditCards = response.data;
      console.log(response.data);
  }), function myError(response){
      console.log(response.data);
  };

}]);
// ********************************************************************************
//                     Create Administrator Controller: adminAddAdmin.php
// ********************************************************************************
app.controller('createAdminctrl', ['$scope','$http','$state', '$mdDialog', function($scope, $http, $state, $mdDialog){
  //Navigation Bar
  $scope.homeOpen = function(){$state.go('home');}
  $scope.usersOpen = function(){$state.go('viewUsers');}
  $scope.ccOpen = function(){$state.go('viewCreditCards');}
  $scope.createAccOpen = function(){$state.go('createAcc');}
  $scope.viewCycle = function(){$state.go('cycle');}
  $scope.createInv = function(){$state.go('createInvestigator');}
  $scope.createAdmin = function(){$state.go('createAdministrator');}
  $scope.excelUpload = function(){$state.go('upload');}
  $scope.excelResults = function(){$state.go('results');}

  $scope.createAdmin = function(ev){
    console.log('here');
    console.log(document.getElementById('firstName').value);
    console.log(document.getElementById('lastName').value);
    console.log(document.getElementById('email').value);
    console.log(document.getElementById('office').value);
    console.log(document.getElementById('department').value);
    console.log(document.getElementById('phoneNumber').value);
    console.log(document.getElementById('job').value);

    if(document.getElementById('firstName').value.trim() == "" ||
    document.getElementById('lastName').value.trim() == "" || document.getElementById('email').value.trim() == ""
    || document.getElementById('office').value.trim() =="" || document.getElementById('department').value.trim() =="" ||
    document.getElementById('phoneNumber').value.trim() =="" || document.getElementById('job').value.trim()==""){
      console.log('here2');
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
else{
  console.log('here3');
    $http({
        method: "POST",
        url:"http://localhost:8000/api/v1/administrator/createAdministrator",
        headers: {'Content-Type' : 'application/json'},
        data:{
            first_name: document.getElementById('firstName').value,
            last_name: document.getElementById('lastName').value,
            office: document.getElementById('office').value,
            department: document.getElementById('department').value,
            phone_number: document.getElementById('phoneNumber').value,
            job_title: document.getElementById('job').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            created_at: Date.now(),
            updated_at: Date.now(),
        }
      }).then(function mySuccess(response){
          console.log(response.data);
          $state.go('viewUsers');
      }), function myError(response){
          console.log(response.data);
      };
    }
  }
  }]);

// ********************************************************************************
//                     Create Investigator Controller: adminAddInv.php
// ********************************************************************************
app.controller('createInv', ['$scope','$http','$state', '$mdDialog', function($scope, $http, $state, $mdDialog){
  //Navigation Bar
  $scope.homeOpen = function(){$state.go('adminHome');}
  $scope.usersOpen = function(){$state.go('viewUsers');}
  $scope.ccOpen = function(){$state.go('viewCreditCards');}
  $scope.createAccOpen = function(){$state.go('createAcc');}
  $scope.viewCycle = function(){$state.go('cycle');}
  $scope.createInv = function(){$state.go('createInvestigator');}
  $scope.createAdmin = function(){$state.go('createAdministrator');}
  $scope.excelUpload = function(){$state.go('upload');}
  $scope.excelResults = function(){$state.go('results');}
//End of Navigation Bar
  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  var admin_id = decoded.admin_id;
  sessionStorage.admin_id = decoded.admin_id;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;
                                                    //Create Investigator Variables
  $scope.accountants = [];
  $scope.years= [{
    value: '2017',
    label: '2017'
  },
  {
    value: '2018',
    label: '2018'
  },
  {
    value: '2019',
    label: '2019'
  },
  {
    value: '2020',
    label: '2020'
  },
  {
    value: '2021',
    label: '2021'
  }];

  $scope.months = [{
    value: '01',
    label: '01'
  },
  {
    value: '02',
    label: '02'
  },
  {
    value: '03',
    label: '03'
  },
  {
    value: '04',
    label: '04'
  },
  {
    value: '05',
    label: '05'
  },
  {
    value: '06',
    label: '06'
  },
  {
    value: '07',
    label: '07'
  },
  {
    value: '08',
    label: '08'
  },
  {
    value: '09',
    label: '09'
  },
  {
    value: '10',
    label: '10'
  },
  {
    value: '11',
    label: '11'
  },
  {
    value: '12',
    label: '12'
  }];
  $scope.accountants = [];
  $scope.ids = [];
  $scope.selectedAcc = " ";
//Create Investigator Functions
  $scope.getID = function(id){
    $scope.ids = id;
    $scope.selectedAcc =  id.accountant_info.first_name + " " + id.accountant_info.last_name;
    console.log($scope.ids);
  }


                                                    //Create Investigator GETs
  $http({
     method: "GET",
     url: "http://localhost:8000/api/v1/administrator/allAccountants"
  }).then(function mySuccess(response){
      $scope.accountants = response.data;
      console.log(response.data);
  }), function myError(response){
      console.log(response.data);
  };

                                                    //Create Investigator POSTs
  $scope.submit = function(ev){
    $scope.expiration = document.getElementById('year').value +'-'+ document.getElementById('month').value+'-01';
    console.log($scope.expiration)
    if(document.getElementById('firstName').value.trim() == "" ||
    document.getElementById('lastName').value.trim() == "" || document.getElementById('email').value.trim() == ""
    || document.getElementById('office').value.trim() =="" || document.getElementById('department').value.trim() =="" ||
    document.getElementById('phoneNumber').value.trim() =="" || document.getElementById('job_title').value.trim()=="" ||document.getElementById('cardNumber').value.trim()==""|| document.getElementById('cardName').value.trim()==""
    ||document.getElementById('amexID').value.trim()==""||document.getElementById('empID').value.trim()==""){
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
else{
    $http({
        method: "POST",
        url:"http://localhost:8000/api/v1/administrator/createResearcher",
        headers: {'Content-Type' : 'application/json'},
        data:{
            first_name: document.getElementById('firstName').value,
            last_name: document.getElementById('lastName').value,
            office: document.getElementById('office').value,
            department: document.getElementById('department').value,
            phone_number: document.getElementById('phoneNumber').value,
            job_title: document.getElementById('job_title').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            created_at: Date.now(),
            updated_at: Date.now(),
            credit_card_number: document.getElementById('cardNumber').value,
            name_on_card: document.getElementById('cardName').value,
            accountant_id: $scope.ids.accountant_id,
            expiration_date: $scope.expiration,
            amex_account_id: document.getElementById('amexID').value,
            employee_id: document.getElementById('empID').value
        }
      }).then(function mySuccess(response){
          console.log(response.data);
          $state.go('viewUsers');
      }), function myError(response){
          console.log(response.data);
      };
    }
  }
}]);
//End of Create Investigator Controller

// ********************************************************************************
//                    View Cycle Purchase Report: adminCyclePR.php
// ********************************************************************************

app.controller('viewCycle', ['$scope', '$http', '$state', '$filter', function($scope, $http, $state, $filter){
  $scope.reports = [];

  //Navigation Bar
  $scope.homeOpen = function(){$state.go('adminHome');}
  $scope.usersOpen = function(){$state.go('viewUsers');}
  $scope.ccOpen = function(){$state.go('viewCreditCards');}
  $scope.createAccOpen = function(){$state.go('createAcc');}
  $scope.viewCycle = function(){$state.go('cycle');}
  $scope.createInv = function(){$state.go('createInvestigator');}
  $scope.createAdmin = function(){$state.go('createAdministrator');}
  $scope.excelUpload = function(){$state.go('upload');}
  $scope.excelResults = function(){$state.go('results');}
 //End of Navigation Bar
 $scope.maxDate = new Date();

 //mddatepicker configuration
 $scope.months = ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sep','Oct', 'Nov', 'Dec'];
 $scope.years = ['2017', '2018','2019','2020','2021', '2022', '2023', '2024','2025', '2026', '2027', '2028','2029', '2030'];
 $scope.statuses = ['Assigned', 'Unassigned', 'All'];
 $scope.myDate = new Date();
 $scope.month = $scope.months[$scope.myDate.getUTCMonth()];
 $scope.year = $scope.myDate.getUTCFullYear();
 $scope.status = 'Assigned'
 $scope.formattedDate = $scope.months[$scope.myDate.getMonth()]+ "-"+ $scope.myDate.getUTCFullYear();
 //end of md Datepicker configuration
  $scope.purchase = function(t_id){$state.go('purchase', {'t_id':t_id});}

  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  var admin_id = decoded.admin_id;
  sessionStorage.admin_id = decoded.admin_id;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;

  $http({
     method: "GET",
     url: "http://localhost:8000/api/v1/administrator/transactionsAssigned"
  }).then(function mySuccess(response){
      $scope.formattedDate = "";
      $scope.reports = response.data;
      for(var i =0; i<$scope.reports.length; i++){
        $scope.reports[i].researcher_first_name = $scope.reports[i].researcher_first_name + " "+$scope.reports[i].researcher_last_name;
      }
      console.log(response.data);
  }), function myError(response){
      console.log(response.data);
  };
  $scope.viewCycle = function(){
    var year = $scope.year;
    var month = $scope.month;
    var status = $scope.status;
    $scope.formattedDate = month+ "-"+ year;
    console.log(year + " "+ month);
    console.log('here');
    var url1 = "";
    if(status == 'All'){
      url1 ='http://localhost:8000/api/v1/administrator/allTransactions'+'/'+month+'/'+year
    }
    else{
      url1 = 'http://localhost:8000/api/v1/administrator/transactions'+status+'/'+month+'/'+year
    }
    $http({
      method: 'GET',
      url: url1
    }).then(function successCallback(response) {
      $scope.reports = response.data;
      for(var i =0; i<$scope.reports.length; i++){
        $scope.reports[i].researcher_first_name = $scope.reports[i].researcher_first_name + " "+$scope.reports[i].researcher_last_name;
      }
      console.log(response.data);
      }, function errorCallback(response) {
        // called asynchronously if an error occurs
        // or server returns response with an error status.
      });
  }
  $scope.viewAll = function(){
    $scope.status ="All";
    $scope.formattedDate =" ";
    console.log($scope.status);
    console.log($scope.formattedDate);
    $http({
      method: 'GET',
      url: 'http://localhost:8000/api/v1/administrator/allTransactions'
    }).then(function successCallback(response) {
      $scope.reports = response.data;
      for(var i =0; i<$scope.reports.length; i++){
        $scope.reports[i].researcher_first_name = $scope.reports[i].researcher_first_name + " "+$scope.reports[i].researcher_last_name;
      }
      console.log(response.data);
      }, function errorCallback(response) {
        // called asynchronously if an error occurs
        // or server returns response with an error status.
      });
  }
}]);
//End of View Cycle Purchase Report Controller

// ********************************************************************************
//                    View Purchase Report: admnViewReport.php
// ********************************************************************************
app.controller('viewReportCntrl', ['$scope', '$http', '$state', '$stateParams', function($scope, $http, $state, $stateParams){
  //Navigation Bar
  $scope.homeOpen = function(){$state.go('adminHome');}
  $scope.usersOpen = function(){$state.go('viewUsers');}
  $scope.ccOpen = function(){$state.go('viewCreditCards');}
  $scope.createAccOpen = function(){$state.go('createAcc');}
  $scope.viewCycle = function(){$state.go('cycle');}
  $scope.createInv = function(){$state.go('createInvestigator');}
  $scope.createAdmin = function(){$state.go('createAdministrator');}
  $scope.excelUpload = function(){$state.go('upload');}
  $scope.excelResults = function(){$state.go('results');}
 //End of Navigation Bar

  if($stateParams.t_id!==0){
    sessionStorage.t_id = $stateParams.t_id;
  }

  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  var admin_id = decoded.admin_id;
  sessionStorage.admin_id = decoded.admin_id;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;

  $scope.report_info = [];
  $scope.reconciliated = function(id){
    if(id===0){
      return "Not yet Reconciliated";
    }
    else{
      return "Has been Reconciliated";
    }
  };
  $scope.assignAccountant = function(a_id){
    $http({
        method: "POST",
        url:"http://localhost:8000/api/v1/administrator/assignTransaction",
        headers: {'Content-Type' : 'application/json'},
        data:{
            transaction_id: sessionStorage.t_id,
            accountant_id: a_id,
            admin_id : 1
        }
      }).then(function mySuccess(response){
          console.log(response.data);
          $state.reload();
      }), function myError(response){
          console.log(response.data);
      };
  }
  $http({
     method: "GET",
     url: "http://localhost:8000/api/v1/administrator/allAccountants"
  }).then(function mySuccess(response){
      $scope.accountants = response.data;
      for(var i =0; i<$scope.accountants.length; i++){
        $scope.accountants[i].accountant_info.first_name = $scope.accountants[i].accountant_info.first_name + "  "+$scope.accountants[i].accountant_info.last_name;
      }
      console.log(response.data);
  }), function myError(response){
      console.log("accountants");
      console.log(response.data);
  };
  $http({
     method: "GET",
     url: "http://localhost:8000/api/v1/administrator/getIndividualTransaction/1/"+sessionStorage.t_id
  }).then(function mySuccess(response){
      for(i=0;i<response.data.comments.length;i++){
        response.data.comments[i].created_at = new Date(response.data.comments[i].created_at);
      }
      $scope.report_info = response.data;
      $scope.trans_info = response.data.transaction_info;
      $scope.trans_items = response.data.items;
      $scope.comments = response.data.comments;
      $scope.accountant = response.data.accountant;
      $scope.researcher = response.data.researcher;
      console.log($scope.trans_info);
      console.log($scope.trans_items);
      console.log("trans_comments: "+$scope.comments);
      console.log("trans_accountant: "+$scope.accountant);
      console.log("trans_researcher: "+$scope.researcher);
  }), function myError(response){
      console.log(response.data);
  };
}]);
//End of View Purchase Report Controller


// ********************************************************************************
//                    Edit Investigator: adminEditInvestigator.php
// ********************************************************************************
app.controller('editInvCntrl',['$scope','$http','$state', '$stateParams','$mdDialog', function($scope, $http, $state, $stateParams, $mdDialog){
  //Navigation Bar
  $scope.homeOpen = function(){$state.go('adminHome');}
  $scope.usersOpen = function(){$state.go('viewUsers');}
  $scope.ccOpen = function(){$state.go('viewCreditCards');}
  $scope.createAccOpen = function(){$state.go('createAcc');}
  $scope.viewCycle = function(){$state.go('cycle');}
  $scope.createInv = function(){$state.go('createInvestigator');}
  $scope.createAdmin = function(){$state.go('createAdministrator');}
  $scope.excelUpload = function(){$state.go('upload');}
  $scope.excelResults = function(){$state.go('results');}
 //End of Navigation Bar

  var token = localStorage.getItem("token");
  var base64Url = token.split('.')[1];
  var base64 = base64Url.replace('-', '+');
  var base64 = base64Url.replace('_', '/');
  var decoded = JSON.parse(window.atob(base64));
  var admin_id = decoded.admin_id;
  sessionStorage.admin_id = decoded.admin_id;
  $http.defaults.headers.common['Authorization'] = 'Bearer ' + token;

  if($stateParams.r_id!==0){
    sessionStorage.r_id = $stateParams.r_id;
  }
  $scope.researcher_info = [];
  $scope.purchase_reports = [];
  $scope.creditCards = [];
  $scope.activeCard = [];
  $scope.accountantInfo = [];
  $scope.accountants = [];
  $scope.accountant_id = 0;

  $scope.add = function(accountant){
    $scope.accountant_id = accountant.accountant_info.accountant_id;
    document.getElementById('accountant').value = accountant.accountant_info.first_name+' '+accountant.accountant_info.last_name;
  }

$scope.info = [];
  //Gets
  $http({
     method: "GET",
     url: "http://localhost:8000/api/v1/administrator/getIndividualResearcher/"+sessionStorage.r_id
  }).then(function mySuccess(response){
      $scope.researcher_info = response.data.researcher_info;
      $scope.purchase_reports = response.data.purchase_reports;
      $scope.creditCards = response.data.credit_card;
      $scope.activeCard = response.data.activeCard;
      $scope.accountantInfo = response.data.accountant_info;
      $scope.accountant_id = $scope.accountantInfo.accountant_id;

      document.getElementById('firstName').value = $scope.researcher_info.first_name;
      document.getElementById('lastName').value = $scope.researcher_info.last_name;
      document.getElementById('department').value = $scope.researcher_info.department;
      document.getElementById('office').value = $scope.researcher_info.office;
      document.getElementById('phoneNumber').value = $scope.researcher_info.phone_number;
      document.getElementById('jobTitle').value = $scope.researcher_info.job_title;
      document.getElementById('email').value = $scope.researcher_info.email;
      document.getElementById('employeeID').value = $scope.researcher_info.employee_id;
      document.getElementById('amexID').value = $scope.researcher_info.amex_account_id;
      document.getElementById('cardNumber').value = $scope.activeCard.credit_card_number;
      document.getElementById('expiration').value = $scope.activeCard.expiration_date;
      document.getElementById('cardName').value = $scope.activeCard.name_on_card;
      document.getElementById('accountant').value = $scope.accountantInfo.first_name+' '+$scope.accountantInfo.last_name;
      console.log(response.data);
  }), function myError(response){
      console.log(response.data);
  };

  $http({
     method: "GET",
     url: "http://localhost:8000/api/v1/administrator/allAccountants"
  }).then(function mySuccess(response){
      $scope.accountants = response.data;
      console.log(response.data);
  }), function myError(response){
      console.log(response.data);
  };

  $scope.test = function(ev) {
    if(document.getElementById('firstName').value.trim() == "" ||
    document.getElementById('lastName').value.trim() == "" ||
    document.getElementById('department').value.trim() == "" ||
    document.getElementById('office').value.trim() == "" ||
    document.getElementById('phoneNumber').value.trim() == "" ||
    document.getElementById('jobTitle').value.trim() == "" ||
    document.getElementById('email').value.trim() == "" ||
    document.getElementById('employeeID').value.trim() == "" ||
    document.getElementById('amexID').value.trim() == "" ||
    document.getElementById('cardNumber').value.trim() == "" ||
    document.getElementById('expiration').value.trim() == "" ||
    document.getElementById('cardName').value.trim() == "" ||
    document.getElementById('accountant').value.trim() == "" ){
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
else{
    $http({
          method: "PUT",
          url:"http://localhost:8000/api/v1/administrator/editResearcher/"+sessionStorage.r_id,
          headers: {'Content-Type' : 'application/json'},
          data:{
              first_name: document.getElementById('firstName').value,
              last_name: document.getElementById('lastName').value,
              office: document.getElementById('office').value,
              department: document.getElementById('department').value,
              phone_number: document.getElementById('phoneNumber').value,
              job_title: document.getElementById('jobTitle').value,
              email: document.getElementById('email').value,
              password: $scope.researcher_info.password,
              //created_at: $scope.researcher_info.created_at,
              updated_at: Date.now(),
              amex_account_id: document.getElementById('amexID').value,
              user_info_id: $scope.researcher_info.user_info_id,
              researcher_id: $scope.researcher_info.researcher_id,
              employee_id: $scope.researcher_info.employee_id,
              accountant_id: $scope.accountant_id
          }
        }).then(function mySuccess(response){
            console.log(response.data);
            $state.go('viewInvestigator', {'iid':sessionStorage.r_id});

        }), function myError(response){
            console.log(response.data);
        };
        $http({
              method: "POST",
              url:"http://localhost:8000/api/v1/administrator/editCreditCard/"+$scope.activeCard.cc_id,
              headers: {'Content-Type' : 'application/json'},
              data:{
                  credit_card_number: document.getElementById('cardNumber').value,
                  expiration_date: document.getElementById('expiration').value,
                  name_on_card: document.getElementById('cardName').value
                }
            }).then(function mySuccess(response){
                console.log(response.data);
            }), function myError(response){
                console.log(response.data);
            };
          }
  }

  $scope.create = function(ev){
    if(document.getElementById('reason').value.trim()=="" || document.getElementById('expiration1').value.trim()=="" ||document.getElementById('cardName1').value.trim()=="" ||  document.getElementById('reason').value==""){
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
    else{
    $http({
          method: "POST",
          url:"http://localhost:8000/api/v1/administrator/createNewCreditCard/"+sessionStorage.r_id,
          headers: {'Content-Type' : 'application/json'},
          data:{
              credit_card_number: document.getElementById('cardNumber1').value,
              expiration_date: document.getElementById('expiration1').value,
              name_on_card: document.getElementById('cardName1').value,
              reason: document.getElementById('reason').value,
              cc_id: $scope.activeCard.cc_id
            }
        }).then(function mySuccess(response){
            document.getElementById('cardNumber').value = document.getElementById('cardNumber1').value;
            document.getElementById('expiration').value = document.getElementById('expiration1').value;
            document.getElementById('cardName').value = document.getElementById('cardName1').value;

            console.log(response.data);
        }), function myError(response){
            console.log(response.data);
        };
    }
}

}]);
// ********************************************************************************
//                 Upload Excel Sheet: adminUpload.php
// ********************************************************************************

app.controller('uploadCtrl', ['$scope', '$http', '$state', 'Upload', function($scope, $http, $state, Upload){
  $scope.reports = [];

  //Navigation Bar
  $scope.homeOpen = function(){$state.go('home');}
  $scope.usersOpen = function(){$state.go('viewUsers');}
  $scope.ccOpen = function(){$state.go('viewCreditCards');}
  $scope.createAccOpen = function(){$state.go('createAcc');}
  $scope.viewCycle = function(){$state.go('cycle');}
  $scope.createInv = function(){$state.go('createInvestigator');}
  $scope.createAdmin = function(){$state.go('createAdministrator');}
  $scope.excelUpload = function(){$state.go('upload');}
  $scope.excelResults = function(){$state.go('results');}
//End of Navigation Bar

  $scope.purchase = function(t_id){$state.go('purchase', {'t_id':t_id});}

  $scope.picture = {};

  $scope.submit = function () {

  console.log($scope.picture.file);

  $scope.cancel = function(){
    $scope.picture = {};
  }


    Upload.upload({
        url: 'http://localhost:8000/api/v1/administrator/uploadExcel',
        headers : {
        'Content-Type': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        },
        method: 'POST',
        file: $scope.picture.file,
        data: {
          admin_id: 1,
          cycle: Date.now()
        }
    }).then(function (resp) {
        console.log(resp.data);
    }, function (resp) {
      console.log($scope.picture.file);
    });

  }

}]);
//End of View Cycle Purchase Report Controller
