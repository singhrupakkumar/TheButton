
<h2>Table Recent Items</h2>
<button onclick="ReloadPage()">Reload page</button>
<script>
function ReloadPage() {
    location.reload();
}
</script>
<div class="table-responsive">

    <table class="table table-striped table-bordered table-condensed table-hover">
        <tr>
            <th><?php echo $this->Paginator->sort('ID'); ?></th>
            <th><?php echo $this->Paginator->sort('Name'); ?></th>
            <th><?php echo $this->Paginator->sort('Quantity'); ?></th>
            <th><?php echo $this->Paginator->sort('Price'); ?></th>
            <th><?php echo $this->Paginator->sort('Total'); ?></th>
            <th><?php echo $this->Paginator->sort('Table No'); ?></th>     
             <th><?php echo $this->Paginator->sort('created'); ?></th>
            <th>Actions</th>
        </tr>
<?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo h($order['Cart']['id']); ?></td>
                <td><?php echo h($order['Cart']['name']); ?></td>
                <td><?php echo h($order['Cart']['quantity']); ?></td>
                <td><?php echo h($order['Cart']['price']); ?></td>
                <td><?php echo h($order['Cart']['subtotal']); ?></td>
                <td><?php echo h($order['Cart']['tno']); ?></td>
                <td><?php echo h($order['Cart']['created']); ?></td>
                <td class="actions">                                          
                   
                        <?php  if ($order['Cart']['isAccept'] == 0) { ?>
                        
                    <form action="<?php echo $this->webroot?>admin/orders/accept" method="post">
                            <input type="hidden" name="isAccespt" value="<?php echo $order['Cart']['id']; ?>"/>
                            <Input type="submit" name="accept" value="Accept"/>
                         </form>
                        <?php  } else { ?>
                        <form action="<?php echo $this->webroot?>admin/orders/unaccept" method="post">
                            <input type="hidden" name="unAccespt" value="<?php echo $order['Cart']['id']; ?>"/>
                            <Input type="submit" name="unaccept" value="Accepted"/>
                        </form>
                        <?php } ?>

                         <form action="<?php echo $this->webroot?>admin/orders/crtdelete" method="post">
                            <input type="hidden" name="delete" value="<?php echo $order['Cart']['id']; ?>"/>
                            <Input type="submit" name="del" value="Delete"/>
                        </form>

                </td>

            </tr>
<?php endforeach; ?>
    </table>
</div>
