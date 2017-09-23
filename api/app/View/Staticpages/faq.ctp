
<?php echo $this->set('title_for_layout', 'Faq'); ?>
	<div class="abut_sec_banner">          
 <img src="<?php echo $this->webroot."files/staticpage/".$admin_setting[7]['Setting']['value']; ?>" alt="" class="img-responsive">  
            <div class="abt_overly"></div>
	</div>
 <!----------------Faq-----------------------> 

<div class="container">

<div class="col-sm-12">
         <div class="about_cater">
         <div class="table_head">
            <h1><?php if ($arabic != 'ar') { echo "Frequently Asked Questions"; }else{ echo "أسئلة مكررة"; } ?></h1>		
            </div>
     
         </div>          
         </div>


        <div class="privacy_policy">
            <div class="col-sm-12 ">
               <div class="faq_colps">
               
                <div class="panel-group" id="accordion"> 
				
	<?php
    $cos = 0;
	foreach($faqs as $content):
	$cos++;
	?>			
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $cos ;?>">
        Q: <?php if ($arabic != 'ar') { echo $content['Staticpage']['title']; }else{ echo $content['Staticpage']['title_ar']; } ?></a>
      </h4>
    </div>
    <div id="collapse<?php echo $cos ;?>" class="panel-collapse collapse <?php if($cos==1){ echo "in" ;}?>">

      <div class="panel-body"><?php if ($arabic != 'ar') { echo $content['Staticpage']['description']; }else{ echo $content['Staticpage']['description_ar']; } ?></div>
    </div>
  </div>
  
  <?php endforeach ;?>

</div> 
               
               
               </div>

              
               
                
        </div>
        
        </div>
</div>
