<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Events'); ?></h1>
                </div>
                <div class="up-img_sec">
		   <?php echo $this->Html->link('Add Event', array('action' => 'add'), array('class' => 'btn btn-info')); ?>
		</div><br/>
                
                <div class="page_content">
                    <?php $x = $this->Session->flash(); ?>  
            		<?php if ($x) { ?>
		            <div class="alert success">
		                <span class="icon"></span>
		                <strong></strong><?php echo $x; ?>
		            </div>
        			<?php } ?>

                    <?php //echo $this->Form->create('Restaurant', array("action" => "deleteall", 'id' => 'mbc')); ?>
                    <div class="restaurants index">
                        <table style="font-size:12px;" id="events" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                        <th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
                                        <th><?php echo $this->Paginator->sort('Start Date'); ?></th>
                                        <th><?php echo $this->Paginator->sort('End Date'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
                                        <th class="actions">Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                         	<?php
				if(!empty($eventscheduler)):
				foreach ($eventscheduler as $tag): ?>  
				<tr>
					<td><?php echo $tag['Eventscheduler']['id']; ?></td>
					<td><?php echo $tag['Eventscheduler']['name']; ?></td>
                                        <td><?php echo $tag['Eventscheduler']['start_date']; ?></td>
                                        <td><?php echo $tag['Eventscheduler']['end_date']; ?></td> 
					<td><?php echo $tag['Eventscheduler']['created']; ?></td>
					<td><?php echo $tag['Eventscheduler']['modified']; ?></td>
					<td class="actions">
						<?php echo $this->Html->link('View', array('action' => 'view', $tag['Eventscheduler']['id']), array('class' => 'btn btn-default btn-xs btn-view')); ?>
						<?php echo $this->Html->link('Edit', array('action' => 'edit', $tag['Eventscheduler']['id']), array('class' => 'btn btn-default btn-xs btn-edit')); ?>
						<?php echo $this->Form->postLink('Delete', array('action' => 'delete', $tag['Colour']['id']), array('class' => 'btn btn-danger btn-xs btn-delet'), __('Are you sure you want to delete # %s?', $tag['Eventscheduler']['id'])); ?>
					</td>
				</tr>
				<?php endforeach;
				endif;
				?> 
                            </tbody>
                        </table>
                    </div><!-- End Here --> 
                </div>
            </div>
        </div>
    </div>
</section>
 <script type="text/javascript" charset="utf-8">
    $(document).ready(function() { 
        $('#events').DataTable();
    } );
</script>  