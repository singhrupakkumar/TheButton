 <?php echo $this->set('title_for_layout', 'Blog');

 ?>    
<!--------------------Welcome_sec----------------------->
	<div class="abut_sec_banner">          
            <img src="<?php echo $this->webroot."files/staticpage/".$admin_setting1[5]['Setting']['value']; ?>" alt="" class="img-responsive">  
            <div class="abt_overly"></div>
	</div>

<!---------------------Welcome_sec-------------------------> 



<!---------------------About us------------------------->

 <div class="smart_container">  
<div class="blog-post">
  <div class="container"> 
   <div class="row">  		
         <div class="col-sm-12">
         <div class="about_cater">
         <div class="table_head">
             <h1><?php if ($arabic != 'ar') { echo "Blog"; }else{ echo "مدونة"; } ?></h1>			
            </div>
     
         </div>          
         </div> 
         
         

  <?php if(!empty($blog)):
			foreach($blog as $item):
		 ?>
        <div class="col-sm-4 col-md-4">
            <div class="post">
                <div class="post-img-content">
                  	<img src="<?php if(!empty($item['Staticpage']['image'])){ echo  $this->webroot."files/staticpage/".$item['Staticpage']['image'] ;} ?>" class="img-responsive"  alt="<?php echo $item['Staticpage']['title'] ; ?>">
                  
                </div>
                <div class="content">
                    <div class="author">
                     
                      <h3><?php if ($arabic != 'ar') { echo $item['Staticpage']['title']; }else{ echo $item['Staticpage']['title_ar']; } ?></h3>
                    </div>
                    <div class="descr_blg">
                       
                  <p><?php if ($arabic != 'ar') { echo $item['Staticpage']['description']; }else{ echo $item['Staticpage']['description_ar']; } ?></p>
                    </div>
                    <div class="blog_btn">
                       <a href="<?php echo $this->webroot."staticpages/view/".$item['Staticpage']['id']; ?>"><button type="button" class="btn defult_btn more_btn"><?php if ($arabic != 'ar') { echo "Learn More"; }else{ echo "أعرف أكثر"; } ?>  <img src="<?php echo $this->webroot."home/"; ?>images/right_icn.png" alt="" ></button></a>
                    </div>
                </div>
            </div>
        </div>
        
            <?php 
		endforeach;		
		endif;
		
		 ?>


 
         
         
     
         
           
       
       
         
       
   </div> 
  </div>
</div>
</div>

<!---------------------Search------------------------->   