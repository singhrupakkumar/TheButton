<section class="admin_main-sec">
	<div class="sec_inner">
		<div class="row">
			<div class="col-md-12">
				<div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Add Size'); ?></h1>
                </div>
			</div>
			<div class="col-sm-5">
				  <?php echo $this->Form->create('Size'); ?>
				<div class="page_content">
					<div class="restaurants index">
					
                                            <?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
                                       
					</div>
				</div>
				<?php echo $this->Form->submit(__('Submit',true), array('class'=>'btn btn-primary'));  ?>
                                <?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</section>