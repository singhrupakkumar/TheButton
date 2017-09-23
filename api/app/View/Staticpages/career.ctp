    <?php echo $this->set('title_for_layout', 'Career');
   // print_r($career);
    ?>   
<!--------------------Welcome_sec----------------------->
	<div class="abut_sec">          
            <img src="<?php echo $this->webroot."files/staticpage/".$career[0]['Staticpage']['image']; ?>" alt="" class="img-responsive">  
            <div class="abt_overly"></div>
	</div>

<!---------------------Welcome_sec-------------------------> 



<!---------------------About us------------------------->

 <div class="smart_container">
<div class="about_sec">
  <div class="container"> 
   <div class="row">  		
         <div class="col-sm-12">
         <div class="about_cater">
         <div class="table_head">
             <h1>Career</h1>			
            </div>
            
            <h1>Strong Business Drivers</h1>
            <p>We enable making your catering service offering more valuable</p>            
                   
         </div>         
         </div>   
         
         <div class="col-sm-12 col-xs-12">
		 <?php if(!empty($career)):
			foreach($career as $item):
		 ?>
         <div class="grid_bdr">
         <div class="col-sm-4 col-xs-12">
         	<div class="row">
            	<div class="abtlft_img">
                	<img src="<?php if(!empty($item['Staticpage']['image'])){ echo  $this->webroot."files/staticpage/".$item['Staticpage']['image'] ;} ?>" class="img-responsive"  alt="<?php echo $item['Staticpage']['title'] ; ?>">
                </div>
        </div>
            </div>
            
            <div class="col-sm-8 col-xs-12"> 
           
            <div class="grid_txt">
            	<h2><?php if(!empty($item['Staticpage']['title'])){ echo $item['Staticpage']['title'] ;} ?></h2>
				<p><?php if ($arabic != 'ar') { echo $item['Staticpage']['description']; }else{ echo $item['Staticpage']['description_ar']; } ?></p>
               
<a href="<?php echo $this->webroot."staticpages/view/".$item['Staticpage']['id']; ?>"><button type="button" class="btn defult_btn more_btn">Learn More  <img src="<?php echo $this->webroot."home/"; ?>images/right_icn.png" alt="" ></button></a>
            </div>
            
            </div>
           
         </div>    
         <?php 
		endforeach;		
		endif;
		
		 ?>
          <!------------grid_bdr---------->

         
       </div>
   </div> 
  </div>
</div>
</div>

<!---------------------Search------------------------->   