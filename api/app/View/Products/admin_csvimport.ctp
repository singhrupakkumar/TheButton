<section class="admin_main-sec">
	<div class="sec_inner">
		<div class="row">
			<div class="col-md-12">
				<div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Import Product'); ?></h1>
                </div>
			</div>
			<div class="col-sm-5">        
                            <?php echo $this->Form->create(array('type' => 'file'));
                             echo $this->Form->input('csv', array('type' => 'file', 'class' => 'form-control', 'label' => 'Csv File:'));?>
                              
                           <?php echo $this->Form->submit(__('Import',true), array('class'=>'btn btn-primary'));  ?>
                           <?php echo $this->Form->end(); ?>
                            <p>Download Sample File</p>
                            <a class="btn btn-success" href="<?php echo $this->webroot."files/product-semple.csv" ?>" download>Download</a>
                       </div>
		</div>
	</div>
</section>  
                            