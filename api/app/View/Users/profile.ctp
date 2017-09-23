<!-------------Header Section Ends-----------------> 

<!-------------Container Section Ends----------------->

<div id="inner">
  <div class="container inner" style="min-height: 500px;">
    <div class="row">
      <?php echo $this->element('usersidebar'); ?>
      <div class="col-md-10">
        <div id="awning">
          <div class="page-header">
            <h1>Account Info</h1>
          </div>
        </div>
           <?php echo $this->Form->create('User', array('id' => 'editform','class'=>'form-horizontal jquery-validation')); ?>
           <input  name="data[User][username]" id="username1" value="<?php echo $data['User']['username']; ?>" type="hidden"/>
        
          <div class="form-group">
            <label class="control-label col-sm-2" for="user_name">Name</label>
            <div class="col-sm-6">
              <input class="form-control" id="name" placeholder="Please Enter Your Name" name="data[User][name]" value="<?php echo $data['User']['name']; ?>" type="text"/>   
             
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="user_email">Email</label>
            <div class="col-sm-6">
                
            <input class="form-control" id="email" placeholder="Enter Email" name="data[User][email]" value="<?php echo $data['User']['email']; ?>" type="email"/>     

            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="user_phone_number">Phone #</label>
            <div class="col-sm-6">
        <input class="form-control" id="phone" placeholder="Enter Your Phone" maxlength="10" name="data[User][phone]" value="<?php echo $data['User']['phone']; ?>" type="text"/>        

            </div>
            <div class="col-sm-4 text-muted">Your phone # is only used when you opt-in to receiving SMS reminders about items you are interested in bidding on. </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="user_Country">Country</label>
            <div class="col-sm-6">
           <input class="form-control" id="country" placeholder="Enter your Country" name="data[User][country]" value="<?php echo $data['User']['country']; ?>" type="text"/>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="user_Time Zone">Time zone</label>
            <div class="col-sm-6">
              <select class="form-control" name="data[User][time_zone]" id="user_time_zone">
                <option value="Hawaii">(GMT-10:00) Hawaii</option>
                <option value="Alaska">(GMT-09:00) Alaska</option>
                <option value="Pacific Time (US &amp; Canada)">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
                <option value="Arizona">(GMT-07:00) Arizona</option>
                <option value="Mountain Time (US &amp; Canada)">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                <option value="Central Time (US &amp; Canada)">(GMT-06:00) Central Time (US &amp; Canada)</option>
                <option value="America/Indianapolis">(GMT-05:00) America/Indianapolis</option>
                <option value="Eastern Time (US &amp; Canada)">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                <option value="Indiana (East)">(GMT-05:00) Indiana (East)</option>
                <option value="" disabled="disabled">-------------</option>
                <option value="American Samoa">(GMT-11:00) American Samoa</option>
                <option value="International Date Line West">(GMT-11:00) International Date Line West</option>
        
              </select>
            </div>
          </div>
          <div class="form-group"> 
            <div class="col-sm-6 col-sm-offset-2">
           <input name="submit" id="editsubmit" class="btn btn-primary btn-block" type="submit" value="Update"/>      
             
            </div>
          </div>
          <hr>
          <div class="form-group">
            <div class="col-sm-6 col-sm-offset-2">
              <div class="list-group"> <a class="list-group-item" href="/facebook/connect?return_to=%2Fusers%2Fprofile"><i class="fa fa-fw fa-facebook-square"></i> Connect Facebook </a><a class="list-group-item" href="/users/credit_cards"><i class="fa fa-fw fa-credit-card"></i> Manage payment methods </a><a class="list-group-item" href="/users/mailing_addresses"><i class="fa fa-fw fa-map-marker"></i> Manage addresses </a><a class="list-group-item" href="/users/change_password"><i class="fa fa-fw fa-lock"></i> Change password </a><a class="list-group-item" href="/users/unsubscribe"><i class="fa fa-fw fa-envelope"></i> Email preferences </a><a class="list-group-item" href="/users/cancel"><i class="fa fa-fw fa-times"></i> Cancel account </a></div>
            </div>
          </div>
       <?php echo $this->Form->end(); ?>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">      
jQuery(document).ready(function() {
   
      var useredit = $("#editform").validate({ 
	errorClass: "my-error-class",
   	validClass: "my-valid-class", 
        rules: {
              zip : { 
                 number: true
                  } 
                 ,"data[User][phone]" : {  
                 number:true,
                 required:true,
                minlength: 10,
                maxlength: 10
                  } ,
                  "data[User][country]":{  
                 lettersonly:true 
                  }
				  
        },
        messages: {

                "data[User][phone]": {  
                    required: "Please enter valid number(10 digits)",  
                }, "data[User][country]": {  
                    required: "Please enter valid country name", 
                }
        }
    });

        $('#editsubmit').on('click', function (event) {
           
                if(useredit.form()){ 
                    $('#editform').submit();
                } else {  
                    return false;  
                }
            event.preventDefault();     
         });
//var email = $("#email").val();
//var state = $("#state").val();
//var username1 = $("#username1").val();
//var edob = $("#edob").val();
//var egender = $("#egender").val(); 
//var name = $("#name").val();
//var zip = $("#zip").val();
//var phone = $("#phone").val();
//var city = $("#city").val(); 
//var address1 = $("#address1").val(); 
//var country = $("#country").val(); 
//// Returns successful data submission message when the entered information is stored in database.
//var dataString = 'data[User][name]='+ name+ '&data[User][zip]='+ zip+ 
//        '&data[User][city]='+ city+ '&data[User][address]='+ address1+
//        '&data[User][username]='+ username1+ '&data[User][email]='+ email+  
//        '&data[User][state]='+ state+ '&data[User][phone]='+ phone+ '&data[User][country]='+
//        country+ '&data[User][dob]='+ edob+ '&data[User][gender]='+ egender;    
// 
//// AJAX Code To Submit Form.   
//$.ajax({ 
//type: "POST", 
//url: "<?php echo $this->webroot; ?>users/edit", 
//data: dataString,
//cache: false,
//success: function(result){
//    if(result){
//      alert('Your profile has been Updated.'); 
// window.location = '<?php echo $this->webroot."users/profile"; ?>'; 
//   
//    } 
//
//}
//});
//
//return false;


  });


</script> 

<!-------------Container Section Ends-----------------> 