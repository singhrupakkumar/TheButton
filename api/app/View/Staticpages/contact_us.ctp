<?php echo $this->set('title_for_layout', 'Contact Us');?> 
<section class="main_new_sec">
      <section class="cont_map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d457617.46596799383!2d49.71228418783692!3d26.35444821141064!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e361d32276b3403%3A0xefd901ec7a5e5676!2sDammam+Saudi+Arabia!5e0!3m2!1sen!2sin!4v1490959963853" frameborder="0" style="border:0" allowfullscreen></iframe>
        <div class="clr"></div>
      </section><!-- End Here -->
      <section class="cont_details">  
        <div class="container">
          <div class="row">
            <div class="col-sm-8">
              <div class="cont_form">
                <h3><?php if ($arabic != 'ar') { echo "Get In Touch"; }else{ echo "ابقى على تواصل"; } ?></h3>
                
                  <?php
if(isset($_POST['email'])) {
     
    // CHANGE THE TWO LINES BELOW
    
     
    $email_subject = $_POST['subject'];  
     
     
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
     
    // validation expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['phone']) || 
        !isset($_POST['msg'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
	
	
	
    $email_to =  $admin_setting[2]['Setting']['value']; 
    $first_name = $_POST['name']; // required
    $email_from = $_POST['email']; // required
    $telephone = $_POST['phone']; // not required
    $comments = $_POST['msg']; // required
     
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
    $string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$first_name)) {
    $error_message .= 'The  Name you entered does not appear to be valid.<br />';
  }

  if(strlen($comments) < 2) {
    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
  }
  if(strlen($error_message) > 0) {
    died($error_message);
  }
    $email_message = "Form details below.\n\n";
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
     
    $email_message .= "Name: ".clean_string($first_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telephone: ".clean_string($telephone)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";
     
     
// create email headers  
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  
?>
 
<!-- place your own success html below -->
 
<h3 style="color:#093; font-size:20px;text-align: center;">
<?php if ($arabic != 'ar') { echo "Thank you for contacting us. We will be in touch with you very soon."; }else{
	echo "أشكركم على الاتصال بنا. سنكون على اتصال معكم قريبا جدا."; } ?></h3>
 
<?php 
}
?>
    
    
    
                <?php echo $this->Form->create(null, array('id' => 'contactform','class' => 'jquery-validation')); ?> 
                  
                    <div class="form-group">
                      <input type="text" name="name" class="form-control" placeholder="<?php if ($arabic != 'ar') { echo "Please Enter Your Full Name"; }else{
	echo "من فضلك ادخل اسمك الكامل"; } ?>">
                    </div>
                  
                 
                    <div class="form-group">
                      <input type="email" name="email" class="form-control" placeholder="<?php if ($arabic != 'ar') { echo "Please Enter Your Email Address"; }else{
	echo "الرجاء إدخال عنوان البريد الإلكتروني الخاص بك"; } ?>">
                    </div>
                 
                 
                    <div class="form-group">
                        <input type="tel" name="phone" maxlength="10" class="form-control" placeholder="<?php if ($arabic != 'ar') { echo "Please Enter Your Phone Number"; }else{
	echo "يرجى إدخال رقم الهاتف الخاص بك"; } ?>">
                    </div>
                 
                  
                    <div class="form-group">
                      <input type="text" name="subject" class="form-control" placeholder="<?php if ($arabic != 'ar') { echo "Please Enter Your Subject"; }else{
	echo "الرجاء إدخال الموضوع"; } ?>">
                    </div>
                 
                
                    <div class="form-group">
                      <textarea class="form-control md-textarea" cols="50" rows="40" name="msg" placeholder="<?php if ($arabic != 'ar') { echo "Write Your Message Here...."; }else{
	echo "اكتب رسالتك هنا...."; } ?>"></textarea>
                    </div>
                  
                 
                    <div class="form-group">
                      <input type="submit"  value="<?php if ($arabic != 'ar') { echo "Submit"; }else{
	echo "عرض"; } ?>" class="btn defult_btn btn-sm">
                    </div>
                  
               <?php echo $this->Form->end(); ?>   
              </div>
            </div>
            <div class="col-md-4"> 
              <div class="cont_inner">
                <h3><?php if ($arabic != 'ar') { echo "Contact Details"; }else{
	echo "بيانات المتصل"; } ?></h3>
                <ul>
                  <li>
                    <span><?php if ($arabic != 'ar') { echo "Address"; }else{
	echo "عنوان"; } ?> :</span> <?php if(!empty($admin_setting[3]['Setting']['value'])) { echo $admin_setting[3]['Setting']['value'] ;}?>
                  </li>
                  <li>
                    <span><?php if ($arabic != 'ar') { echo "Phone"; }else{
	echo "هاتف"; } ?> :</span> <?php echo  $admin_setting[1]['Setting']['value'] ;
					
					?>
                  </li>
                  <!--<li>
                    <span>Fax :</span> +1 315-401-4222
                  </li>-->
                  <li>
                    <span><?php if ($arabic != 'ar') { echo "Email"; }else{
	echo "البريد الإلكتروني"; } ?> :</span> <a href=" <?php echo  $admin_setting[2]['Setting']['value'] ;?>"> <?php echo  $admin_setting[2]['Setting']['value'] ;?></a>
                  </li>
                  <!--<li>
                    <span>Web :</span> <a href="www.yourdomainname.com/">www.yourdomainname.com/</a>
                  </li>-->
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
    </section>

<script type="text/javascript">
//    
//
//    
//   
// jQuery.noConflict()(function ($) {   
//    
//jQuery(document).ready(function() {
//   
//          var contactform = jQuery("#contactform").validate({   
//	errorClass: "my-error-class",
//   	validClass: "my-valid-class", 
//        rules: {
//             name : { 
//               lettersonly:true ,   
//                required: true 
//                  } 
//                 ,phone: {  
//                 number:true,
//                minlength: 10,
//                maxlength: 10 
//              
//                  },
//				email: {  
//                  email: true ,
//                   required: true  
//                  }
//        },
//        messages: {
//          
//          name: {     
//                    required: "Please enter valid name", 
//                },
//             phone: {  
//                    required: "Please enter valid number(9 digits)",  
//                },
//				email: {    
//                    required: "Please valid email address",  
//                }
//        }
//    });
//
//
//
//    $('#contactform').on('submit', function () {
//    if(contactform.form()){ 
//     
//    } else {  
//        return false;  
//    }
//});
//
//
//
//	});
//        }); 
//  
</script> 