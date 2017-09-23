<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Gift Item'); ?></h1>
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
                        <table style="font-size:12px;" id="example" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th><?php echo $this->Paginator->sort('image'); ?></th>
                                <th><?php echo $this->Paginator->sort('category_id'); ?></th>
                                <th><?php echo $this->Paginator->sort('name'); ?></th>
                                <th><?php echo $this->Paginator->sort('price'); ?></th>
                                <th><?php echo $this->Paginator->sort('weight'); ?></th>
                                <th><?php echo $this->Paginator->sort('size'); ?></th>
                            
                              </tr>
                            </thead>
                            <tbody>
                          <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo $this->Html->Image('/files/product/' . $product['Product']['image'], array('width' => 100, 'height' => 100, 'alt' => $product['Product']['image'], 'class' => 'image')); ?></td>
                                    <td><span class="category" data-value="<?php echo $product['Category']['id']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Category']['name']; ?></span></td>

                                    <td><span class="name" data-value="<?php echo $product['Product']['name']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['name']; ?></span></td>
                                   
                                    <td><span class="price" data-value="<?php echo $product['Product']['price']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['price']; ?></span></td>
                                    <td><span class="weight" data-value="<?php echo $product['Product']['weight']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['weight']; ?></span></td>
                                     <td><span class="sizes" data-value="<?php echo $product['Product']['sizes']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['sizes']; ?></span></td>
                                 
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