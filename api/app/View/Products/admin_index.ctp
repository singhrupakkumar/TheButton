<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Products'); ?></h1>
                </div>
                <div class="page_content">
                    <?php $x = $this->Session->flash(); ?>
            		<?php if ($x) { ?>
		            <div class="alert success">
		                <span class="icon"></span>
		                <strong></strong><?php echo $x; ?>
		            </div>
        			<?php } ?>

                    <div class="restaurants index"> 
              
                        <table style="font-size:12px;" id="example" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th><?php echo $this->Paginator->sort('image'); ?></th>
                                <th><?php echo $this->Paginator->sort('category_id'); ?></th>
                                <th><?php echo $this->Paginator->sort('name'); ?></th>
                                <th><?php echo $this->Paginator->sort('price'); ?></th>
                                <th><?php echo $this->Paginator->sort('Min Price'); ?></th>
                                <th><?php echo $this->Paginator->sort('weight'); ?></th>
                                <th><?php echo $this->Paginator->sort('size'); ?></th>
                                <th><?php //echo $this->Paginator->sort('active'); ?></th>
                                <th><?php echo $this->Paginator->sort('created'); ?></th>
                                <th><?php echo $this->Paginator->sort('modified'); ?></th>
                                <th class="actions">Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                          <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo $this->Html->Image('/files/product/' . $product['Product']['image'], array('width' => 100, 'height' => 100, 'alt' => $product['Product']['image'], 'class' => 'image')); ?></td>
                                    <td><span class="category" data-value="<?php echo $product['Category']['id']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Category']['name']; ?></span></td>

                                    <td><span class="name" data-value="<?php echo $product['Product']['name']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['name']; ?></span></td>
                                   
                                    <td><span class="price" data-value="<?php echo $product['Product']['price']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['price']; ?></span></td>
                                    <td><span class="price" data-value="<?php echo $product['Product']['price']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['min_price']; ?></span></td>
                                    <td><span class="weight" data-value="<?php echo $product['Product']['weight']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['weight']; ?></span></td>
                                            <td><span class="sizes" data-value="<?php echo $product['Product']['sizes']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['sizes']; ?></span></td>
                                    <td><?php //echo $this->Html->link($this->Html->image('icon_' . $product['Product']['active'] . '.png'), array('controller' => 'products', 'action' => 'switch', 'active', $product['Product']['id']), array('class' => 'status', 'escape' => false)); ?></td>
                                    <td><?php echo h($product['Product']['created']); ?></td>
                                    <td><?php echo h($product['Product']['modified']); ?></td>
                                    <td class="actions">
                                        <?php echo $this->Html->link('', array('action' => 'view', $product['Product']['id']), array('class' => 'btn btn-default btn-xs fa fa-eye')); ?>
                                        <?php echo $this->Html->link('', array('action' => 'edit', $product['Product']['id']), array('class' => 'btn btn-default btn-xs fa fa-pencil')); ?>
                                        <?php echo $this->Form->postLink('', array('action' => 'delete', $product['Product']['id']), array('class' => 'btn btn-default btn-xs fa fa-trash','title'=>'Delete'), __('Are you sure you want to delete # %s?', $product['Product']['id'])); ?>
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
        $('#example').DataTable();
    } );
</script>  