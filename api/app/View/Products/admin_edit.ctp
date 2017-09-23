<style>
    #attributename{
        min-height: 150px !important;
    }
 </style>  
<section class="admin_main-sec">
	<div class="sec_inner">
		<div class="row">
			<div class="col-md-12">
				<div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Edit Product'); ?></h1>
                </div>
			</div>
			<div class="col-sm-5">
				<?php echo $this->Form->create('Product',array('type'=>'file')); ?>
				<div class="page_content">
					<div class="restaurants index">
                                                <?php echo $this->Form->input('id');  

                                                ?>

                                                <?php echo $this->Form->input('category_id', ['options' => $Category, 'label' => 'Category:', 'id' => "parentcat", 'empty' => 'Choose category','class' => 'form-control','required']); ?> <br />
                                               <div class="input select"><label for="dishcatname">Sub Category:</label>   
                                                    <select name="data[Product][sub_cat_id]" class="form-control" id="subcat">
                                                        <?php if(!empty($product_sub_cat)){?>
                                                        <option value="<?php echo $product_sub_cat['Category']['id']; ?>"><?php echo $product_sub_cat['Category']['name']; ?></option> 
                                                        <?php } ?>
                                                    </select> 
                                                </div>
                                                  <select name="data[Product][attribute_id][]" multiple="multiple" class="form-control" id="attributename">
                                                        <option value="" selected="selected">Choose product</option>   
                                                        <?php foreach($attributes as $key=>$v){ ?>
                                                        <option <?php if(in_array($key,explode(',',$product['Product']['attribute_id']))){ echo "selected"; } ?> value="<?php echo $key; ?>"><?php echo $v; ?></option>
                                                        <?php } ?> 
                                                   </select>         
                                                        
                                               
                                                 <?php echo $this->Form->input('name', array('class' => 'form-control')); ?> 

                                                <?php echo $this->Form->input('description', array('class' => 'form-control ckeditor')); ?>

                                                <?php
                                                echo $this->Html->Image('/files/product/' . $product['Product']['image'], array('width' => 100, 'height' => 100, 'alt' => $product['Product']['image'], 'class' => 'image'));
                                                echo $this->Form->input('image', array('type' => 'file', 'class' => 'form-control'));
                                                ?>
                                              
                                           <div class="input file">
                                            
                                                 <label for="ProductGalleryImg">Gallery:</label> 
                                                    <?php
                                                    if(!empty($product['Product']['gallery_img'])){
                                                      $gallery =  explode(',',$product['Product']['gallery_img']);   
                                                    foreach ($gallery as $gimage){   
                                                      echo $this->Html->Image('/files/product/gallery/' .$gimage, array('width' => 100, 'height' => 100, 'alt' => $product['Product']['image'], 'class' => 'image'));   
                                                    }
                                                    } 
                                                      ?>
                                               <input type="file" name="data[Product][gallery_img][]" class="form-control" multiple="multiple" id="ProductGalleryImg">
                                           </div>
                                                <?php echo $this->Form->input('price', array('class' => 'form-control')); ?>
                                                 <?php echo $this->Form->input('min_price', array('class' => 'form-control','label' => 'Minimum Price')); ?>

                                                <?php echo $this->Form->input('weight', array('class' => 'form-control')); ?> 

                                                <?php echo $this->Form->input('is_gift_item', array('type' => 'checkbox','label' => 'Is Gift Item')); ?>  
                                                <?php echo $this->Form->input('view_isshow', array('type' => 'checkbox','label' => 'Customer Viewing')); ?> 
					</div>
				</div>
				<?php echo $this->Form->submit(__('Submit',true), array('class'=>'btn btn-primary'));  ?>
                            <?php echo $this->Form->end();  ?>
			</div>
		</div>
	</div>
</section>
 
<script> 
   $(document).on('ready', function() {      
   $('#parentcat').on('change',function(){
                    $.ajax({
			type: "POST",
			url: Shop.basePath + "products/subcat",
			data: {
				id: $(this).val() 
			},
			dataType: "json",
			success: function(data) {
                         var  html = '';  
			 jQuery.each(data, function (index, value) {
                                html += '<option value="'+value.Category.id+'">'+value.Category.name+'</option>';
                                }); 
                        $('#subcat').html(html); 
			},
			error: function() {   
				alert('Error');
			}
		});
   }); 
   
   

   
     });   
  
</script>  