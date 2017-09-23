<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('View Related Order Item'); ?></h1>
                </div>
            </div>
                <div class="page_content">
                	<div class="col-sm-5">
                	<div class="restaurants index">
                    	<table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                    		<thead>
                    			<tr>
                    				<th><?php echo __('Id'); ?></th>
                    				<td><?php echo h($orderItem['OrderItem']['id']); ?></td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Order Id'); ?></th>
                    				<td><?php echo h($orderItem['OrderItem']['order_id']); ?></td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Product Id'); ?></th>
                    				<td><?php if($orderItem['OrderItem']['product_id']){
                                                        echo h($orderItem['OrderItem']['product_id']);
                                                    }else{
                                                        echo h($orderItem['OrderItem']['offer_id']);
                                                    }
                                                     
                                                    ?></td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Parent Id'); ?></th>
                    				<td><?php echo h($orderItem['OrderItem']['parent_id']); ?></td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Name'); ?></th>
                    				<td><?php echo h($orderItem['OrderItem']['name']); ?></td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Quantity'); ?></th>
                    				<td><?php echo h($orderItem['OrderItem']['quantity']); ?></td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Price'); ?></th>
                    				<td><?php echo h($orderItem['OrderItem']['price']); ?></td>
                    			</tr>
                                        <tr>
                    				<th><?php echo __('Notes'); ?></th>
                    				<td><?php echo h($orderItem['OrderItem']['notes']); ?></td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Subtotal'); ?></th>
                    				<td><?php echo h($orderItem['OrderItem']['subtotal']); ?></td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Created'); ?></th>
                    				<td><?php echo h($orderItem['OrderItem']['created']); ?></td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Modified'); ?></th>
                    				<td><?php echo h($orderItem['OrderItem']['modified']); ?></td>
                    			</tr>
                    		</thead>
                    	</table>
                    </div><!-- End Here -->
                	</div>
                </div>
            </div>
        </div>
    </div>
</section>