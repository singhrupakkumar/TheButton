<?php echo $this->set('title_for_layout', $staticpage['Staticpage']['title']); ?>   
<div class="abut_sec_banner">            
            <img src="<?php echo $this->webroot."files/staticpage/".$staticpage['Staticpage']['image']; ?>" alt="" class="img-responsive">  
            <div class="abt_overly"></div>
	</div>

           <div class="col-sm-12 col-xs-12"> 
           
            <div class="grid_txt">
            	<h2><?php if(!empty($staticpage['Staticpage']['title'])){ echo $staticpage['Staticpage']['title'] ;} ?></h2>
		<p><?php if ($arabic != 'ar') { echo $staticpage['Staticpage']['description']; }else{ echo $staticpage['Staticpage']['description_ar']; } ?></p>
               

            </div>
            
            </div>

