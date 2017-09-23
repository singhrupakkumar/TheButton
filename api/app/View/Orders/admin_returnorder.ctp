<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Return Orders'); ?></h1> 
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
                        <table style="font-size:12px;" id="returnorders" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('Order ID'); ?></th>

                                    <th><?php echo $this->Paginator->sort('name'); ?></th>
                                    <th><?php echo $this->Paginator->sort('email'); ?></th>
                                    <th><?php echo $this->Paginator->sort('phone'); ?></th>
                                    <th><?php echo $this->Paginator->sort('subtotal'); ?></th>
                                    <th><?php echo $this->Paginator->sort('total'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Return Message'); ?></th>
                                    <th><?php echo $this->Paginator->sort('created'); ?></th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                          <?php foreach ($orders as $order): ?>
                         <tr>
                            <td><?php echo h($order['Order']['id']); ?></td>

                            <td><?php echo h($order['Order']['name']); ?></td>
                            <td><?php echo h($order['Order']['email']); ?></td>
                            <td><?php echo h($order['Order']['phone']); ?></td>
                            <td><?php echo h($order['Order']['subtotal']); ?></td>
                            <td><?php echo h($order['Order']['total']); ?></td>
                            <td><?php echo h($order['Order']['return_msg']); ?></td>
                            <td><?php echo h($order['Order']['created']); ?></td>
                            <td class="actions">
                                    <?php echo $this->Html->link('', array('action' => 'view', $order['Order']['id']), array('class' => 'btn btn-default btn-xs fa fa-eye','title'=>'View')); ?>
                                    <select name="return_status" class="accept">
                                        
                                        <option <?php  if($order['Order']['return_status']==0){ echo "selected"; } ?> value="0-<?php echo $order['Order']['id']; ?>">Requested</option> 
                                       <option <?php if($order['Order']['return_status']==1){ echo "selected"; } ?> value="1-<?php echo $order['Order']['id']; ?>">Accept</option>
                                       <option <?php if($order['Order']['return_status']==2){ echo "selected"; } ?> value="2-<?php echo $order['Order']['id']; ?>">Reject</option>   
                                     
                                    </select> 
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
        $('#returnorders').DataTable();

          $(".accept").change(function () { 
        var a = $(this).val();
        $.post('https://rupak.crystalbiltech.com/thebutton/api/admin/orders/returnstats', {id: a}, function (d) {
          //  console.log(d);
        });
        //alert(a);
    });  
        
    } );
</script>  