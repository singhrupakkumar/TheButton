<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Edit Store Settings</h1>
                </div>



<div class="row">
    <div class="col-sm-5">
        <div class="add_dish">
            <?php 
			echo $this->Form->create('Setting', array('type' => 'file')); ?>
              <?php foreach($settings as $setting){
                
				 if($setting['Setting']['type']=='file'){
					   
                       ?>
                       <div class="input file">
                       	<label for="SettingBlogBanner"><?php echo str_replace('_', ' ', $setting['Setting']['key']); ?></label>
                       	<input type="file" name="data[Setting][<?php echo $setting['Setting']['key']; ?>][]" multiple accept="image/jpg, image/jpeg" />
                        </div>
                       <?php 
                                }elseif($setting['Setting']['type']=='color'){
                                 
                                    ?>
                            <div class="input color">
                           <label for="Settingcolor"><?php echo str_replace('_', ' ', $setting['Setting']['key']); ?></label>
                           <input type="color" name="data[Setting][<?php echo $setting['Setting']['key']; ?>]" value="<?php echo $settings[3]['Setting']['value']; ?>"/>
                           </div>      
                               <?php }else{
					  echo $this->Form->input($setting['Setting']['key'],array('label'=>ucwords(str_replace('_', ' ', $setting['Setting']['key'])),'value'=>$setting['Setting']['value'])); 
				 }
                      } ?>
          
            <br />
           
            <?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>  
            <?php echo $this->Form->end(); ?>  
			<ul>
			<li><label>Banner</label> 
            
            	<?php
                $banner_images = $settings[9]['Setting']['value'];
                $banner_images = explode(',',$settings[9]['Setting']['value']);
                foreach($banner_images as $image){
                ?>
                <img src="<?php echo $image; ?>" width="100" height="100">
            	<?php
                }
                ?>
			 </li>
			 <!--li><label>Faq Banner</label>
			 <img src="<?php echo $this->webroot."files/staticpage/". $settings[7]['Setting']['value']; ?>" width="100" height="100"> </li-->
			<ul> 
        </div>
    </div>
</div>

         </div>
        </div>
    </div>
</section>




