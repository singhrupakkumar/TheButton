<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Promocode'); ?></h1>
                </div>
            </div>
                <div class="page_content">
                	<div class="col-sm-5">
                	<div class="restaurants index">
                    	<table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                    		<thead>
                    			<tr>
                    				<th><?php echo __('Id'); ?></th>
                    				<td><?php echo h($promocode['Promocode']['id']); ?></td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Promocode'); ?></th>
                    				<td><?php echo h($promocode['Promocode']['promocode']); ?></td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Discount Percentage'); ?></th>
                    				<td><?php echo h($promocode['Promocode']['discount'])."%"; ?></td>
                    			</tr>
                                        <tr>
                    				<th><?php echo __('Order Amount(Min)'); ?></th>
                    				<td><?php echo h($promocode['Promocode']['min_order_amount']); ?></td>
                    			</tr>
                                        <tr>
                    				<th><?php echo __('Discount Amount(Max)'); ?></th>
                    				<td><?php echo h($promocode['Promocode']['max_discount_amount']); ?></td>
                    			</tr>
                    			<tr>
                    				<th><?php echo __('Expiry Date/Time'); ?></th>
                    				<td><?php echo h($promocode['Promocode']['expired']); ?></td>
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