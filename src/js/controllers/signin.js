'use strict';

/* Controllers */
// signin controller
app.controller('SigninFormController', ['$scope', '$http', '$state', function($scope, $http, $state,Base_URL) {
    $scope.user = {};
     $scope.authError = null;
    $scope.login = function(email,pass) {
        
          $scope.authError = null;
    $http.post('https://rupak.crystalbiltech.com/thebuttonapi/api/users/userlogin', {email: $scope.user.email, password: $scope.user.password})
            .then(function(response) {
                console.log(response.data.status);
                if(response.data.status){
                 window.location='#/user/profile';   
                }else{
                      $scope.authError = 'Email or Password not right';
                }
             
            }, function(x) {
                  console.log(x);
            $scope.authError = 'Server Error';
        }); 
        
  
    };
    
}])
;
