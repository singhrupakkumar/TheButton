<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo "The Button App"; ?></title>
        <link rel="icon" type="image/x-icon" href="<?php echo $this->webroot."home/images/android-icon-36x36.png";?>" />
        <?php echo $this->Html->css(array('bootstrap.min.css','//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css','//cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css','dist/css/AdminLTE.min.css', 'dist/css/skins/_all-skins.min.css','bootstrap3-wysihtml5.min.css')); ?>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

        <?php echo $this->Html->script(array('bootstrap.min.js', 'admin.js','../css/dist/js/app.min.js')); ?>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css"/>

            <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
            <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script> 
       
        <?php echo $this->App->js(); ?>

        <?php echo $this->fetch('css'); ?>
        <?php echo $this->fetch('script'); ?>
            <style>
                .error-message{
                    color: red;
                    font-weight: bold;
                }
            </style>   
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <!-- Header Bar starts here -->
            <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php if($authUser['image']){
                    $image_url = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $authUser['image'];
                }else{
                    $image_url=FULL_BASE_URL . $this->webroot . "files/profile_pic/no_img.png";
                } ?>
              <img src="<?php echo $image_url; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $loggedusername; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                   <?php if($authUser['image']){
                    $image_url = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $authUser['image'];
                }else{
                    $image_url=FULL_BASE_URL . $this->webroot . "files/profile_pic/no_img.png";
                } ?>
              <img src="<?php echo $image_url; ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $authUser['name'];?>
                  <small>Member since <?php echo date("M Y", strtotime($authUser['created'])); ?></small>
                </p>
              </li>

              <li class="user-footer">
                <div class="pull-left">
                    <?php echo $this->Html->link('Profile', array('controller' => 'orders', 'action' => 'myaccount', 'admin' => true), array('class' => 'btn btn-default btn-flat')); ?>
               
                </div>
                <div class="pull-right">
                    <?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout', 'admin' => true), array('class' => 'btn btn-default btn-flat users_autorizemenu1')); ?>
               
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
            <!-- header bar ends here -->
            
    <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
             <?php if($authUser['image']){
                    $image_url = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $authUser['image'];
                }else{
                    $image_url=FULL_BASE_URL . $this->webroot . "files/profile_pic/no_img.png";
                } ?>
              <img src="<?php echo $image_url; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $loggedusername; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
<!--      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>-->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active"><?php echo $this->Html->link('<i class="fa fa-tachometer"></i> <span>Dashboard</span>', array('controller' => 'dashboards', 'action' => 'index', 'admin' => true), array('class' => 'orders_autorizemenu','escape'=>false)); ?></li>
        
         <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-bag"></i> <span>Products</span> 
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><?php echo $this->Html->link('List Products', array('controller' => 'products', 'action' => 'index', 'admin' => true), array('class' => 'restaurants_autorizemenu')); ?></li>
            <?php if($loggedin['role']=='admin'){ ?>
                <li><?php echo $this->Html->link('Add Products', array('controller' => 'products', 'action' => 'add', 'admin' => true), array('class' => 'addrestaurants_autorizemenu')); ?></li>
                <li><?php echo $this->Html->link('Import Products', array('controller' => 'products', 'action' => 'csvimport', 'admin' => true), array('class' => 'addrestaurants_autorizemenu')); ?></li>
            <?php } ?> 
          </ul>
        </li>
        
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-tags"></i> <span>Categories</span> 
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><?php echo $this->Html->link('List Categories', array('controller' => 'categories', 'action' => 'index', 'admin' => true), array('class' => 'restaurants_autorizemenu')); ?></li>
            <?php if($loggedin['role']=='admin'){ ?>
                <li><?php echo $this->Html->link('Add Category', array('controller' => 'categories', 'action' => 'add', 'admin' => true), array('class' => 'addrestaurants_autorizemenu')); ?></li>
            <?php } ?>
          </ul>
        </li>
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-th-list"></i> <span>Attribute</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><?php echo $this->Html->link('Colors', array('controller' => 'colours', 'action' => 'index', 'admin' => true), array('class' => 'restaurants_autorizemenu')); ?></li>
            <?php if($loggedin['role']=='admin'){ ?>
                <li><?php echo $this->Html->link('Sizes', array('controller' => 'sizes', 'action' => 'index', 'admin' => true), array('class' => 'addrestaurants_autorizemenu')); ?></li>
            <?php } ?>
          </ul>
        </li>
        <li><?php echo $this->Html->link('<i class="fa fa-gift"></i> <span>Gift Items</span>', array('controller' => 'products', 'action' => 'giftitem', 'admin' => true), array('class' => 'orders_autorizemenu','escape'=>false)); ?></li> 
     
       <?php  if($loggedUserRole!='rest_admin'){  ?>     
      <li class="treeview">
          <a href="#">
            <i class="fa fa-file-text"></i> <span>Pages</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active">
                <?php echo $this->Html->link('Informational Pages', array('controller' => 'staticpages', 'action' => 'informational', 'admin' => true), array('class' => 'restaurants_autorizemenu')); ?>
            </li>
			<li>
                <?php echo $this->Html->link('Copyright', array('controller' => 'staticpages', 'action' => 'copyrightindex', 'admin' => true), array('class' => 'staticpages_autorizemenu')); ?>
             </li>
			<li>
                <?php echo $this->Html->link('FAQ', array('controller' => 'staticpages', 'action' => 'faqindex', 'admin' => true), array('class' => 'staticpages_autorizemenu')); ?>
             </li>
          </ul>
        </li>
        <?php } ?>
          
        <li><?php echo $this->Html->link('<i class="fa fa-first-order"></i> <span>Orders</span>', array('controller' => 'orders', 'action' => 'index', 'admin' => true), array('class' => 'orders_autorizemenu','escape'=>false)); ?></li>
         <li><?php echo $this->Html->link('<i class="fa fa-first-order"></i> <span>Bot Reports</span>', array('controller' => 'orders', 'action' => 'botreports', 'admin' => true), array('class' => 'orders_autorizemenu','escape'=>false)); ?></li>
         <li><?php echo $this->Html->link('<i class="fa fa-first-order"></i> <span>Return Orders</span>', array('controller' => 'orders', 'action' => 'returnorder', 'admin' => true), array('class' => 'orders_autorizemenu','escape'=>false)); ?></li>
     
            
            <li class="treeview">
                <a href="#">
                  <i class="fa fa-calendar"></i> <span>Event Manager</span>  
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">    
                  <li class="active"><?php echo $this->Html->link('Event List', array('controller' => 'eventschedulers', 'action' => 'index', 'admin' => true), array('class' => 'users_autorizemenu')); ?></li>
                  <li><?php echo $this->Html->link('Add Event', array('controller' => 'eventschedulers', 'action' => 'add', 'admin' => true), array('class' => 'users_autorizemenu')); ?></li>
                </ul>
            </li>
     
            <li class="treeview">
                <a href="#">
                  <i class="fa fa-user"></i> <span>Users</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="active"><?php echo $this->Html->link('Users List', array('controller' => 'users', 'action' => 'index', 'admin' => true), array('class' => 'users_autorizemenu')); ?></li>
                  <li><?php echo $this->Html->link('Add User', array('controller' => 'users', 'action' => 'add', 'admin' => true), array('class' => 'users_autorizemenu')); ?></li>
                </ul>
            </li>

        <li class="treeview">
            <a href="#">
              <i class="fa fa-code"></i> <span>Promocodes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="active"><?php echo $this->Html->link('Promocodes List', array('controller' => 'promocodes', 'action' => 'index', 'admin' => true), array('class' => 'users_autorizemenu')); ?></li>
              <li><?php echo $this->Html->link('Add Promocodes', array('controller' => 'promocodes', 'action' => 'add', 'admin' => true), array('class' => 'users_autorizemenu')); ?></li>
            </ul>
        </li>
        <li><?php // echo $this->Html->link('<i class="fa fa-envelope-open"></i> <span>Reviews</span>', array('controller' => 'restaurantsReview', 'action' => 'index', 'admin' => true), array('class' => 'settings','escape'=>false)); ?></li>
        <?php  if($loggedUserRole!='rest_admin'){  ?>
        <li><?php // echo $this->Html->link('<i class="fa fa-envelope-open"></i> <span>Disputes</span>', array('controller' => 'disputes', 'action' => 'index', 'admin' => true), array('class' => 'settings','escape'=>false)); ?></li>
       
          
        <!--<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>Promocodes</span>', array('controller' => 'promocodes', 'action' => 'index', 'admin' => true), array('class' => 'settings','escape'=>false)); ?></li>-->
        <!--<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>Pages</span>', array('controller' => 'staticpages', 'action' => 'index', 'admin' => true), array('class' => 'settings','escape'=>false)); ?></li>-->
        <li><?php echo $this->Html->link('<i class="fa fa-cog"></i> <span>Settings</span>', array('controller' => 'settings', 'action' => 'index', 'admin' => true), array('class' => 'settings','escape'=>false)); ?></li>
        <?php } ?> 
<!--        <li><?php //echo $this->Html->link('My Profile', array('controller' => 'orders', 'action' => 'myaccount', 'admin' => true), array('class' => 'users_autorizemenu1')); ?></li>               
        <li><?php //echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout', 'admin' => true), array('class' => 'users_autorizemenu1')); ?></li>-->
                        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>        
            
         
                <div class="content-wrapper">
                    <section class="content"> 
                        <?php echo $this->Session->flash(); ?>
                        <?php echo $this->fetch('content'); ?>
                    </section>
                </div>
            <!--</div>-->
            <!-- /#page-content-wrapper -->

        </div>
        <footer class="main-footer">
            <p>&copy; <?php echo date('Y'); ?> <?php echo env('HTTP_HOST'); ?></p>
        </footer>

<!--        <div class="sqldump">
        </div> -->
         <script src="<?php echo $this->webroot; ?>home/js/customcheckall.js"></script>
        <script src="<?php echo $this->webroot; ?>home/js/addtocart.js"></script>
        <script>
            $(document).ready(function () {
                var trigger = $('.hamburger'),
                        overlay = $('.overlay'),
                        isClosed = false;

                trigger.click(function () {
                    hamburger_cross();
                });

                function hamburger_cross() {

                    if (isClosed == true) {
                        overlay.hide();
                        trigger.removeClass('is-open');
                        trigger.addClass('is-closed');
                        isClosed = false;
                    } else {
                        overlay.show();
                        trigger.removeClass('is-closed');
                        trigger.addClass('is-open');
                        isClosed = true;
                    }
                }

                $('[data-toggle="offcanvas"]').click(function () {
                    $('#wrapper').toggleClass('toggled');
                });
            });
            $("#dishcatname").change(function () {
                var a = $(this).val();
                $.post("http://rajdeep.crystalbiltech.com/thoag/admin/products/getsubcat", {'id': a}, function (d) {
                    var html = '';
                    var data = jQuery.parseJSON(d);
                    console.log(data);
                    for (var key in data) {
                        html += '<option value="' + key + '">' + data[key] + '</option>';
                    }
                    jQuery('#dishsubcatname').html('');
                    jQuery('#dishsubcatname').html(html);
                });
            });
            $( "#dishcatname" ).trigger( "change" );

        </script>
<?php //print_r($authocss);  ?>
<?php //print_r($controllerLists);  ?>
<?php echo $this->Html->css(array('dist/css/custom_css')); ?>
<?php echo $this->Html->script(array('//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js')); ?>
 <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.1.6/tinymce.min.js"></script>

    <script type="text/javascript">
    tinymce.init({
selector: 'textarea',
plugins: [
"code", "charmap", "link"
],
toolbar: [
"undo redo | styleselect | bold italic | link | alignleft aligncenter alignright | charmap code" | "media"
]
});
    </script>  
    </body>
</html>