 <style type="text/css">
  .list-first{
    width: 100%;
    float: left;
  }
  .list-first span{
    display: inline-block;
    height: 46px;
    line-height: 46px;
    padding: 0px 26px;
    border: 1px solid #e4e6e8;
    font-size: 16px;
    color: #555;
    float: left;
  }
  .list-first input.form-control{
    width: 82% !important;
    float: right !important;
    display: inline-block !important;
  }
</style>
<!---------------------caterer_sec------------------------->
<?php //print_r($addressdata);?>
<div class="update_sec menu">
  <div class="container-fluid">
    
   
    <div class="col-sm-12">
    <div class="update_prfl">
      <div class="accordion" id="accordion2">
            <div class="accordion-group">
            <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" aria-expanded="true" data-parent="#accordion2" href="#collapseOne">
           <?php if ($arabic != 'ar') { ?>Edit Profile<?php }else{ echo "تعديل الملف الشخصي"; } ?> 
            </a>
            </div>
            <div id="#" class="accordion-body collapse in"> 
            <div class="accordion-inner clearfix">
 
                 
    <?php echo $this->Form->create('User', array('id' => 'editform')); ?>
    <div class="details">
                <div class="col-sm-12 col-xs-12">
                <div class="col-sm-6 col-xs-12 border-right">
                 <div class="col-sm-6">
                 <div class="edit_fld">
         
                    <label> <?php if ($arabic != 'ar') { ?>Your Full Name<?php }else{ echo "اسمك الكامل"; } ?></label> 
                     <div class="edit_prflicn">
           <input  name="data[User][username]" id="username1" value="<?php echo $data['User']['username']; ?>" type="hidden"/>
           <input class="form-control" id="name" placeholder="Please Enter Your Full Name" name="name" value="<?php echo $data['User']['name']; ?>" type="text"/>
                       
                     <div class="editprfl_icn"><a href="#"><i class="fa fa-pencil" aria-hidden="true"></a></i></div> 
                    </div>
                    </div>                 
                    </div>
                    <div class="col-sm-6">
                    <div class="edit_fld">
                    <label><?php if ($arabic != 'ar') { ?>Email Address<?php }else{ echo "عنوان البريد الإلكتروني"; } ?></label>
                    <div class="edit_prflicn">
          <input class="form-control" id="email" placeholder="Please Enter Email Address" name="email" value="<?php echo $data['User']['email']; ?>" type="email"/>
                   
                     <div class="editprfl_icn"><a href="#"><i class="fa fa-pencil" aria-hidden="true"></a></i></div> 
                     </div> 
                    </div>                  
                    </div>
                    
                    <div class="col-sm-6">
                    <div class="edit_fld">
                    <label><?php if ($arabic != 'ar') { ?>Gender<?php }else{ echo "جنس"; } ?></label>
                    <div class="edit_prflicn">
                        <select name="gender" id="egender" class="form-control">
                            <option value=""></option>
                             <option <?php if($data['User']['gender']=='male'){ echo "selected"; }  ?> value="male">
                                 <?php if ($arabic != 'ar') { ?>Male<?php }else{ echo "الذكر"; } ?>
                             </option>
                             <option <?php if($data['User']['gender']=='female'){ echo "selected"; }  ?> value="female">
                                 <?php if ($arabic != 'ar') { ?>Female<?php }else{ echo "إناثا"; } ?> 
                             </option>
                        </select>    
                    </div>  
                    </div>                  
                    </div>
                    <div class="col-sm-6">
                    <div class="edit_fld">
                    <label><?php if ($arabic != 'ar') { ?>Phone Number<?php }else{ echo "رقم الهاتف"; } ?></label>  
                    <div class="edit_prflicn">
          <input class="form-control" id="phone" placeholder="Please Enter Your Phone" maxlength="10" name="phone" value="<?php echo $data['User']['phone']; ?>" type="text"/>
                   
                     <div class="editprfl_icn"><a href="#"><i class="fa fa-pencil" aria-hidden="true"></a></i></div> 
                    </div> 
                    </div>                  
                    </div>
                  
 
                    <div class="col-sm-6">
                    <div class="edit_fld">
                    <label><?php if ($arabic != 'ar') { ?>Your Country<?php }else{ echo "بلدك"; } ?></label> 
                     <div class="edit_prflicn">
           <input class="form-control" id="country" placeholder="Please Enter your Country" name="country" value="<?php echo $data['User']['country']; ?>" type="text"/>
                    
                     <div class="editprfl_icn"><a href="#"><i class="fa fa-pencil" aria-hidden="true"></a></i></div> 
                    </div>
                    </div>                  
                    </div>
          <div class="col-sm-12"> 
          <div class="edit_fld">
          <input name="submit" id="editsubmit" type="button" value="<?php if ($arabic != 'ar') { ?>Submit<?php }else{ echo "عرض"; } ?>"/>
          </div>
                    </div>  
                   </div> 
                   
                 
               
                   </div>

             
           
                   </div>
                  
        <?php echo $this->Form->end(); ?>
           
                    </div>
                
                </div>
         
            
            </div>
            </div>
            </div>
            
            </div>    
    </div>
      </div>
      
      


<script type="text/javascript">      
jQuery(document).ready(function() {
 

   ////////edit form/////////
   
      var useredit = $("#editform").validate({
	errorClass: "my-error-class",
   	validClass: "my-valid-class", 
        rules: {
              zip : { 
                 number: true
                  } 
                 ,phone : {  
                 number:true,
                 required:true,
                minlength: 10,
                maxlength: 10
                  },gender: {  
                 required:true 
                  } 
                  ,country:{  
                 lettersonly:true 
                  }
				  
        },
        messages: {
          
          zip: {  
                    required: "Please enter valid zip code", 
                },
                city1: {  
                    required: "Please enter valid city name",  
                },
                gender: {   
                    required: "Please select gender",  
                },
                phone: {  
                    required: "Please enter valid number(10 digits)",  
                }, country: {  
                    required: "Please enter valid country name", 
                }
        }
    });

     $("#editsubmit").click(function(e){ 
     
       e.preventDefault();
       
        if(useredit.form())
        {
        } 
        else{
            return false;
        }   

var email = $("#email").val();
var state = $("#state").val();
var username1 = $("#username1").val();
var edob = $("#edob").val();
var egender = $("#egender").val(); 
var name = $("#name").val();
var zip = $("#zip").val();
var phone = $("#phone").val();
var city = $("#city").val(); 
var address1 = $("#address1").val(); 
var country = $("#country").val(); 
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'data[User][name]='+ name+ '&data[User][zip]='+ zip+ 
        '&data[User][city]='+ city+ '&data[User][address]='+ address1+
        '&data[User][username]='+ username1+ '&data[User][email]='+ email+  
        '&data[User][state]='+ state+ '&data[User][phone]='+ phone+ '&data[User][country]='+
        country+ '&data[User][dob]='+ edob+ '&data[User][gender]='+ egender;    
 
// AJAX Code To Submit Form.   
$.ajax({ 
type: "POST", 
url: "<?php echo $this->webroot; ?>users/edit", 
data: dataString,
cache: false,
success: function(result){
    if(result){
      alert('Your profile has been Updated.'); 
 window.location = '<?php echo $this->webroot."users/myaccount"; ?>'; 
   
    } 

}
});

return false;
});

  });


</script>    
   