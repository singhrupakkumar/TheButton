<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Users</h1>
                </div>
                <div class="page_content">
  
                    <div class="restaurants index">
                      <table style="font-size:12px;" id="users" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>   
                                <tr>

        <th><?php echo $this->Paginator->sort('role');?></th>
        <th><?php echo $this->Paginator->sort('name');?></th>
        <th><?php echo $this->Paginator->sort('username');?></th>
        <th><?php echo $this->Paginator->sort('active');?></th>
        <th><?php echo $this->Paginator->sort('created');?></th>
        <th><?php echo $this->Paginator->sort('modified');?></th>
        <th class="actions">Actions</th>
    </tr>
                            </thead>
                            <tbody>
                               <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo h($user['User']['role']); ?></td>
        <td><?php echo h($user['User']['name']); ?></td>
        <td><?php echo h($user['User']['username']); ?></td>
        <td><?php echo h($user['User']['active']); ?></td>
        <td><?php echo h($user['User']['created']); ?></td>
        <td><?php echo h($user['User']['modified']); ?></td>
        <td class="actions">
            <?php echo $this->Html->link('', array('action' => 'view', $user['User']['id']), array('class' => 'btn btn-default btn-xs fa fa-eye', 'title'=>'View')); ?>
            <?php 
            if($user['User']['active']==1){
                echo $this->Form->postLink((''), array('action' => 'deactivate', $user['User']['id']), array('class' => 'deactivate1 btn btn-default btn-xs fa fa-ban','href'=>''), __('Are you sure you want to deactivate # %s?', $user['User']['id'])); 
            }else{
                echo $this->Form->postLink((''), array('action' => 'activate', $user['User']['id']), array('class' => 'activate1 btn btn-default btn-xs fa fa-check','href'=>''), __('Are you sure you want to activate # %s?', $user['User']['id'])); 
            }
                
                ?>
				
                <?php echo $this->Form->postLink((''), array('action' => 'delete', $user['User']['id']), array('class' => 'delete1 btn btn-default btn-xs fa fa-trash-o','href'=>''), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
            <?php echo $this->Html->link('', array('action' => 'password', $user['User']['id']), array('class' => 'btn btn-default btn-xs fa fa-lock','title'=>'Change Password')); ?>
            
            <?php //echo $this->Html->link('', array('action' => 'edit', $user['User']['id']), array('class' => 'btn btn-default btn-xs fa fa-pencil','Edit')); ?>
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
        $('#users').DataTable();
    } );
</script>  