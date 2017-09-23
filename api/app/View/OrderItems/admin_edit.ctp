<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Edit Related Order Item'); ?></h1>
                </div>
            </div>
                <div class="page_content">
                	<div class="col-sm-5">
                	<div class="restaurants index">
                    	<?php echo $this->Form->create('OrderItem'); ?>
                    		<?php
								echo $this->Form->input('id', array('class'=>'form-control'));
								echo $this->Form->input('order_id', array('class'=>'form-control'));
								echo $this->Form->input('product_id', array('class'=>'form-control'));
								//echo $this->Form->input('parent_id', array('class'=>'form-control'));
								echo $this->Form->input('name', array('class'=>'form-control'));
								echo $this->Form->input('quantity', array('class'=>'form-control'));
								echo $this->Form->input('price', array('class'=>'form-control'));
								echo $this->Form->input('subtotal', array('class'=>'form-control'));
							?>
                    	<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']); ?>
                    </div><!-- End Here -->
                	</div>
                </div>
            </div>
        </div>
    </div>
</section>