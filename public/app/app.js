'use strict';
var myapp = angular.module("myApp", ['ngRoute',
    'ngAria',
    'ngAnimate',
    'angularUtils.directives.dirPagination',
    'ngMaterial',
    'ui.router',
    'angularFileUpload',
    'ngFileUpload',
    'myApp.admin',
    'myApp.accountant',
    'myApp.investigator'
  ]);
myapp.config(function($stateProvider){
  $stateProvider.state('login', {
    url:'/',
    templateUrl:'/index.php',
    controller:'AuthController'
  });
$stateProvider.state('INVHome', {
  url:'/invHome',
  templateUrl: 'views/invView/invHome.php',                  //View Home
  controller:'homeCtrl'
});
$stateProvider.state('ACCHome',{
  url:'/accHome',
  templateUrl: 'views/accountantView/homeview.php',
  controller:'myCtrl'
});
$stateProvider.state('ADMNHome',{
  url:'/adminHome',
  templateUrl: 'views/adminView/admnHome.php',
  controller:'admnhomeCtrl'
});

});
myapp.controller('AuthController', ['$scope', '$http', '$state', '$stateParams', function($scope,$http, $state, $stateParams){
$scope.choosen = "accountant";
  $scope.changeChoosen = function(str){
    $scope.choosen = str;
    console.log(str);
  }
  $scope.login = function(){
    localStorage.clear();
     var credentials = {
       email: document.getElementById('email').value,
       password: document.getElementById('password').value,
       role: $scope.choosen
     }
     console.log("email"+ credentials.email);
     console.log("password"+ credentials.password);
     console.log("role" + credentials.role);
     $http({
       method: "POST",
       url: "http://aqueous-beach-94685.herokuapp.com/login",
       data: credentials,
     }).then(function mySuccess(response){
       console.log(response.data);
       localStorage.setItem("token", response.data.token);
       if($scope.choosen ==='accountant'){
         $state.go('ACCHome');
       }
       else if ($scope.choosen === 'researcher') {
         $state.go("INVHome");
         console.log('INVHome');
       }
       else{
         $state.go("ADMNHome");
       }



     }), function myError(response){
        console.log(response);
     };
  }
}]);
