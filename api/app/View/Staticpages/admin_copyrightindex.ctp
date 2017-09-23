<style type="text/css">
    .search_button1{
        border: 1px solid #CC0000 !important;
    }
    #StaticpageAdminBlogindexForm{
        float: right;
        width: auto;
    }
    #StaticpageAdminBlogindexForm input[type="text"]{
        width: 80%;
    }
</style>
<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Copyright</h1> 
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
          <a style="float: left;" href="<?php echo $this->Html->url(array('controller' => 'Staticpages', 'action' => 'admin_addcopyright')); ?>"><span class="btn btn-primary"><i class="fa fa-plus"></i> Add New Copyright</span></a>
          <?php echo $this->Form->create("Staticpage", array("action" => "admin_copyrightindex")); ?>
            
            <div class="search_username">
                <button type="submit" class="search_button1 btn btn-primary" style="float: right;"><i class="fa fa-search"></i></button>
                <input type="text" name="keyword" value="<?php if (@$keyword) {
                echo $keyword;
            } ?>" placeholder="Search Here !!!" class="form-control" style="float: right;"/>
            </div>

            </form>
      </div>
        
        </div>
        <div class="staticpagestbl">
      <?php echo $this->Form->create('Staticpage', array("action" => "deleteall", 'id' => 'mbc')); ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                   <th><?php echo $this->Paginator->sort('Title'); ?></th>
                    <th><?php echo $this->Paginator->sort('Created'); ?></th>
                    
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($staticpages){
                if(isset($staticpages)){
                foreach ($staticpages as $staticpage){ ?>
                            <tr>
                                 <!--<td><?php //echo $this->Form->checkbox("use"+$staticpage['Staticpage']['id'],array('value' => $staticpage['Staticpage']['id'],'class'=>'chechid')); ?></td>-->
                        <td><?php echo h($staticpage['Staticpage']['title']); ?>&nbsp;</td>
           
                        <td><?php echo h($staticpage['Staticpage']['created']); ?>&nbsp;</td>
                        
                                <td class="actions">
                                    <?php echo $this->Html->link(__(''), array('action' => 'blogview', $staticpage['Staticpage']['id']), array('class' => 'view1  btn btn-default btn-xs fa fa-eye','title'=>'View')); ?>
                                    
                                    <?php echo $this->Html->link(__(''), array('action' => 'copyrightedit', $staticpage['Staticpage']['id']), array('class' => 'edit1 btn btn-default btn-xs fa fa-pencil','title'=>'Edit')); ?>

                                </td>  
                            </tr>
                 <?php } } } else { { ?> 
                <p class="not_found">NOT FOUND</p>   
                 <?php } } ?>
            </tbody>
        </table>
        
            <?php echo $this->Form->end(); ?>  
            </div>
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
    </div>
</section>


<style type="text/css">
    .search_username, .add_new{float: left; width: 100%; margin-bottom: 20px;}
   
    .staticpagestbl { width:100%; float: left;}

    
</style>