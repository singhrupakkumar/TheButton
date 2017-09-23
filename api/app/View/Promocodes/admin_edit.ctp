<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Edit Promocode'); ?></h1>
                </div>
            </div>
                <div class="page_content">
                	<div class="col-sm-6">
                	<div class="restaurants index">
                    	<?php echo $this->Form->create('Promocode'); ?>
                    		<?php
				                echo $this->Form->input('promocode');
				                echo $this->Form->input('res_id',array('type'=>'hidden'));
				                echo $this->Form->input('discount');
                                                echo $this->Form->input('min_order_amount',array('label'=>'Order Amount(Min)','required'=>'true','type'=>'number'));
                                                echo $this->Form->input('max_discount_amount',array('label'=>'Discount Amount(Max)','required'=>'true','type'=>'number'));
                                                echo $this->Form->input('expired',array('label'=>'Expiry Date/Time'));
							?>
							<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']); ?>
                    </div><!-- End Here -->
                	</div>
                </div>
            </div>
        </div>
    </div>
</section>
<style type="text/css">
	select{
		width: auto;
    float: left;
    border: none;
    border-radius: 0px;
    background: #fff;
    border: 1px solid #ddd;
    padding: 7px 7px !important;
    color: #777 !important;
    font-size: 16px !important;
    box-shadow: none !important;
    margin: 0px;
	}
</style>