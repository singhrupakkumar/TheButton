<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>All Orders Reports</h1>
                </div>
                <div class="page_content">
                    <div class="btn-toolbar list-toolbar">
                         <?php if($loggedUserRole!='rest_admin'){//print_r($orders); exit;
                            echo $this->Form->create('Order', array()); ?>
                            <div class="col-lg-2"> 
                             <?php echo $this->Form->input('restaurant_id', ['options' => $res, 'label' => false, 'class' => 'form-control', 'empty' => 'Choose Restaurant','selected'=>$all['restaurant_id']]); ?>   
</div>
    <div class="col-lg-2">
        
        <input type="date" class="form-control" name="data[Order][date]" value="<?php echo $all['date']; ?>" /> 
    </div>
    <div class="col-lg-2">
        
         <input type="date" class="form-control" name="data[Order][date1]" value="<?php echo $all['date1']; ?>"/>
    </div>   
   <div class="col-lg-2">
        <?php echo $this->Form->button('Search', array('class' => 'btn btn-default')); ?>
        <?php echo $this->Html->link('View All', array('controller' => 'orders', 'action' => 'indexall', 'admin' => true), array('class' => 'btn btn-danger')); ?>
         <?php //echo $this->Html->link('Download All Report', array('controller' => 'tests', 'action' => 'dowloadexcel','admin' => false), array('class' => 'btn btn-danger')); ?>
    </div>
    <?php } else {
      echo $this->Form->create('Order', array());   
        ?>
    <div class="col-lg-2">
       <input type="date" class="form-control" name="data[Order][date]" /> 
       <input type="hidden" class="form-control" name="data[Order][resname]"  value="restaurant"/> 
    </div>
    <div class="col-lg-2">
         <input type="date" class="form-control" name="data[Order][date1]"/>
    </div> 
    <?php echo $this->Form->button('Search', array('class' => 'btn btn-default')); }  ?>
                    </div><!-- Button Group End Here -->
                    <div class="restaurants index">
                        <table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('Store Name'); ?></th>
            <!--<th><?php //echo $this->Paginator->sort('Total Table Reservation'); ?></th>-->
            
             
              <th><?php echo $this->Paginator->sort('Total Pickup Orders'); ?></th>
               <th><?php echo $this->Paginator->sort('Total Catering Orders'); ?></th>
                <th><?php echo $this->Paginator->sort('Total Delivery Orders'); ?></th>
                <th><?php echo $this->Paginator->sort('Total Orders'); ?></th>
               
               
          <?php //if($loggeduser!=427 ){   ?>
            <!--<th>Actions</th>-->
            <?php //} ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($alldata['Order'] as $order): ?>
                                     <tr>
                <td><?php echo h($order['name']); ?></td>
                <!--<td><?php //echo h($order['table_reservation']); ?></td>-->           
                
                
                <td><?php echo h($order['pickup']); ?></td> 
                 <td><?php echo h($order['catering']); ?></td> 
                 <td><?php echo h($order['delivery']); ?></td> 
                 <td><?php echo h($order['allorders']); ?></td>
                 <?php //if($loggeduser!=427 ){   ?>
<!--                <td class="actions">
                        <?php //echo $this->Html->link('View', array('action' => 'viewall', $order['id']), array('class' => 'btn btn-default btn-xs')); ?>                                 

                </td>-->
                  <?php //} ?>
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