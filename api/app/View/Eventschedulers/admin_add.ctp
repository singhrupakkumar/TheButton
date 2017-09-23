<section class="admin_main-sec">
	<div class="sec_inner">
		<div class="row">
			<div class="col-md-12">
				<div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Add Event'); ?></h1>
                </div>
			</div>
			<div class="col-sm-5">
				  <?php echo $this->Form->create('Eventscheduler'); ?> 
				<div class="page_content">
					<div class="restaurants index"> 
					
                                            <?php echo $this->Form->input('name', array('class' => 'form-control'));   
                                               echo $this->Form->input('product_id', ['options' => $products, 'label' => 'Products:','multiple'=>"multiple", 'class' => 'form-control','id' => "productname", 'empty' => 'Choose product']);
                                            ?>
                                            <?php echo $this->Form->input('start_date'); ?>
                                            <?php echo $this->Form->input('end_date'); ?>   
                                       
					</div>  
				</div>
				<?php echo $this->Form->submit(__('Submit',true), array('class'=>'btn btn-primary'));  ?>
                                <?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</section>
<style type="text/css">
    #EventschedulerStartDateHour,#EventschedulerEndDateHour{
            margin-left: 3px;  
    }
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
