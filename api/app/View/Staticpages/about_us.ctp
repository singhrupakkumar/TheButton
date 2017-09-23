    <?php echo $this->set('title_for_layout', 'About Us'); ?>   
<!--------------------Welcome_sec----------------------->
	<div class="abut_sec_banner">           
            <img src="<?php echo $this->webroot."files/staticpage/".$about[0]['Staticpage']['image']; ?>" alt="" class="img-responsive">  
            <div class="abt_overly"></div>
	</div>

<!---------------------Welcome_sec-------------------------> 



<!---------------------About us------------------------->

 <div class="smart_container">
<div class="about_sec">
  <div class="container"> 
   <div class="row">  		
            <div class="table_head">
            	
            	<h1><?php if ($arabic != 'ar') { echo $about[0]['Staticpage']['title']; }else{ echo $about[0]['Staticpage']['title_ar']; } ?></h1>
                </div>
         
         <div class="col-sm-12 col-xs-12">
		 <?php if(!empty($about)):
		 ?>
          <div class="about_cater">
         <div class="grid_bdr">
         
            
          
           
            <div class="grid_txt">
             
				<p><?php if ($arabic != 'ar') { echo $about[0]['Staticpage']['description']; }else{ echo $about[0]['Staticpage']['description_ar']; } ?></p>
               
<!--<a href="<?php echo $this->webroot."staticpages/single_about/".$item['Staticpage']['id']; ?>"><button type="button" class="btn defult_btn more_btn">Learn More  <img src="<?php echo $this->webroot."home/"; ?>images/right_icn.png" alt="" ></button></a>-->
            </div>
            
            
           
         </div>  
         <?php 
		endif;
		
		 ?>
          <!------------grid_bdr---------->

         </div>  
       </div>
   </div> 
  </div>
</div>
</div>

<!---------------------Search------------------------->   