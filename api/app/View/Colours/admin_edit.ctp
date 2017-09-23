<section class="admin_main-sec">    
	<div class="sec_inner">
		<div class="row">
			<div class="col-md-12">
				<div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Edit Colour'); ?></h1>  
                </div>
			</div>
			<div class="col-sm-5">
                     <?php echo $this->Form->create('Colour'); ?>
			<?php echo $this->Form->input('id'); ?>
			<?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
			<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
			<?php echo $this->Form->end(); ?>
                            
                            
                        </div>
		</div>
	</div>
</section>    
