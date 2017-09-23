<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Categories'); ?></h1>
                </div>
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
                        <table style="font-size:12px;" id="example1" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('id'); ?></th>
				     <th><?php echo $this->Paginator->sort('name'); ?></th>
			             <th><?php echo $this->Paginator->sort('Image'); ?></th>
				     <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dishCategories as $dishCategory): ?>
                                <tr>
                                    <td><?php echo h($dishCategory['Category']['id']); ?>&nbsp;</td>
				    <td><?php echo h($dishCategory['Category']['name']); ?>&nbsp;</td>
									
                                    <td><img src="<?php echo $this->webroot ?>/files/catimage/<?php echo h($dishCategory['Category']['image']); ?>" width="100px" height="100px"/>&nbsp</td>
				    <td class="actions">
				    <?php echo $this->Html->link(__(''), array('action' => 'view', $dishCategory['Category']['id']), array('class' => 'btn btn-default btn-xs fa fa-eye', 'title' => 'View')); ?>
                                    <?php if($loggedin['role']=='admin'){ ?>
				    <?php echo $this->Html->link(__(''), array('action' => 'edit', $dishCategory['Category']['id']), array('class' => 'btn btn-default btn-xs fa fa-pencil', 'title' => 'Edit')); ?>
                                                                              
				     <?php echo $this->Form->postLink('', array('action' => 'delete', $dishCategory['Category']['id']), array('class' => 'btn btn-default btn-xs fa fa-trash','title'=>'Delete'), __('Are you sure you want to delete # %s?', $dishCategory['Category']['id'])); ?>										
                                    <?php } ?>
				    </td>
                                </tr>
                                <?php endforeach; ?>
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
        $('#example1').DataTable();
    } );
</script>  