<div class="orderItems index">
	<h2><?php echo __('Order Items'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('order_id'); ?></th>
			<th><?php echo $this->Paginator->sort('product_id'); ?></th>
			<th><?php echo $this->Paginator->sort('parent_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('quantity'); ?></th>
			<th><?php echo $this->Paginator->sort('price'); ?></th>
			<th><?php echo $this->Paginator->sort('subtotal'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($orderItems as $orderItem): ?>
	<tr>
		<td><?php echo h($orderItem['OrderItem']['id']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['order_id']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['product_id']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['parent_id']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['name']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['quantity']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['price']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['subtotal']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['created']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $orderItem['OrderItem']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $orderItem['OrderItem']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $orderItem['OrderItem']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $orderItem['OrderItem']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Order Item'), array('action' => 'add')); ?></li>
	</ul>
</div>
