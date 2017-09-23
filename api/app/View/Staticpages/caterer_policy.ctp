<?php echo $this->set('title_for_layout', 'Privacy Policy'); ?>
<div class="abut_sec_banner">           
            <img src="<?php echo $this->webroot."files/staticpage/".$policy[0]['Staticpage']['image']; ?>" alt="" class="img-responsive">  
            <div class="abt_overly"></div>
	</div>
 <div class="smart_container">
<div class="container">


<div class="col-sm-12">
               
                <div class="table_head">
            	<h1><?php if(!empty($policy[0]['Staticpage']['title'])){ echo $policy[0]['Staticpage']['title'] ;} ?></h1>
                </div>
                
          	</div>
        <div class="caterer_policy">
         <div class="col-sm-12 ">
		
               <div class="voffset4"> 
				<p><?php if ($arabic != 'ar') { echo $policy[0]['Staticpage']['description']; }else{ echo $policy[0]['Staticpage']['description_ar']; } ?></p>
          
               
                </div>

        </div>
        
        </div>
</div>
</div>
