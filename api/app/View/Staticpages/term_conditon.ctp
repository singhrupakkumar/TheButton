<?php echo $this->set('title_for_layout', 'Terms & Conditions');
if(!empty($tc)){
 ?>
	<div class="abut_sec_banner">          
            <img src="<?php echo $this->webroot."files/staticpage/".$tc[0]['Staticpage']['image']; ?>" alt="" class="img-responsive">  
            <div class="abt_overly"></div>
	</div>
<?php  } ?>	
 <div class="smart_container"> 
<div class="container">

<div class="col-sm-12">
         <div class="about_cater">
         <div class="table_head">
            <h1><?php if ($arabic != 'ar') { echo "Terms & Conditions"; }else{ echo "البنود و الظروف"; } ?></h1>		
            </div>
     
         </div>          
         </div>

        <div class="privacy_policy">
         <div class="col-sm-12 ">
		 <?php foreach($tc as $content):?>
               <div class="voffset4">
               
                <h2><?php if ($arabic != 'ar') { echo $content['Staticpage']['title']; }else{ echo $content['Staticpage']['title_ar']; } ?></h2>
             
               <p><?php if ($arabic != 'ar') { echo $content['Staticpage']['description']; }else{ echo $content['Staticpage']['description_ar']; } ?></p>
                </div>
<?php endforeach ;?>
        </div>
        
        </div>
</div>
</div>
