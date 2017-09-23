<?php echo $this->set('title_for_layout', 'Privacy Policy'); ?>
<div class="supprt_banner">           
            <img src="<?php echo $this->webroot."files/staticpage/".$data['Staticpage']['image']; ?>" alt="" class="img-responsive">  
            <div class="abt_overly"></div>
	</div>
 <div class="smart_container">
<div class="container">


<div class="col-sm-12">
               
                <div class="table_head">
				
            	
            	<h1><?php if ($arabic != 'ar') { echo $data['Staticpage']['title']; }else{ echo $data['Staticpage']['title_ar']; } ?></h1>
                </div>
                <?php echo $this->Session->flash(); ?>  
          	</div>
        <div class="caterer_policy">
         <div class="col-sm-12 ">
		
               <div class="voffset4">              
           <?php if ($arabic != 'ar') { echo $data['Staticpage']['description']; }else{ echo $data['Staticpage']['description_ar']; } ?>
               
               
                </div>
                
              
                
             <div class="support_frm">
			
			 <div class="col-sm-4 "><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $setting[1]['Setting']['value'] ;?></div>
			  <div class=" col-sm-4"><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $setting[2]['Setting']['value'] ;?></div>
			  
			   <div class=" col-sm-4"><i class="fa fa-twitter" aria-hidden="true"></i><?php if ($arabic != 'ar') { echo "Get in Touch with us on Twitter"; }else{ echo "الحصول على اتصال معنا على تويتر"; } ?>  <strong><?php echo $setting[10]['Setting']['value'] ;?></strong></div>
			<div class="col-sm-12">
			<p class="qmsg" style="color:red;"></p>
			<form class="suppr_frm" method="post" id="supportform">
			<select class="form-control" id="subject" name="subject">
			<option value=" "><?php if ($arabic != 'ar') { echo "Please Select Subject"; }else{ echo "الرجاء تحديد الموضوع"; } ?></option>
			<option value="Enquiry"><?php if ($arabic != 'ar') { echo "Enquiry"; }else{ echo "تحقيق"; } ?> </option>
			<option value="Support"><?php if ($arabic != 'ar') { echo "Support"; }else{ echo "الدعم"; } ?></option>
			<option value="Follow"><?php if ($arabic != 'ar') { echo "Follow"; }else{ echo "إتبع"; } ?></option>
			</select> 
			<input type="email" name="email" class="form-control" placeholder="<?php if ($arabic != 'ar') { echo "Enter Email Address"; }else{ echo "أدخل عنوان البريد الالكتروني"; } ?>" required>
			<textarea col="40" row="40" name="msg" class="form-control" placeholder="<?php if ($arabic != 'ar') { echo "Enter Text"; }else{ echo "أدخل النص"; } ?>"></textarea> 
			<button type="submit" class="btn defult_btn"><?php if ($arabic != 'ar') { echo "Submit"; }else{ echo "عرض"; } ?></button>
			
			</form> 
			</div>
			 </div>  
             

        </div>
        
        </div>
</div>
</div>
<script>
jQuery(document).ready(function() {
 jQuery('#supportform').on('submit', function(event){
if(jQuery('#subject').val() == ''){  
    event.preventDefault();
        jQuery(".qmsg").html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i> Please Select Query Subject');
        
      }
	
});	
	
});
</script>
