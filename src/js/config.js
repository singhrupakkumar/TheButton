// config

  app.constant("Base_URL","https://rupak.crystalbiltech.com/thebutton/")
  .run(function($timeout, $rootScope) {

  // Use a root scope flag to access everywhere in your app
  $rootScope.isLoading = true;

  // simulate long page loading
  $timeout(function() {  

    // turn "off" the flag
    $rootScope.isLoading = false;

  }, 3000)

})
.config(   
    [        '$controllerProvider', '$compileProvider', '$filterProvider', '$provide',
    function ($controllerProvider,   $compileProvider,   $filterProvider,   $provide) {  
        
        // lazy controller, directive and service
        app.controller = $controllerProvider.register;
       // app.directive  = $compileProvider.directive;
        app.filter     = $filterProvider.register;
       // app.factory    = $provide.factory;
       // app.service    = $provide.service;
        app.constant   = $provide.constant;
     //   app.value      = $provide.value;
    }
  ]).config(     
    ['$stateProvider', '$urlRouterProvider',  
     function ($stateProvider,   $urlRouterProvider) {           
       
         if(window.localStorage.getItem('ZGV2ZWxvcGVyX3J1cGFr') == null){       
           window.location = '#/'   
         }  
         $stateProvider
         .state('user', {
             url: '/user',
             template: '<div ui-view class="fade-in-right-big smooth"></div>'
         }) .state('user.profile', {
             url: '/profile',
             templateUrl: 'src/tpl/profile.html',
         }).state('user.reminder', { 
             url: '/reminder',
             templateUrl: 'src/tpl/reminder.html',
         }).state('user.unsubscribe', {   
             url: '/unsubscribe',
             templateUrl: 'src/tpl/notificationset.html',
         })
            .state('user.changepassword', {
             url: '/changepassword',
             templateUrl: 'src/tpl/changepassword.html' 
         }) .state('user.share_earn', {    
             url: '/share_earn',
             templateUrl: 'src/tpl/share_earn.html' 
         }).state('user.wallet', {    
             url: '/wallet',
             templateUrl: 'src/tpl/wallet.html'
         }).state('user.inbox', {     
             url: '/inbox',
             templateUrl: 'src/tpl/inbox.html'         
         }).state('user.invite', {   
             url: '/invite/:action/:sign',
             templateUrl: 'src/tpl/share_earn.html'
         })
           .state('home', {
             url: '/',
             templateUrl: 'src/tpl/home.html'
         }) .state('user.search', {  
             url: '/search/:action/:search',
             templateUrl: 'src/tpl/searchproduct.html'
         }).state('user.orders', {           
                url: '/orders',
             templateUrl: 'src/tpl/orders.html'
         }).state('user.manageaddress', {              
                url: '/manageaddress',
             templateUrl: 'src/tpl/manage_address.html'
         }).state('pages', {      
             url: '/pages',
             template: '<div ui-view class="fade-in-right-big smooth"></div>'
         }).state('pages.about', {    
             url: '/about', 
             templateUrl: 'src/tpl/about.html'
         }).state('pages.privacy', {       
             url: '/privacy', 
             templateUrl: 'src/tpl/privacy.html'
         }).state('pages.copyright', {       
             url: '/copyright', 
             templateUrl: 'src/tpl/copyright.html'
         }).state('pages.buyerprotection', {        
             url: '/buyerprotection', 
             templateUrl: 'src/tpl/buyerprotection.html'
         }).state('pages.buyer_terms', {          
             url: '/buyer_terms', 
             templateUrl: 'src/tpl/buyer_terms.html'
         }).state('pages.faq', {        
             url: '/faq', 
             templateUrl: 'src/tpl/faq.html'  
         }).state('pages.authenticity_guarantee', {          
             url: '/authenticity_guarantee', 
             templateUrl: 'src/tpl/authenticity_guarantee.html'  
         }).state('pages.contact', {                
             url: '/contact', 
             templateUrl: 'src/tpl/contact.html'  
         }).state('category', {    
             url: '/category',
             template: '<div ui-view class="fade-in-right-big smooth"></div>' 
         })
          .state('category.categorypage', {    
             url: '/categorypage/:action/:catid', 
             templateUrl: 'src/tpl/category.html'
         }) 
        .state('access', {
             url: '/access',
             template: '<div ui-view class="fade-in-right-big smooth"></div>'
         }).state('access.forgotpwd', {  
             url: '/forgotpwd',
             templateUrl: 'tpl/page_forgotpwd.html'
         })
             .state('access.404', {
             url: '/404',
             templateUrl: 'tpl/page_404.html'
         }) ;

$urlRouterProvider.otherwise('/');
       


     }
    ]
).config(['slickCarouselConfig', function (slickCarouselConfig) {
      slickCarouselConfig.dots = true;
      slickCarouselConfig.autoplay = false;
  }]);        