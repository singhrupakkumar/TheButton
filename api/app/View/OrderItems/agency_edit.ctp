<div class="orderItems form">
<?php echo $this->Form->create('OrderItem'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Order Item'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('order_id');
		echo $this->Form->input('product_id');
		//echo $this->Form->input('parent_id');
		echo $this->Form->input('name');
		echo $this->Form->input('quantity');
		echo $this->Form->input('price');
		echo $this->Form->input('subtotal');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('OrderItem.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('OrderItem.id'))); ?></li>
		
	</ul>
</div>
