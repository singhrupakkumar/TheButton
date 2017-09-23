'use strict';

angular.module('slickExampleApp', ['slickCarousel', 'ngRoute'])
  .constant("Base_URL","https://rupak.crystalbiltech.com/thebutton/")
  .config(['$routeProvider', function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/home.html',
        controller: 'SlickController'
      })
      .otherwise({
        redirectTo: '/'
      });
  }])
  .config(['slickCarouselConfig', function (slickCarouselConfig) {
    slickCarouselConfig.dots = true;
    slickCarouselConfig.autoplay = false;
  }])
  .controller('SlickController',['$scope','$sce','$location','$interval' ,'$http','$rootScope','Base_URL','$timeout', function($scope, $sce,$location,$interval,$http,$rootScope,Base_URL,$timeout) {
      
      
        $http({
  method: 'GET',
  url:Base_URL+'api/products/productsdata'
}).then(function successCallback(response) {  
    $scope.productlist=response.data.list;
    //console.log(response.data.list);
  }, function errorCallback(response) { 
    console.log(response);
  });
  
       $http({
  method: 'GET',
  url:Base_URL+'api/products/productsdata'
}).then(function successCallback(response) {  
    $scope.productlist=response.data.list;
    //console.log(response.data.list);
  }, function errorCallback(response) { 
    console.log(response);
  });
      $('#prodtdescr').modal('hide');  
$scope.productdetail = function (id){
  
           
         //  var id = 3;
      // if(window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr') != null){
             
            
      
                $http({ 
             method: 'post',
             data:{id:id},
             url:Base_URL+'api/products/getproductbyid'
           }).then(function successCallback(response) {  
             
              console.log(response.data.data);   
               var src = response.data.data.Product.video;         
                $rootScope.video = $sce.trustAsResourceUrl(src);    
              $rootScope.productdetailc = response.data.data;
              $rootScope.test = []; 
              
           
               angular.forEach(response.data.all, function(value, key){ 
                     $rootScope.test.push(value.Product.id);    
               });    
               
                 // console.log(response.data.all);
               
              $rootScope.allproduct = response.data.all;  
             $rootScope.asdf = "";
    $rootScope.asdf = {
      method: {},
      dots: true,
      infinite: false,
      speed: 300,
      slidesToShow: 4,
      slidesToScroll: 4,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    };
               
             }, function errorCallback(response) {  
               console.log(response);
             });  
//          
//       }else{
//            $('#mysignup').modal('show');    
//       }  
//   
$('#prodtdescr').modal('show');  
     }
 
    
    $scope.number3 = [{label: 1}, {label: 2}, {label: 3}, {label: 4}, {label: 5}, {label: 6}, {label: 7}, {label: 8}];
    $scope.slickConfig3Loaded = true;
    $scope.slickConfig3 = {
      method: {},
      dots: true,
      infinite: false,
      speed: 300,
      slidesToShow: 4,
      slidesToScroll: 4,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    };
    
   


  }]);  
