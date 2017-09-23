'use strict';

/**
 * all Controller for the router
 */

 app.controller('Uaccess', function($scope,$location,$http, $state,$rootScope,Base_URL,$localStorage) {      
     $scope.invite = {}; 
    
    $scope.regex = "/^-?[0-9][^\.]*$/"; 
     if(window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr')!=null){
            $scope.loggedin=1;
       }else{
           $scope.loggedin=0; 
       }    
    
      if(window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr') == null){
         $state.go('home');       
      } 
     
      ///////////search product/////////////////////
   $scope.searchcat = function (){ 
    $state.go('user.search', {action:'search', search:$scope.data.search});
    // alert($scope.data.search);
   } 
    
      $scope.user = {};
      
     
     $scope.authError = null;
    $scope.ulogin = function(email,pass) { 
        
          $scope.authError = null;
    $http.post(Base_URL+'api/users/userlogin', {email: $scope.user.email, password: $scope.user.password}) 
            .then(function(response) {
                if(response.data.status==true){  
                 localStorage.setItem('ZGV2ZWxvcGVyX3J1cGFr',response.data.id);
                 $('#mysignup').modal('hide');
                 window.location.reload();  
                // $state.go('user.profile');   
                
                }else{
                      $scope.authError = 'Email or Password not right';
                }
             
            }, function(x) {
                  console.log(x);
            $scope.authError = 'Server Error';
        }); 
        
  
    };
    

    
    
    /////////////////user data///////////////////////
     $scope.user= {};
  var uid = localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr');
  $rootScope.isLoading = true;  
    $http({ 
  method: 'post',
  data:{uid:uid},
  url:Base_URL+'api/users/userdata'
}).then(function successCallback(response) {    
  //alert(Base_URL);  
  $rootScope.cartuserinfo = response.data.userextrainfo;   
  $scope.mycontry
    $scope.user = response.data.user.User;  
   // $scope.ordercount = response.data.ordercount; 
      if(response.data.user.User.referral_code){
    $scope.userrefercodeurl = Base_URL+"?user_invitecode="+response.data.user.User.referral_code; 
      }  
     $scope.invite.refer_link=$scope.userrefercodeurl ;
    if(response.data.user.User.country == null){
      $scope.user.country  = 'United States';
    }else{
      $scope.user.country  = response.data.user.User.country;  
    }
    
     if(response.data.user.User.time_zone == null){
      $scope.user.time_zone  = '(GMT-05:00) Eastern Time (US & Canada)'; 
    }else{
      $scope.user.time_zone  = response.data.user.User.time_zone;  
    }
    
    $scope.country = response.data.country;
    $scope.timezone = response.data.timezone;  
     $rootScope.isLoading = false;    
//    $scope.user.email = response.data.user.User.email;
//    $scope.user.phone = response.data.user.User.phone;
  }, function errorCallback(response) { 
    console.log(response);
  });
  
  ////////////////////edit Address//////////////////////////////////////
  
    $scope.deleteaddress = function(id){  
       if (window.confirm("Are you sure you want to delete this mailing address?")){
          $http.post(Base_URL+'api/addresses/addressdelete', {id:id}) 
            .then(function(data) {
                if(data.data.status){       
                 $scope.deletemsg = data.data.msg;   
                 $('div#addresses #address-'+id).hide();
                }else{
                      $scope.deletemsg = data.data.msg;
                }
             
            }, function(x) {
                  console.log(x);
        });
    } 
    }
  
   /////////////////change password///////////////////////
  
   
     $scope.authError = null;
    $scope.changepassword = function() { 
       
        var id = localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr');
          $scope.authError = null;
    $http.post(Base_URL+'api/users/changepassword', {id:id,old_password: $scope.user.old_password, new_password: $scope.user.newpassword, cpassword: $scope.user.conformpassword}) 
            .then(function(response) {
         
                if(response.data.status==true){  
                          $scope.authError = 'Password has been Updated.';
                }else{
                      $scope.authError = response.data.msg;
                }
             
            }, function(x) {
                  console.log(x);
            $scope.authError = 'Server Error';
        }); 
        
  
    };
    
    /////////////////forgot password///////////////////////
    
   $scope.forgotpassword = function (){
        $scope.msg = null;
      
         $http.post(Base_URL+'api/users/forgetpwd', {username:$scope.user.email}) 
            .then(function(response) {
                if(response.data.status==true){  
                          $scope.msg = response.data.msg;
                }else{
                      $scope.msg = response.data.msg;
                }
             
            }, function(x) {
                 // console.log(x);
            $scope.msg = 'Server Error';
        }); 
   }
    /////////////////user logout///////////////////////
  $scope.userlogout = function (){    
   window.localStorage.clear();
   signOut();
    if(window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr') != null){
         $state.go('user.profile');     
    }else{
        $state.go('home');  
        window.location.reload();
    }
    
   
  } 
  
      /////////////////user profile update///////////////////////
  $scope.profileupdate = function (){  
     if ($scope.profile.$valid) {
      $scope.msg = null;
      $scope.error = null;  
    $http({ 
  method: 'post',
  data:{uid:uid,email:$scope.user.email,name:$scope.user.name,phone:$scope.user.phone,country:$scope.user.country,time_zone:$scope.user.time_zone,get_notification:$scope.user.get_notification},
  url:Base_URL+'api/users/profileupdate'
}).then(function successCallback(response) {  
 //console.log(response);
 if(response.data.status){
   $scope.msg = 'Profile updated';    
 $state.go('user.profile');      
 }
      
  }, function errorCallback(response) {  
    console.log(response);
  });
   
  }else{
  $scope.error = 'Something Wrong!';    
  }     
  }
  
     if($state.is('user.reminder')){
          $rootScope.isLoading = true;  
               var uid = window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr');
                $http({ 
           method: 'post',
           data:{uid:uid}, 
           url:Base_URL+'api/products/userreminderlist' 
         }).then(function successCallback(response) {   
          //console.log(response.data.list);  
            $scope.reminderlist = response.data.list;
             $rootScope.isLoading = false;  
           }, function errorCallback(response) { 
             console.log(response);
           });
  
    }
     $scope.reminderproductinfo= function (id){ 
       if(window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr') != null){
            $('#lotmodal').modal('show');   

                $http({ 
             method: 'post',
             data:{id:id},
             url:Base_URL+'api/products/getproductbyid'
           }).then(function successCallback(response) {  
              //console.log(response.data.data);   
              $rootScope.productinfo = response.data.data; 
            
             }, function errorCallback(response) { 
               console.log(response);
             });  
          
       }else{
            $('#mysignup').modal('show');   
       }  
   
     
     }

      $scope.invitebyemail= function (){
        
            $scope.msg = null;
              $http({ 
             method: 'post',
             data:{email_1:$scope.invite.email_1,email_2:$scope.invite.email_2,email_3:$scope.invite.email_3,email_4:$scope.invite.email_4,email_5:$scope.invite.email_5,refer_link:$scope.invite.refer_link},
             url:Base_URL+'api/users/invitebyemail'
           }).then(function successCallback(response) {    
             // console.log(response.data.data);   
                if(response.data.status){  
                    $scope.msg = 'Successfully sent';    
                  
                  }
             }, function errorCallback(response) { 
               console.log(response);
             }); 
             
      }
       $scope.addpromo= function (){
           var uid = window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr');
            $scope.promsg = null;
              $http({ 
             method: 'post',
             data:{user_id:uid,promocode:$scope.user.promo_code},   
             url:Base_URL+'api/promocodes/apipromocode'
           }).then(function successCallback(response) {              
             // console.log(response.data.data);   
                if(response.data.msg){          
                    $scope.promsg = response.data.msg;    
                  
                  }
             }, function errorCallback(response) { 
               console.log(response);
             });  
        }
      
      
        $scope.refundUser = function(id) {    
        if (window.confirm("Do you want to continue?"))
                $('#order_return').modal('show');   
            $scope.refund_id = id;
        } 
        
         $scope.orderrefund = function() { 
              var uid = window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr');
           $scope.refundmsg = null;
           $http({ 
           method: 'post',
           data:{order_id:$scope.refund_id,msg:$scope.return_msg,uid:uid},  
           url:Base_URL+'api/orders/refundorder' 
         }).then(function successCallback(response) {
            $scope.refundmsg = response.data.msg;   
        console.log(response.data);  
           }, function errorCallback(response) { 
             console.log(response);
           });
         } 
      
       if($state.is('user.orders')){    
            $rootScope.isLoading = true;  
               var uid = window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr');
                $http({ 
           method: 'post',
           data:{uid:uid}, 
           url:Base_URL+'api/users/userorder' 
         }).then(function successCallback(response) {      
        
               $scope.userorders =  response.data.order
               $rootScope.count_order =  response.data.count_order
                $rootScope.isLoading = false;  
           }, function errorCallback(response) { 
             console.log(response);
           });
    
    }      
    
     $scope.getClass = function (path) {    
      return ($location.path().substr(0, path.length) === path) ? 'active list-group-item' : 'list-group-item';
     }
    
//    if($state.is('user.orders')){
//        $scope.active ='orders';
//    }elseif()

    }).controller('homeController', ['$scope','$sce','$location','$interval' ,'$http', '$state','$rootScope','Base_URL','$localStorage', '$window','$stateParams', '$timeout', function($scope, $sce,$location,$interval,$http, $state,$rootScope,Base_URL,$localStorage,   $window, $stateParams, $timeout) {  
  
     
       if(window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr')!=null){
            $scope.loggedin=1;
       }else{
           $scope.loggedin=0; 
       }     
       

    var myParam = location.search.split('user_invitecode=')[1]  
       if(myParam != undefined && window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr')== null){  
           $('#mylogin').modal('show')  
           $rootScope.referral_code = myParam; 
           window.localStorage.setItem('invitereferral_code',myParam);     
       }else{
           
       }  
       
       
       ///////////star////////////   
        $scope.isReadonly = false; // default test value
    $scope.changeOnHover = false; // default test value
    $scope.maxValue = 10; // default test value
    $scope.ratingValue = 5; // default test value
       
           ///////signup////////// 

    $scope.authError = null;  
    $scope.usignup = function() {  
      $scope.authError = null; 
      // Try to create
      $http.post(Base_URL+'api/users/usersignup', {email: $scope.user.email,referral_code: $scope.referral_code})
      .then(function(response) { 
         // console.log(response); 
  
        if (!response.data.status) { 
          $scope.authError = response.data.msg;
        }else{
           localStorage.setItem('ZGV2ZWxvcGVyX3J1cGFr',response.data.uid); 
           $('#mylogin').modal('hide');   
         window.location.reload();     
        }
      }, function(x) {
        $scope.authError = 'Server Error';
      });
    };
     
    $scope.data={};
    $scope.data.isHome = '1'; 
     

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
  
       $http({
  method: 'GET',
  url:Base_URL+'api/settings/apisupport'
}).then(function successCallback(response) { 
    $rootScope.settings = response.data.data;            
  window.localStorage.setItem('btncolor',response.data.data.progress_btn_color); 
   // console.log(response.data.list);
  }, function errorCallback(response) { 
    console.log(response);
  }); 

       $http({
  method: 'GET',
  url:Base_URL+'api/products/catlist'
}).then(function successCallback(response) {
    $scope.catlist = response.data.list; 
   
   // console.log(response.data.list);
  }, function errorCallback(response) { 
    console.log(response);
  });      
      /////////////////search category data///////////////////////
      
       $scope.searchbyidbylink = function (id){ 
         if(id==1){
              $state.go('home'); 
         }else{ 
        $state.go('category.categorypage', {action:'cat', catid:id});
         }  
    // alert($scope.data.search);
      }
      
       if($stateParams.action=='cat'){
           var uid = window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr');
            $rootScope.isLoading = true;
                  $http({ 
  method: 'post',
  data:{catid:$stateParams.catid,uid:uid},
  url:Base_URL+'api/products/catbyid'
}).then(function successCallback(response) {   
// console.log(response.data.list);  
   $scope.productlistbycatlink = response.data.list;    
   $scope.cat_and_subcat = response.data.list;
    $rootScope.isLoading = false;
  }, function errorCallback(response) {   
    console.log(response);
  });

  $scope.currentcat = $stateParams.catid; 
  }      

       
       
      $scope.searchbyid = function (id){ 
        var uid = window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr');  
           $http({ 
  method: 'post',
  data:{catid:id,uid:uid},
  url:Base_URL+'api/products/catbyid'
}).then(function successCallback(response) {  
// console.log(response.data.list);   
   $scope.productlistbycat = response.data.list;   
  }, function errorCallback(response) {  
    console.log(response);
  });
     
      }  
      
      
      if($stateParams.action=='search'){         
             $http({ 
        method: 'post',
        data:{search:$stateParams.search},
        url:Base_URL+'api/products/search'
      }).then(function successCallback(response) {  
      // console.log(response.data.list);  
         $scope.productlistbycat = response.data.list; 
         if(response.data.list == null){ 
              $scope.msg = 'No Product Found!';
         }
        
        }, function errorCallback(response) { 
          console.log(response);
        });
    }
     
  $scope.searchcat = function (){   
      $scope.msg = null;
           $http({ 
        method: 'post',
        data:{search:$scope.data.search},
        url:Base_URL+'api/products/search'
      }).then(function successCallback(response) {   
      // console.log(response.data.list);  
         $scope.productlistbycat = response.data.list; 
         if(response.data.list == null){
              $scope.msg = 'No Product Found!';
         }
        
        }, function errorCallback(response) { 
          console.log(response);
        });
  }
  
    $scope.productdetail11 = function (){          

        var inactive = document.getElementsByClassName('inactive')[0].nextElementSibling.id;   
              $http({ 
             method: 'post',
             data:{id:inactive},
             url:Base_URL+'api/products/getproductbyid'
           }).then(function successCallback(response) {  
             // console.log(response.data.data);    
              $rootScope.productdetailc = response.data.data;
              $rootScope.test = []; 
              
               angular.forEach(response.data.all, function(value, key){ 
                     $rootScope.test.push(value.Product.id);    
               });
              $rootScope.allproduct = response.data.all;    
             }, function errorCallback(response) { 
               console.log(response);
             });  
     }
     
     
      $scope.selectaddress = function (id){
          
        window.localStorage.setItem('shipping_id',id) ;  
       $('#new-shipping-address').css('display', 'none');           
       $('#new-payment-method').css('display', 'block');      
      }
     $scope.addattribute = function (id){    
        
        window.localStorage.setItem('cart_product_attr_id',id) ;
        $('#new-shipping-address').css('display', 'block');    
      }
      
    $scope.productdetail = function (id){
          //$rootScope.isLoading = true;
       if(window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr') != null){
           
            $('#prodtdescr').modal('show');
      
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
                
           //   $rootScope.allproduct = response.data.all;    
              $rootScope.numberLoaded = true;

           $rootScope.numberLoaded = true;  
            $rootScope.number={}; 
           for(var i in response.data.all){
                 $rootScope.number[i]=response.data.all[i].Product.image; 
           } 
          
             }, function errorCallback(response) {     
               console.log(response);
             });  
          
       }else{
            $('#mysignup').modal('show');   
       }  
     
     } 

     
    
    $scope.numberUpdate = function(){
        $scope.numberLoaded = false; // disable slick

        //number update

        $scope.numberLoaded = true; // enable slick
    };

    
 $rootScope.slickConfig = {  
    enabled: true,
    autoplay: true,
    dots:true,
    draggable: false,  
    slidesToShow: 4,
    slidesToScroll: 4,
    autoplaySpeed: 3000,
    method: {},
    event: {
        beforeChange: function (event, slick, currentSlide, nextSlide) {     
        },
        afterChange: function (event, slick, currentSlide, nextSlide) {
        }
    }  
};


     
  var uid = localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr');    
     
     $scope.addtocart = function (id,cat,event){  
          // $(".loader").fadeOut("slow");   
      var cuurent_price = document.getElementById("price_"+id).getAttribute('price');  
             
         var uid = window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr');
         if(uid != null){
               $scope.msg = null;
           $http({ 
        method: 'post',
        data:{pid:id,uid:uid,price:cuurent_price},    
        url:Base_URL+'api/shop/apicart' 
      }).then(function successCallback(response) {    
    
         if(response.data.status){
               $('#prodtdescr').modal('hide'); 
            
              $scope.msg = response.data.msg; 
                 
       
         $http({ 
        method: 'post',
        data:{uid:uid,cat:cat},   
        url:Base_URL+'api/shop/displaycartqr'
      }).then(function successCallback(response) {       
         
         // $(".loader").fadeIn();  
          window.localStorage.setItem('cart_cat_id',response.data.data[1][0].Cart.cat_id) ;   
          window.localStorage.setItem('cart_pro_id',response.data.data[1][0].Cart.product_id) ; 
         $rootScope.cartprice = response.data.data[0].total           
         $rootScope.cartcatid = response.data.data[1][0].Cart.cat_id  
          $rootScope.cartdata = response.data.data; 
           
         var cartmyJSON = JSON.stringify(response.data.data);   
         
          localStorage.removeItem('cartdata');  
          window.localStorage.setItem('cartdata',cartmyJSON);   
          $rootScope.cart_attr = response.data.data_attr;  
          $rootScope.billingcountry = response.data.country;
         // $rootScope.billing.country  = 'United States';   
           test();  
        }, function errorCallback(response) { 
          console.log(response);
        });
        
          $('#pay-flow-modal').modal('show');  
          $('#select-payment-method').hide(); 
          $('#new-payment-method').hide(); 
          $('#new-shipping-address').hide(); 
          $('#select-credit-card-or-paypal').show(); 
         /////////////gift item//////////////////
             $http({ 
        method: 'post',
        data:{action:'giftitem'},   
        url:Base_URL+'api/products/giftitems'
      }).then(function successCallback(response) {       

          $rootScope.giftitems = response.data.data; 
          //console.log(response.data.data);  
        }, function errorCallback(response) { 
          console.log(response);
        });
       ///////////////cart user data//////////////////////////////  
            $http({ 
          method: 'post',
          data:{uid:uid},
          url:Base_URL+'api/users/userdata'
        }).then(function successCallback(response) {     
            $rootScope.cartuser = response.data.user.User; 
            $rootScope.cartuserinfo = response.data.userextrainfo;  
          }, function errorCallback(response) { 
            console.log(response);
          });
         
              
         }
        
        }, function errorCallback(response) { 
          console.log(response);
        });
         
     }else{ 
            $('#mysignup').modal('show');   
       } 
   }
       $scope.billing = {}; 
       
        $scope.editaddress = function(id){   
                $http({ 
               method: 'post',
               data:{id:id},   
               url:Base_URL+'api/addresses/getaddressById'
             }).then(function successCallback(data) {  
                 $scope.billing = data.data.data.Address; 
                 $('#edit-address-modal').modal('show');   
               }, function errorCallback(data) {     
                 console.log(data);
               });
        }
        $scope.useraddressupdate = function(){
                    $http({ 
                  method: 'post',
                  data:{first_name:$scope.billing.first_name,
                      last_name:$scope.billing.last_name,address1:$scope.billing.address1,
                      address2:$scope.billing.address2,country:$scope.billing.country,city:$scope.billing.city,
                      state:$scope.billing.state,zip:$scope.billing.zip,id:$scope.billing.id},    
                  url:Base_URL+'api/addresses/editaddress'
                }).then(function successCallback(response) {                
                     $scope.error = 'Address has been saved';
                     window.location.reload();
                  }, function errorCallback(response) {   
                    console.log(response);
                  }); 
  
        }
        
        $scope.userbillingaddress = function (){
            
              $scope.error = null; 
             
            if($scope.billing.first_name == undefined){   
                $scope.error = 'First name required';
                return false;
            }else if($scope.billing.address1 == undefined){
                  $scope.error = 'Address1 required';
                return false;
            }else if($scope.billing.city == undefined){
                   $scope.error = 'City required';
                return false;
            }else if($scope.billing.zip == undefined){
                $scope.error = 'Zip required';   
                return false; 
            }else{   
              var uid = window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr');
                    $http({ 
                  method: 'post',
                  data:{first_name:$scope.billing.first_name,
                      last_name:$scope.billing.last_name,address1:$scope.billing.address1,
                      address2:$scope.billing.address2,country:$scope.billing.country,city:$scope.billing.city,
                      state:$scope.billing.state,zip:$scope.billing.zip,uid:uid},    
                  url:Base_URL+'api/addresses/apiaddAddress'
                }).then(function successCallback(response) {               
                    //console.log(response.data); 
                     $scope.error = 'Address has been saved'; 
                     var myJSON = JSON.stringify(response.data.data.Address);
                     window.localStorage.setItem('billingaddress',myJSON); 
                  }, function errorCallback(response) {   
                    console.log(response);
                  }); 
                 
           $('#new-shipping-address').css('display', 'none');     
            $('#new-payment-method').css('display', 'block');
          
            }
//            var billingaddress = window.localStorage.getItem('billingaddress');
//             var obj = JSON.parse(billingaddress);
//          $scope.billingaddress = obj;     
         }
         
         
                $scope.gallery = function (event){
                   if(event.target.id =='video'){        
                       $('#bigimage').hide();
                       $('#showvideo').show(); 
                       $('#'+event.target.id).addClass('selected'); 
                   }else{  
                   $('#showvideo').hide();   
                   $('#bigimage').show(); 
                $('#bigimage').attr('src',event.target.src);
                $('#'+event.target.id).addClass('selected');   
            }
                }
                
        $scope.reminderadd = function (id,event){ 
 
                    var uid = window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr');
                   if(uid != null){
                         $scope.reminder = null;
                     $http({ 
                  method: 'post',
                  data:{pid:id,uid:uid},   
                  url:Base_URL+'api/products/reminderadd'
                }).then(function successCallback(response) {
                    //console.log(response.data); 
                   if(response.data.status){  
                       $('#'+event.target.id).removeClass('fa fa-heart-o'); 
                       $('#'+event.target.id).addClass('fa fa-heart');    
                        $scope.reminder = '1'; 
                        $scope.eid = event.target.id;
                   }else{    
                        $scope.reminder = '0';
                        $scope.eid = event.target.id; 
                   }

                  }, function errorCallback(response) { 
                    console.log(response);
                  });

               }else{ 
                      $('#mysignup').modal('show');   
                 }

        } 
 
 
  
  }]).directive("owlCarousel", function() {  
	return {
		restrict: 'E',
		transclude: false,
		link: function (scope) {
			scope.initCarousel = function(element) {
			  // provide any default options you want
				var defaultOptions = {
				};
				var customOptions = scope.$eval($(element).attr('data-options'));
				// combine the two options objects
				for(var key in customOptions) {
					defaultOptions[key] = customOptions[key];
				}
				// init carousel
				$(element).owlCarousel(defaultOptions);
			};
		}
	};
})
.directive('owlCarouselItem', [function() { 
	return {
		restrict: 'A',
		transclude: false,
		link: function(scope, element) {
		  // wait for the last item in the ng-repeat then call init
			if(scope.$last) {
				scope.initCarousel(element.parent());
			}
		}
	};
}]).filter("commaBreak",   

    function () {

        return function ( value ) {
                
               if (undefined !== value && value.length) {
                    return value.split(',');
                } else {
                   return false  
                }  
                
           // if( !value.length ) return; 

          //  return value.split(',');

        }  

}).controller('pagesController', ['$scope','$sce','$location','$interval' ,'$http', '$state','$rootScope','Base_URL','$stateParams', function($scope, $sce,$location,$interval,$http, $state,$rootScope,Base_URL, $stateParams) {
      
       if($state.is('pages.about')){
            $rootScope.isLoading = true;
         $http({
  method: 'GET',
  url:Base_URL+'api/staticpages/about_us'
}).then(function successCallback(data) {  
    //console.log(data.data);       
    $scope.aboutdetails= data.data.about;     
     $rootScope.isLoading = false; 
  }, function errorCallback(response) { 
    console.log(data);    
  });
       }
       
    if($state.is('pages.privacy')){
         $rootScope.isLoading = true;
         $http({
  method: 'GET',
  url:Base_URL+'api/staticpages/privacy'
}).then(function successCallback(data) {        
    $scope.privacydetails= data.data.privacy;
     $rootScope.isLoading = false; 
     
  }, function errorCallback(response) { 
    console.log(data);    
  });
       }
       
    if($state.is('pages.faq')){ 
         $rootScope.isLoading = true;
         $http({
  method: 'GET',
  url:Base_URL+'api/staticpages/faq'
}).then(function successCallback(data) {         
    $scope.faqdetails= data.data.faq; 
     $rootScope.isLoading = false;
     
  }, function errorCallback(response) {  
    console.log(data);    
  });
       }
 
       if($state.is('pages.buyerprotection')){
            $rootScope.isLoading = true;
         $http({
  method: 'GET',
  url:Base_URL+'api/staticpages/buyerprotection'
}).then(function successCallback(data) {        
    $scope.buyerprotectiondetails= data.data.buyerprotection;  
     $rootScope.isLoading = false;
     
  }, function errorCallback(response) { 
    console.log(data);    
  });
       }
       
        if($state.is('pages.buyer_terms')){  
             $rootScope.isLoading = true;
         $http({
         method: 'GET',
         url:Base_URL+'api/staticpages/buyer_terms'
       }).then(function successCallback(data) {        
           $scope.buyer_termsdetails= data.data.buyer_terms;
            $rootScope.isLoading = false;

         }, function errorCallback(response) {   
           console.log(data);    
         });
       }
       
        if($state.is('pages.authenticity_guarantee')){
             $rootScope.isLoading = true;
         $http({
         method: 'GET',
         url:Base_URL+'api/staticpages/authenticity_guarantee'
       }).then(function successCallback(data) {        
           $scope.authenticitydetails= data.data.authenticity_guarantee;    
            $rootScope.isLoading = false;

         }, function errorCallback(response) {      
           console.log(data);    
         });
       }
       
           if($state.is('pages.copyright')){ 
                $rootScope.isLoading = true;
         $http({
         method: 'GET',
         url:Base_URL+'api/staticpages/copyright'
       }).then(function successCallback(data) {        
           $scope.copyrightdetails= data.data.copyright; 
            $rootScope.isLoading = false;  

         }, function errorCallback(response) {         
           console.log(data);    
         });
       }
       $scope.contact = {};
       $scope.contactform = function(){  

           $scope.contactmsg = null;
        $http({
         method: 'POST',
         url:Base_URL+'api/staticpages/contact',
         data:{name:$scope.contact.name,email:$scope.contact.email,msg:$scope.contact.msg},
       }).then(function successCallback(data) {          
              $scope.contactmsg = data.data.msg; 
         }, function errorCallback(response) {      
           console.log(data);    
         });
       }  
        
}]);    
//.directive('slick', function($timeout) {      
//    return function(scope, el, attrs) { 
//        $timeout((function() {
//            el.slick({
//                arrows: true,
//                dots: true,
//                infinite: true,
//                autoplay: true,
//                autoplaySpeed: 6500,
//                speed: 1500,
//                slidesToShow: 1,
//                slidesToScroll: 1,
//                fade: true,
//                cssEase: 'linear'
//            })
//        }), 100) 
//    }
//});                                       