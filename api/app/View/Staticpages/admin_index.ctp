<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Staticpages</h1>
                </div>


<div class="content">
   
    <div class="main-content">
        <p>
            <?php $x = $this->Session->flash(); ?>
            <?php if ($x) { ?>
            <div class="alert success">
                <span class="icon"></span>
                <strong></strong><?php echo $x; ?>
            </div>
        <?php } ?>
        </p>
        <div class="btn-toolbar list-toolbar"> 
          <div class="add_new">
          <a href="<?php echo $this->Html->url(array('controller' => 'Staticpages', 'action' => 'admin_add')); ?>"><span class="btn btn-primary"><i class="fa fa-plus"></i>New Add</span></a>
      </div>
            <?php echo $this->Form->create("Staticpage", array("action" => "admin_index")); ?>
            
            <div class="search_username">
                <button type="submit" class="search_button1 btn btn-primary" style="float: right;"><i class="fa fa-search"></i></button>
                <input type="text" name="keyword" value="<?php if (@$keyword) {
                echo $keyword;
            } ?>" placeholder="Search Here !!!" class="form-control" style="width: 17%;float: right;"/>
            </div>

            </form>
            <div class="btn-group"> </div>
        
        </div>
        <div class="staticpagestbl">
      <?php echo $this->Form->create('Staticpage', array("action" => "deleteall", 'id' => 'mbc')); ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="admin_check_b"><input type="checkbox" id="selectall" onClick="selectallCHBox();" /></th>
                   <th><?php echo $this->Paginator->sort('Title'); ?></th>
                    <th><?php echo $this->Paginator->sort('Image'); ?></th>
                    <th><?php echo $this->Paginator->sort('Created'); ?></th>
                    <th><?php echo $this->Paginator->sort('Status'); ?></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($staticpages){
                if(isset($staticpages)){
                foreach ($staticpages as $staticpage){ ?>
                            <tr>
                                 <td><?php echo $this->Form->checkbox("use"+$staticpage['Staticpage']['id'],array('value' => $staticpage['Staticpage']['id'],'class'=>'chechid')); ?></td>
                        <td><?php echo h($staticpage['Staticpage']['title']); ?>&nbsp;</td>
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
                                <td><?php if ($staticpage['Staticpage']['status'] == '0') { ?>
                                    <?php echo $this->Form->postLink('Deactive', array('action' => 'activate', $staticpage['Staticpage']['id']), array('escape' => false, 'class' => 'archive_12'));
                                    ?></span><?php } else { ?>
                                        <?php echo $this->Form->postLink('Active', array('action' => 'block', $staticpage['Staticpage']['id']), array('escape' => false, 'class' => 'archive_12'));
                                        ?></span> <?php } ?>&nbsp;
                                </td>
                                <td class="actions">
                                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $staticpage['Staticpage']['id']), array('class' => 'view1  btn btn-default btn-xs fa fa-eye')); ?>
                                    
                                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $staticpage['Staticpage']['id']), array('class' => 'edit1 btn btn-default btn-xs fa fa-picture-o')); ?>
                                    <?php //echo $this->Form->postLink(__('Delete'),array('action' => 'delete', $staticpage['Staticpage']['id']), array('class' => 'delete1'), __('Are you sure you want to delete # %s?', $staticpage['Staticpage']['id'])); ?>
                                    <?php
                                    if ($staticpage['Staticpage']['status'] == 0) {
                                        echo $this->Form->postLink(('Activate'), array('Controller' => 'Staticpages', 'action' => 'admin_activate', $staticpage['Staticpage']['id']), array('escape' => false, 'class' => 'active1', 'title' => 'Active'));
                                    } else {
                                        echo $this->Form->postLink(('Block'), array('controller' => 'Staticpages', 'action' => 'admin_deactivate', $staticpage['Staticpage']['id']), array('escape' => false, 'class' => 'deactive1 btn btn-default btn-xs fa fa-ban', 'title' => 'Block'));
                                    }
                                    ?>
                                </td>
                            </tr>
                 <?php } } } else { { ?> 
                <p class="not_found">NOT FOUND</p>
                 <?php } } ?>
            </tbody>
        </table>
        
            <?php echo $this->Form->end(); ?>
            </div>
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


<style type="text/css">
    .search_username, .add_new{float: left; width: 100%; margin-bottom: 20px;}
   
    .staticpagestbl { width:100%; float: left;}

    
</style>