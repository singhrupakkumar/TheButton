<div class="con_main pass_gap share_form">
  <div class="container">
    <div class="edit">
      <h2>
        <figure class="form-logo">
          <img src="<?php echo $this->webroot."home/";?>images/thoag-logo.png" alt="" >
        </figure>
        <span class="form_head">Welcome</span>
        <p class="heading">Please sign up to see our Caterers, Menus and Thoag Values.</p>
      </h2>
      <div class="col-sm-9 col-center">
        <div class="edit_box">
          <form class="form-horizontal" id="sharecode">
            <div class="form-group">
              <div class="msg" style="color:red;"></div>
              <input class="form-control" autocomplete="off" id="email1" name="data[User][email]" placeholder="Email Address" type="email" required>
            </div>
            <div class="form-group">
              <div class="radio_sec">
                <label>Gender</label>
                <ul id="lby-checkbox-demo">      
                  <li>
                    <input class="jquery-checkbox-label synch-icon" id="gender1" name="data[User][gender]" value="male" type="radio" data-labelauty="Male" checked/>
                  </li>
                  <li>
                    <input class="jquery-checkbox-label terms-icon" id="gender2" name="data[User][gender]" value="female" type="radio" data-labelauty="Female"/>
                  </li>
                </ul>
              </div>
            </div>
            <div class="form-group">
              <input class="form-control" autocomplete="off" id="dob" name="data[User][dob]" placeholder="Date of Birth" type="text" required>
            </div>
            <div class="form-group">
              <input class="form-control field" autocomplete="off" id="contact" maxlength="10" name="phone" placeholder="Mobile Number" type="text" required>
            </div>
            <div class="form-group">
              <input class="form-control" autocomplete="off" id="password1" name="password" placeholder="Password" type="password"> 
            </div>
            <div class="form-group">
              <input class="form-control" autocomplete="off" name="data[User][cpassword]" id="password2" placeholder="Confirm Password" type="password">
            </div>
            <div class="form-group">
              <div class="refer" style="color:red;"></div> 
              <input class="form-control" value="<?php if(isset($code)){ echo $code; } ?>" autocomplete="off" id="referral_code" name="data[User][referral_code]" placeholder="Enter you friend's Referrral Code (Optional)" type="text">
            </div>
            <p class="text-left voffset4">         
              <!--<input  type="checkbox" id="mycheck" name="termcondition" value="1" required>--> 
              By creating this account you agree to THOAG <span>Terms and Conditions</span>
              <span class="terms_text" style="display:none;"><a href="#" class="fnt_redclr">Terms and Conditions</a></span>
              <p class='error_accept' style='color:red;text-align: center;'></p>
            </p>
        
            <div class="text-center">
              <!-- <button type="button" class="btn btn-default defltflat_btn text-center" data-dismiss="modal" data-target="#vrfymodal">
                Create Account <i class="fa fa-angle-right" aria-hidden="true"></i>
              </button>-->
              <p>
                <button class="btn btn-default defltflat_btn text-center" id="shairbtn"  type="button" >Create Account 
                <img src="<?php echo $this->webroot."home/";?>images/view_order.png" alt="" ></button>
              </p>
            </div>
            <p class="text-center">Already have an Account? <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#Login" >Log In</a></p>
            <p class="text-center"><a href="<?php echo $this->webroot; ?>users/forgetpwd" style="color:#3d3d3d;" class="fnt_redclr">Forgot Password?</a></p>
          </form>
        </div> 
      </div>
    </div>
  </div>
</div>
  <script type="text/javascript">  

jQuery.noConflict()(function ($) {
    var sharecode = jQuery("#sharecode").validate({ 
	errorClass: "my-error-class",
   	validClass: "my-valid-class", 
        rules: {
              phone : { 
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10,                  
                  },
             password:{ 
                required: true,
                minlength: 5 ,    
                maxlength:15                
                  } 
   
        }, 
        messages: { 
          
          phone: {
                    required: "Please enter valid Moblie Number(10 digits)",
                },
          password: {
                    required: "Please correct password format",
           }
        }
    });
	
	
	   jQuery("#shairbtn").click(function(e){   
       
       e.preventDefault();
        if(sharecode.form())
        {
      /* if($('#mycheck').is(':checked')===true ){
             $(".error_accept").text("");
        }
        else{
            $(".error_accept").text("Please accept the terms and condition");
            return false;
        }*/
 
        }
        else{
            return false;
        }

var referral_code = jQuery("#referral_code").val();
var email = jQuery("#email1").val();
var password = jQuery("#password1").val();
var contact = jQuery("#contact").val();
 var pss2 = jQuery("#password2").val();
  var dob = jQuery("#dob").val();
 var gnder = jQuery("#gender1").val();
var gnder1 = jQuery("#gender2").val();
   var gender = '';
    if(gnder != ''){
        gender = gnder;
    }else if(gnder1 != ''){
        gender = gnder1;
    }
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'data[User][referral_code]='+ referral_code + '&data[User][dob]='+ dob +'&data[User][email]='+ email + '&data[User][password]='+ password + '&data[User][phone]='+ contact +'&data[User][gender]='+ gender;


if(email==''||password==''||contact==''||dob=='')
{
alert("Please Fill All Fields");
}else if(password != pss2){
           alert('password mismatch');
           return false ;
} 
else
{
// AJAX Code To Submit Form.
jQuery.ajax({
type: "POST",
url: "<?php echo $this->webroot; ?>users/add",
data: dataString,
cache: false,
success: function(result){
 var obj = $.parseJSON( result);
 if(obj.msg =='Email_id already exist'){
      jQuery(".msg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+obj.msg);    
      jQuery('#RegisterModal').animate({ scrollTop: 100 }, 'fast'); 
      jQuery(".refer").html(' ');
 }else if(obj.msg =='Invalid refferal code'){
    jQuery(".refer").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> '+obj.msg);    
    jQuery('#RegisterModal').animate({ scrollTop: 500 }, 'fast');  
    jQuery(".msg").html(' ');  
 }
 else if(obj.msg =='Email_id already exist. Please verify your account for activation.'){    
     jQuery("#thanks").html(obj.msg);  
     jQuery("#v_userid").val(obj.user_id)
      jQuery("#RegisterModal").modal('hide');  
   jQuery('#vrfymodal').modal('show');  
 }else{
  jQuery("#thanks").html(obj.msg)
  jQuery("#v_userid").val(obj.user_id)
jQuery("#RegisterModal").modal('hide');   
jQuery('#vrfymodal').modal('show');
 }
}
});
}
return false;
});
});
</script>   