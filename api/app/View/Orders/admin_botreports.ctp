<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Bots Reports'); ?></h1>
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
                        <table style="font-size:12px;" id="botorders" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('Order ID'); ?></th>

                                    <th><?php echo $this->Paginator->sort('name'); ?></th>
                                    <th><?php echo $this->Paginator->sort('email'); ?></th>
                                    <th><?php echo $this->Paginator->sort('Product Name'); ?></th>  
                                    <th><?php echo $this->Paginator->sort('phone'); ?></th>
                                    <th><?php echo $this->Paginator->sort('subtotal'); ?></th>
                                    <th><?php echo $this->Paginator->sort('total'); ?></th>
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
                            <td><?php echo h($order['OrderItem'][0]['name']); ?></td>
                            <td><?php echo h($order['Order']['phone']); ?></td>
                            <td><?php echo h($order['Order']['subtotal']); ?></td>
                            <td><?php echo h($order['Order']['total']); ?></td>
                            <td><?php echo h($order['Order']['created']); ?></td>
                            <td class="actions">
                                    <?php echo $this->Html->link('', array('action' => 'view', $order['Order']['id']), array('class' => 'btn btn-default btn-xs fa fa-eye','title'=>'View')); ?>

                                    <?php //echo $this->Html->link('', array('action' => 'edit', $order['Order']['id']), array('class' => 'btn btn-default btn-xs fa fa-pencil', 'title'=>'Edit')); ?>
                                    <select name="dlsts" class="dlsts">
                                        <?php foreach($OrderStatus as $status){
                                            if($status['OrderStatus']['id']==$order['Order']['order_status']){ ?>
                                            <option selected="selected" value="<?php echo $order['Order']['uid'] . '-' .$status['OrderStatus']['id'].'-'.$order['Order']['id']; ?>"><?php echo $status['OrderStatus']['status']; ?></option>
                                            <?php }else{ ?>
                                                <option value="<?php echo $order['Order']['uid'] . '-' . $status['OrderStatus']['id'].'-'.$order['Order']['id']; ?>"><?php echo $status['OrderStatus']['status']; ?></option>
                                           <?php }
                                           } ?>
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
        $('#botorders').DataTable();
        
        
          $(".dlsts").change(function () {  
        var a = $(this).val(); 
        $.post('https://rupak.crystalbiltech.com/thebutton/api/admin/orders/dlstas', {id: a}, function (d) {
            console.log(d);
        });
        //alert(a);
    });
        
    } );
</script>  