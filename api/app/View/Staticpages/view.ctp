<?php echo $this->set('title_for_layout', $staticpage['Staticpage']['title']);
 ?>
 	<div class="abut_sec_banner">          
            <img src="<?php echo $this->webroot."files/staticpage/".$staticpage['Staticpage']['image']; ?>" alt="" class="img-responsive">  
            <div class="abt_overly"></div>
	</div>
 
   <div class="blog_sec">
  <div class="container">
  
  <div class="col-sm-12">
         <div class="about_cater">
         <div class="table_head">
             <h1><?php echo $staticpage['Staticpage']['title'];?></h1>			
            </div>
     
         </div>          
         </div>
  
  
     
        <div class="blog_cntr">
 <div class="row">
          
          <div class="col-sm-12">           
           <?php  echo $staticpage['Staticpage']['description'];?>         
            
          </div>
        
        </div>
      </div>
           
    </div>
  </div> 