<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Pages</h1>
                </div>
                <div class="page_content">
                    <p>
                        <?php $x = $this->Session->flash(); ?>
                        <?php if ($x) { ?>
                        <div class="alert success">
                            <span class="icon"></span>
                            <strong></strong><?php echo $x; ?>
                        </div>
                    <?php } ?>
                    </p>
                    <div class="restaurants index">
                    <?php echo $this->Form->create('Staticpage', array("action" => "deleteall", 'id' => 'mbc')); ?>
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('Title'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Pages'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Image'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Created'); ?></th>
                                    
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($staticpages){
                                if(isset($staticpages)){
                                foreach ($staticpages as $staticpage){ ?>
                                <tr>
                                    <td><?php echo h($staticpage['Staticpage']['title']); ?>&nbsp;</td>
                                     <td>
                                         <?php 
                                     echo h($staticpage['Staticpage']['position']); ?>&nbsp;
                                     </td>
                        <td><?php
                    $ext = pathinfo($staticpage['Staticpage']['image'], PATHINFO_EXTENSION);
                        if(empty($ext)){
                           echo  'No Image';
                        }
                        else
                        {
                      echo $this->Html->image('../files/staticpage/'.$staticpage['Staticpage']['image']
                            ,array('alt'=>'Not Image','height'=>'70px','width'=>'100px')); 
                        }
                        ?>
                           
                            
                       
                            
                        </td>
                        <td><?php echo h($staticpage['Staticpage']['created']); ?>&nbsp;</td>
                                <!--<td><?php if ($staticpage['Staticpage']['status'] == '0') { ?>
                                    <?php echo $this->Form->postLink('', array('action' => 'activate', $staticpage['Staticpage']['id']), array('escape' => false, 'class' => 'archive_12 btn btn-default btn-xs fa fa-ban', 'title'=>'Active'));
                                    ?></span><?php } else { ?>
                                        <?php echo $this->Form->postLink('', array('action' => 'deactivate', $staticpage['Staticpage']['id']), array('escape' => false, 'class' => 'archive_12 btn btn-default btn-xs fa fa-check', 'title'=>'Deactive'));
                                        ?></span> <?php } ?>&nbsp;
                                </td>-->
                                <td class="actions">
                                    <?php echo $this->Html->link(__(''), array('action' => 'view', $staticpage['Staticpage']['id']), array('class' => 'view1 btn btn-default btn-xs fa fa-eye', 'title'=>'View')); ?>
                                    
                                    <?php echo $this->Html->link(__(''), array('action' => 'edit', $staticpage['Staticpage']['id']), array('class' => 'edit1 btn btn-default btn-xs fa fa-pencil', 'title'=>'Edit')); ?>

                                    <?php //echo $this->Form->postLink(__(''),array('action' => 'delete', $staticpage['Staticpage']['id']), array('class' => 'delete1 btn btn-default btn-xs fa fa-trash', 'title'=>'Delete'), __('Are you sure you want to delete # %s?', $staticpage['Staticpage']['id'])); ?>
                                    <?php
                                    //if ($staticpage['Staticpage']['status'] == 0) {
                                    //    echo $this->Form->postLink(('Activate'), array('Controller' => 'Staticpages', 'action' => 'admin_activate', $staticpage['Staticpage']['id']), array('escape' => false, 'class' => 'active1', 'title' => 'Active'));
                                    //} else {
                                    //    echo $this->Form->postLink(('Block'), array('controller' => 'Staticpages', 'action' => 'admin_deactivate', $staticpage['Staticpage']['id']), array('escape' => false, 'class' => 'deactive1', 'title' => 'Block'));
                                    //}
                                    ?>
                                </td>
                                </tr>
                                <?php } } } else { { ?> 
                <p class="not_found">NOT FOUND</p>
                 <?php } } ?>
                            </tbody>
                        </table>
                        <?php echo $this->Form->end(); ?>
                    </div><!-- End Here -->


        <div class="bottom_button">
            <ul class="paginator_Admin">
            <div class="first_button1"><?php echo $this->Paginator->prev('Previous ', null, null, array('class' => 'disabled')); ?></div>
                                       <?php echo $this->Paginator->numbers(); ?>
            <div class="first_button1"><?php echo $this->Paginator->next(' Next ', null, null, array('class' => 'disabled')); ?></div>
        </ul>
        </div>
                </div>
            </div>
        </div>
    </div>
</section>