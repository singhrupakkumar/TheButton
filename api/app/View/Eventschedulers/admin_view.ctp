<style>
	table{
		width:100%;
		margin:0px;
	}
</style>
<section class="admin_main-sec">    
	<div class="sec_inner">
		<div class="row">
         	<div class="col-md-12">
				<div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Event'); ?></h1>  
                </div>
			</div>           
	<div class="col-sm-5">
		<div class="form_outer">
			<table class="table-striped table-bordered table-condensed table-hover">
				<tr>
					<td>Id</td>
					<td><?php echo h($Eventscheduler['Eventscheduler']['id']); ?></td>
				</tr>
				<tr>
					<td>Name</td>
					<td><?php echo h($Eventscheduler['Eventscheduler']['name']); ?></td>
				</tr>
                                <tr>
					<td>Start Date</td>
					<td><?php echo h($Eventscheduler['Eventscheduler']['start_date']); ?></td>
				</tr>
                                <tr>
					<td>End Date</td>  
					<td><?php echo h($Eventscheduler['Eventscheduler']['end_date']); ?></td>
				</tr>
				<tr>
					<td>Created</td>
					<td><?php echo h($Eventscheduler['Eventscheduler']['created']); ?></td>
				</tr>
				<tr>
					<td>Modified</td>
					<td><?php echo h($Eventscheduler['Eventscheduler']['modified']); ?></td>  
				</tr>
			</table>
		</div>
	</div>
        <div class="col-sm-12">
            <h1>Event Products</h1>
		<div class="form_outer">
			 <table style="font-size:12px;" id="events_products" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
					<th>Name</th>  
					<th>Image</th>
				</tr>
                            </thead>   
                            <tbody>
                                <?php
				if(!empty($event_products)):
				foreach ($event_products as $item): ?>  
                                <tr>
                                    <td><?php echo $item['Product']['name']; ?></td> 
			            <td><?php echo $this->Html->Image('/files/product/' . $item['Product']['image'], array('width' => 50, 'height' => 50, 'alt' => $item['Product']['image'], 'class' => 'image')); ?></td>
				</tr> 
                               <?php endforeach;
				endif;  
				?>  
                           </tbody>
			</table>
		</div>
	</div>            
                    
                    
</div>
 </div>
</section>    

  <script type="text/javascript" charset="utf-8">
    $(document).ready(function() { 
        $('#events_products').DataTable();
    } );
</script>    