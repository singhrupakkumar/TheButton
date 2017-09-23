<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Promocode'); ?></h1>
                </div>

<div class="taxes index">
	<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('Promocode'); ?></th>
                        
			<th><?php echo $this->Paginator->sort('discount'); ?></th>   
                        <th><?php echo $this->Paginator->sort('expired'); ?></th>
                        <th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($promocodes as $promocode): ?>
	<tr>
		<td><?php echo h($promocode['Promocode']['id']); ?>&nbsp;</td>
		<td><?php echo h($promocode['Promocode']['promocode']); ?>&nbsp;</td>
         
		<td><?php echo h($promocode['Promocode']['discount'])."%"; ?>&nbsp;</td>
                <td><?php echo h($promocode['Promocode']['expired']); ?>&nbsp;</td>
                <td><?php echo h($promocode['Promocode']['created']); ?>&nbsp;</td>
		<td style="width: 20% !important;" class="actions">
			<?php echo $this->Html->link(__(''), array('action' => 'view', $promocode['Promocode']['id']), array('class' => 'view1  btn btn-default btn-xs fa fa-eye','title' => 'View')); ?>

			<?php echo $this->Html->link(__(''), array('action' => 'edit', $promocode['Promocode']['id']), array('class' => 'edit1 btn btn-default btn-xs fa fa-pencil','title' => 'Edit')); ?>
                        <?php echo $this->Form->postLink((''), array('action' => 'delete', $promocode['Promocode']['id']), array('class' => 'delete1 btn btn-default btn-xs fa fa-trash-o','href'=>''), __('Are you sure you want to delete # %s?', $promocode['Promocode']['id'])); ?>
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

   </div>
        </div>
    </div>
</section>
