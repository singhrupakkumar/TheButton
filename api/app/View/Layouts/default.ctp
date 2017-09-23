<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/x-icon" href="<?php echo $this->webroot."home/images/fav-icon.png";?>" />
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title><?php echo $title_for_layout ." | The Button App-"; ?></title>

<!-- Bootstrap -->
<link href="<?php echo $this->webroot."home/";?>css/bootstrap.min.css" rel="stylesheet">

<!-- custom style -->
<link href="<?php echo $this->webroot."home/";?>css/style.css" rel="stylesheet">

<!-- Font asom -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <?php  echo $this->App->js(); ?> 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script> 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.1.0/jquery.form.js"></script>  

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<style>
#progressbar {
	position: fixed;
	left: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('<?php echo $this->webroot; ?>/home/images/progress.gif') 50% 50% no-repeat rgb(249,249,249);
}		

	</style>	
<script type="text/javascript">
$(window).load(function() {
	$("#progressbar").fadeOut("slow");
})
</script>
</head>

<body>
    
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1735134643181693',
      cookie     : true,
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();   
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
 <?php
 $pageTitle = $this->fetch('title'); 
        if ($this->fetch('title')=='Live Events') {
            ?>    
<!--div id="progressbar"></div-->
        <?php }?>
<!---------Header------------->

<header>
  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button class="navbar-toggle" data-target="#navbar-collapse" data-toggle="collapse" type="button"> <span class="sr-only">Menu</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a class="navbar-brand" href="<?php echo $this->webroot ;?>"><!-- <img alt="Logo" src="#" height="34">--> LOGO</a>
      </div>
       <div class="navbar-left visible-lg" id="navbar-search">  
           <form action="<?php echo $this->webroot; ?>products/search" method="get">  
          <div class="input-group">
            <input autocomplete="off" class="form-control" name="search" placeholder="Search..." type="text">
            <span class="input-group-btn">
            <button class="btn btn-primary btn-lg" type="submit"> <span class="fa fa-search"></span> </button>
            </span> </div>
        </form>
      </div>  
      <ul class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li> <a href="#"> <i class="fa fa-gift"></i> Sell </a> </li>
          <li> <a href="#"><i class="fa fa-home"></i> Home </a></li>
           <?php if (empty($loggeduser)){ ?>
          <li><a href="#myModals" data-toggle="modal" data-target="#loginModal">LOGIN</a></li>
          <li class="dropdown"> <a class="dropdown-toggle sign-up" href="#signupModal" data-toggle="modal" data-target="#signupModal">Sign Up Now - It's Free!</a> </li>
          <?php } else { ?>
            <li><a href="<?php echo $this->webroot."users/profile" ;?>"><i class="fa fa-user"></i> Account</a></li> 
               <?php } $odr_cnt = $this->Session->read('Shop');
               $shop_cnt = count($odr_cnt['OrderItem']); ?>
          <li> <a href="#"> <i class="fa fa-question-circle"></i> Tutorial </a> </li>
        </ul>
      </ul>
    </div>
  </nav>
</header>

<!-------------Header Section Ends----------------->

<!-------------Container Section Ends----------------->

<div id="slot-client">
    <div id="main">
         
  <?php
 $ontrol = $this->params['controller'];
  if (!empty($loggeduser) && $ontrol !='users'){ ?>  
   <div class="container" style="min-height: 500px;">      
 <div class="catalog-navigation hidden-xs">
       
     <?php
     $count = 0;
     foreach($categorylist as $cat) :
      
         if($count == 1){ echo '<span class="text-muted">|</span>'; }
         ?>
     <a href="<?php echo $this->webroot."categories/view/".$cat['Category']['slug'];?>" class="<?php  if(isset($cat_slug) && $cat_slug== $cat['Category']['slug']){ echo "active"; }; ?>"> <?php echo $cat['Category']['name'];?></a>
     <?php 
        $count++; 
     endforeach;?>
 </div>    
    
<?php
  }

      $x = $this->Session->flash(); 
           if($x)
           {
               echo $x;  
           }  
 echo $this->fetch('content');
 ?>     
     </div>   
  </div>   

</div>

<!-------------Container Section Ends----------------->

<!-----------Footer Section------------->



<div id="footer-wrapper">
  <div class="container">
    <div class="hidden-xs">
      <div class="row footer-bs3 desktop">
        <div class="col-sm-3">
            <a href="<?php echo $this->webroot ;?>"><h3>Logo</h3></a>
          
        </div>
        <div class="col-sm-2">
          <div class="footer-about">
            <h3>About Us</h3>
            <ul>
              <li> <a href="<?php echo $this->webroot."staticpages/about"; ?>">About</a> </li>
              <li> <a href="/team">Team</a> </li>
              <li> <a href="/careers">Careers</a> </li>
              <li> <a href="/privacy">Privacy</a> </li>
              <li> <a href="/reviews">Logo Reviews</a> </li>
              <li> <a href="/copyright">Copyright Policy</a> </li>
            </ul>
          </div>
        </div>
        <div class="col-sm-3">
          <h3>Customer Support</h3>
          <ul>
            <li> <b> <a class="btn btn-primary btn-round bottom10 contact_btn" href="<?php echo $this->webroot."staticpages/contact_us"; ?>">CONTACT US</a> </b> </li>
            <li> <a href="<?php echo $this->webroot."staticpages/faq"; ?>">View FAQs</a> </li>
            <li> <a href="/topics/Buying/subtopics/Buyer%20Issues/questions/Authenticity%20Guarantee">Authenticity Guarantee</a> </li>
            <li> <a href="/topics/Buying/subtopics/Buyer%20Issues/questions/Is%20there%20Buyer%20Protection%3F">Buyer Protection</a> </li>
            <li> <a href="<?php echo $this->webroot."staticpages/term_conditon"; ?>">Buyer Terms of Use</a> </li>
          </ul>
        </div>
        <div class="col-sm-2 text-right">
          <div class="footer-mobile">
            <h3>Mobile Apps</h3>
            <ul>
              <li class="bottom5"> <a href="https://itunes.apple.com/app/id619460348"><img src="https://dffab9emdo6jt.cloudfront.net/assets/app/app-ios_small-1101c20ae339aeaa5b195725bd71e91d5024f1d1d82043dbd6899730cff777bb.png"> </a></li>
              <li> <a href="https://play.google.com/store/apps/details?id=com.Logo"><img src="https://dffab9emdo6jt.cloudfront.net/assets/app/app-droid_small-3e0f6ebc254d5dea52bc6cb6e831225f33d44892ae42d5eba18e28f6638bf792.png"> </a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-2 text-right">
          <h3>Social</h3>
          <ul>
            <li> <a href="https://www.facebook.com/Logo" target="_social">Facebook</a> <span class="fa fa-facebook-square"></span> </li>
            <li> <a href="https://twitter.com/Logo" target="_social">Twitter</a> <span class="fa fa-twitter"></span> </li>
            <li> <a href="http://www.pinterest.com/Logo" target="_social">Pinterest</a> <span class="fa fa-pinterest"></span> </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="visible-xs-block">
      <div class="row icons">
        <div class="col-xs-3"> <a href="https://itunes.apple.com/app/id619460348"> <span class="fa fa-apple"></span> </a> </div>
        <div class="col-xs-3"> <a href="https://play.google.com/store/apps/details?id=com.Logo"> <span class="fa fa-android"></span> </a> </div>
        <div class="col-xs-3"> <a href="https://www.facebook.com/300664329976860"> <span class="fa fa-facebook-square"></span> </a> </div>
        <div class="col-xs-3"> <a href="https://twitter.com/Logo"> <span class="fa fa-twitter"></span> </a> </div>
      </div>
      <hr>
      <div class="row footer-bs3 mobile">
        <div class="col-xs-5">
          <div class="footer-about">
            <h3>About Us</h3>
            <ul>
              <li> <a href="/about">About</a> </li>
              <li> <a href="/team">Team</a> </li>
              <li> <a href="/careers">Careers</a> </li>
              <li> <a href="/privacy">Privacy</a> </li>
              <li> <a href="/reviews">Logo Reviews</a> </li>
              <li> <a href="/copyright">Copyright Policy</a> </li>
            </ul>
          </div>
        </div>
        <div class="col-xs-7 text-right">
          <h3>Customer Support</h3>
          <ul>
            <li> <b> <a class="btn btn-primary btn-round bottom10" href="/support/address">CONTACT US</a> </b> </li>
            <li> <a href="/topics">View FAQs</a> </li>
            <li> <a href="/topics/Buying/subtopics/Buyer%20Issues/questions/Authenticity%20Guarantee">Authenticity Guarantee</a> </li>
            <li> <a href="/topics/Buying/subtopics/Buyer%20Issues/questions/Is%20there%20Buyer%20Protection%3F">Buyer Protection</a> </li>
            <li> <a href="/terms">Buyer Terms of Use</a> </li>
          </ul>
        </div>
      </div>
      <hr>
      <div class="row footer-bs3 mobile">
        <div class="col-xs-6">
          <h3>Selling on Logo</h3>
          <ul>
            <li> <b> <a class="btn btn-primary btn-round bottom10" href="/sellers/onboarding/start">SELL NOW</a> </b> </li>
            <li> <a href="https://medium.com/Logo-sellers" target="_blank">Seller Hub</a> </li>
            <li> <a href="/topics/Selling/subtopics">Help &amp; Support</a> </li>
            <li> <a href="https://Logo.readme.io/v1/docs" target="_blank">Merchant API</a> </li>
            <li> <a href="/seller_terms">Seller Terms of Use</a> </li>
          </ul>
        </div>
        <div class="col-xs-6 text-right">
          <div class="footer-mobile">
            <h3>Mobile Apps</h3>
            <ul>
              <li class="bottom5"> <a href="https://itunes.apple.com/app/id619460348"><img src="https://dffab9emdo6jt.cloudfront.net/assets/app/app-ios_small-1101c20ae339aeaa5b195725bd71e91d5024f1d1d82043dbd6899730cff777bb.png"> </a></li>
              <li> <a href="https://play.google.com/store/apps/details?id=com.Logo"><img src="https://dffab9emdo6jt.cloudfront.net/assets/app/app-droid_small-3e0f6ebc254d5dea52bc6cb6e831225f33d44892ae42d5eba18e28f6638bf792.png"> </a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-----------Footer Section Ends-------------> 
<!-----------------------Login Section Starts------------------------->

<!-- Modal -->
<div id="signupModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-body">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
      <div id="sign-up">
<h1>Logo</h1>
<div class="center-block text-center">
<div class="h5">ITEMS SELL IN 90 SECONDS!</div>
<div class="h5 text-muted">10 million shoppers &amp; counting</div>
<div class="h5">“Loved everything I ordered, items were amazing.”</div>
<div class="h5 text-muted">
—
Brenda from Virginia, July 2017
</div>
</div>
<?php echo $this->Form->create('User', array('url'=>array('controller' => 'users','action' => 'add'),array('class' => 'jquery-validation','id'=>'UserIndexForm'))); ?>
<input type="hidden" name="server" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="form-group">
<input autocomplete="off" class="form-control" id="email" placeholder="Email" name="data[User][email]" required title="Not a valid email." aria-required="true" type="email">
</div>
<div class="form-group">
<button class="btn btn-primary btn-block " id="signupbtn"  type="submit">Sign Up</button>
</div>
<div class="row" style="border-bottom: 1px solid #ccc; padding: 0 0 10px;">
<div class="col-xs-12">
<span class="text-muted">
Or, sign up using <a class="text-muted" href="javascript:void(0)" style="position: relative; top: 6px; color: #3b5998;">
<fb:login-button 
  scope="public_profile,email"
  onlogin="checkLoginState();">
</fb:login-button>
</a>
 or <a class="text-muted" href="<?php echo $authUrl; ?>"  style="position: relative; top: 6px; color: #dd4b39;">
<span class="fa fa-google-plus-square fa-2x left5 right5"></span>
</a>

</span>
</div>
</div>

<div class="top5">
<div class="clearfix">
<div class="pull-right">
<a class="text-muted" href="#loginModal" onclick="" data-dismiss="modal" aria-hidden="true" role="button" data-toggle="modal" data-target="#loginModal">
Sign In
<span class="fa fa-caret-right"></span>
</a>
</div>
</div>
</div>
 <?php 
 echo $this->Form->end();
 
 ?>
</div>
      </div>
      
    </div>

  </div>
</div>

<!-----------------------Login Section End------------------------->

  <!----------login-modal------------->
  <!-- Modal -->
<div id="loginModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-body">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
      <div id="sign-up">
<h1>Logo</h1>

<?php echo $this->Form->create('User', array('url'=>array('controller' => 'users','action' => 'login'))); ?>
<input name="subscriber_id" id="sign-in-subscriber-id" class="subscriber-id" type="hidden">
<div class="form-group"> 
<input autocomplete="off" autofocus="autofocus" class="form-control valid" name="data[User][username]" placeholder="Email" required="required" title="Not a valid email." aria-required="true" type="email">
</div>
<div class="form-group">
<input class="form-control" name="data[User][password]" placeholder="Password" required="required" aria-required="true" type="password">
 <input type="hidden" name="server" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
</div>
<div class="form-group">
  <?php
   echo $this->Form->submit('Sign In', array('class'=>'btn btn-primary btn-block signup')); 
  ?>   
</div>
<div class="row" style="border-bottom: 1px solid #ccc; padding: 0 0 10px;">
<div class="col-xs-12">
<span class="text-muted">
Or, sign in using <a class="text-muted" href="javascript:void(0);" id="facebook" style="position: relative; top: 6px; color: #3b5998;">
<fb:login-button 
  scope="public_profile,email"
  onlogin="checkLoginState();">
</fb:login-button>
</a>
 or <a class="text-muted" data-destination="https://tophatter.com/" href="<?php echo $authUrl; ?>"  style="position: relative; top: 6px; color: #dd4b39;">
<span class="fa fa-google-plus-square fa-2x left5 right5"></span>
</a>

</span>
</div>
</div>

<div class="top5">
<div class="clearfix">
<div class="pull-left">
<a class="text-muted" href="#forgotModal" data-dismiss="modal" data-toggle="modal" data-target="#forgotModal" role="button">
Reset Password
<span class="fa fa-undo"></span>
</a>
</div>
<div class="pull-right">
<a class="text-muted" href="#signupModal" onclick="" data-dismiss="modal" aria-hidden="true" role="button" data-toggle="modal" data-target="#signupModal">
Sign Up
<span class="fa fa-caret-right"></span>
</a>
</div>
</div>
</div>
  <?php
  echo $this->Form->end();
  ?>
</div>
      </div>
      
    </div>

  </div>
</div>
  
 <!----------forgot password-modal------------------------>
  <div class="modal fade" id="forgotModal" class="modal fade" role="dialog">
 <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal_uper">
        <h4>Logo</h4>
       
      	</div>
      <div class="modal-body cvr_bdy">
        <?php echo $this->Form->create('User', array('url'=>array('controller' => 'users','action' => 'forgetpwd'))); ?>
        
     <div class="icon_lft">
        <i class="fa fa-envelope" aria-hidden="true"></i>
    <div class="form-group">
      <input type="hidden" name="server" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
      <input type="email" class="form-control" id="email" placeholder="Email" name="data[User][username]" required="required">
    </div>
    </div>
    <?php
   echo $this->Form->submit(__('Forgot',true), array('class'=>'btn btn-default sign_mrtn')); 
  echo $this->Form->end();
  ?>
      </div>
      <div class="modal-footer">
         <a href="#loginModal" data-dismiss="modal" data-toggle="modal" data-target="#loginModal" role="button">Back</a> 
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?php echo $this->webroot."home/";?>js/bootstrap.min.js"></script>
<?php echo $this->Html->script('oauthpopup');  ?>  
  <script type="text/javascript">
    $(document).on('ready', function() {
                $.validator.addMethod("lettersonly", function(value, element) {  
                return this.optional(element) || /^[a-zA-Z\s]*$/.test(value);         
              }, "Letters only please"); 
   
      
    });
    
  
function checkLoginState() {
  FB.getLoginStatus(function(response) {
      console.log(response);
   // statusChangeCallback(response);
    testAPI()
  });
}

 function testAPI() {

    FB.api('/me?fields=id,email,name,birthday,locale,age_range,picture,gender,first_name,last_name', function(response) {  

        $.post('<?php echo $this->webroot;?>users/facebook_connect',
        {
           myid: response,
           action:'fblogin'
         }, 
         function(data, status){
           console.log(  JSON.parse(data));
           window.location.href='<?php echo $base_url;?>';
         });
      
    });

  }
  </script>
</body>
</html>    