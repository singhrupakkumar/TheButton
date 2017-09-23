<!--------------------Welcome_sec----------------------->
	<div class="search_sec">
            <div class="srch_cater">
            <img src="<?php echo $this->webroot."home/";?>images/seach_bg.png" class="img_head" alt="">
            <div class="srch_cater_txt">
            	<h1>Your favourite caterers </h1>
                <p>Filling every occasion with great food and service</p>
            </div>
            </div>      

	</div>

<!---------------------Welcome_sec-------------------------> 



<!---------------------Search------------------------->
<div class="smart_container">
<?php echo $this->Session->flash(); ?>  
<div class="search_cater">
  <div class="container"> 
   <div class="row">  		
         <div class="col-sm-12">
         
         
    <div class="cntr_srch_sec rapdsearch clearfix">

        <?php 
if($favlist != null){
foreach($favlist as $list) : ?>
        <div class="result_sec clearfix">
          <div class="col-xs-12 col-sm-3">
         		<div class="feature_grid hvr-wobble-horizontal">
                    <div class="feature_img"><img src="<?php echo $list['Restaurant']['banner'] ;?>" class="img-responsive" alt=""></div>
                    <div class="feature_txt">
                    <div class="feature_title">
					<?php if ($arabic != 'ar') { echo $list['Restaurant']['name']; }else{ echo $list['Restaurant']['name_ar']; } ?>
					
					</div>                    
                        <div class="feature_star">
						
						          <?php
								$i= round($list['Restaurant']['review_avg']);
                                        
                                        for($j=0;$j<$i;$j++){
                                        ?>
                                     <i class="fa fa-star" aria-hidden="true"></i>
                                        
                                 
                                        <?php } for($h=0;$h<5-$i;$h++){?>  
                                         
                                       <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <?php 
                                        
                                        }  
									?> 
                     
                        </div>
                         <div class="feature_time">
                          <?php if ($arabic != 'ar') { ?>Lead time:<?php }else{ echo "المهلة:"; } ?> <?php echo $list['Restaurant']['lead_time'] ;?> hrs
                         </div>
                         <div class="feature_redbg"><span>Rapid Boking</span></div>
                         <span class="feat_cater"><?php if ($arabic != 'ar') { ?>featured<?php }else{ echo "متميز"; } ?></span>
                         <div class="feature_wtricon"><img src="<?php echo $this->webroot."home/";?>images/watermark_icon.png" alt=""></div>
                    </div>
                    
                    	
                    </div>
          </div>
           <div class="col-xs-12 col-sm-7">
           	 <p class="descrip_txt">
			 <?php if ($arabic != 'ar') { echo $list['Restaurant']['description']; }else{ echo $list['Restaurant']['description_ar']; } ?>
			
			 </p>
             <div class="leadtime">
             	<h3> <?php if ($arabic != 'ar') { ?>Lead time:<?php }else{ echo "المهلة:"; } ?> <?php echo $list['Restaurant']['lead_time'] ;?>  <?php if ($arabic != 'ar') { ?>hours<?php }else{ echo "ساعة"; } ?> 
       
                 </h3>
             </div>
          </div>
           <div class="col-xs-12 col-sm-2">
    <?php  
                        if($arabic=='ar'){
               $arb = $arabic;  
            }else{
               $arb = "eng";   
            }
                    ?> 		   
 <a class="btn btn-sm defult_btn view_btn" href="<?php echo $this->webroot.$arb."/restaurants/menu/".$list['Restaurant']['id']; ?> "><?php if ($arabic != 'ar') { ?>View Menu<?php }else{ echo "عرض القائمة"; } ?></a>		   
               

		<form action="<?php echo $this->webroot."restaurants/favourities"?>" method="POST"> 
         <input type="hidden" name="uid" value="<?php echo $loggeduser ;?>"> 
         <input type="hidden" name="rest_id" value="<?php echo $list['Restaurant']['id'] ;?>"> 
         <input type="hidden" name="server" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">

         <button type="submit" class="btn btn-sm defultgrey_btn view_btn"><?php if ($arabic != 'ar') { ?>Unfavourite<?php }else{ echo "أونافوريت"; } ?></button>

        </form>			
           
          </div>
        
        
        </div>
        <?php endforeach;
        }else{ 
            echo '<p style="text-align:center;">There is no Favourite Caterer yet!</p> ';
            }
        
         ?>

    </div>
   
         
         </div>     
       
   </div> 
  </div>
</div>
</div>  

<!---------------------Search-------------------------> 