<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Edit Associated Dish Category'); ?></h1>
                </div>
            </div>
                <div class="page_content">
                	<div class="col-sm-5">
                	<div class="restaurants index">
                    	<?php echo $this->Form->create('DishCategory',array('type'=>'file')); ?>
                    		<?php
                                    echo $this->Form->input('id');
                                    echo $this->Form->input('name',array('class'=>'form-control','required' => true));
                                    echo $this->Form->input('name_ar',array('class'=>'form-control','required' => true,'label'=>'Name in Arabic'));
                                    //echo $this->Form->input('status');
                                ?>
                 			<img src="<?php echo $this->webroot;?>files/catimage/<?php echo $this->request->data['DishCategory']['image']; ?>" width="100" height="100"/>
                			<input type="hidden" value="<?php echo $this->request->data['DishCategory']['image']; ?>" name="data[DishCategory][img]"/>
               			<?php 
        					echo $this->Form->input('image',array('class'=>'form-control','type'=>'file'));
        				?>
                    	<?php echo $this->Form->button(__('Submit'),['class'=>'btn btn-primary']); ?>
                    </div><!-- End Here -->
                	</div>
                </div>
            </div>
        </div>
    </div>
</section>