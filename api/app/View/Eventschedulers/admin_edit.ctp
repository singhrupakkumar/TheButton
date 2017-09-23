<section class="admin_main-sec">  
	<div class="sec_inner">
		<div class="row">
			<div class="col-md-12">
				<div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Edit Event'); ?></h1>  
                </div>
			</div>
			<div class="col-sm-5">  
                            
                       <?php
                      // print_r($eventscheduler['Eventscheduler']['product_id']);
                        //print_r($products); 
                       
                       echo $this->Form->create('Eventscheduler'); ?> 
			<?php echo $this->Form->input('id'); ?>
			<?php echo $this->Form->input('name', array('class' => 'form-control')); ?>  
                       <select name="data[Eventscheduler][product_id][]" multiple="multiple" class="form-control" id="productname">
                           <option value="" selected="selected">Choose product</option>
                           <?php foreach($products as $key=>$v){ ?>
                           <option <?php if(in_array($key,explode(',',$eventscheduler['Eventscheduler']['product_id']))){ echo "selected"; } ?> value="<?php echo $key; ?>"><?php echo $v; ?></option>
                           <?php } ?> 
                        </select>      
                        <?php echo $this->Form->input('start_date'); ?>
                        <?php echo $this->Form->input('end_date'); ?>      
			<?php echo $this->Form->button('Submit', array('class' => 'btn btn-primary')); ?>
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
