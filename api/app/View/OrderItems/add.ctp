<div class="orderItems form">
<?php echo $this->Form->create('OrderItem'); ?>
	<fieldset>
		<legend><?php echo __('Add Order Item'); ?></legend>
	<?php
		echo $this->Form->input('order_id');
		echo $this->Form->input('product_id');
		echo $this->Form->input('parent_id');
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

		<li><?php echo $this->Html->link(__('List Order Items'), array('action' => 'index')); ?></li>
	</ul>
</div>
