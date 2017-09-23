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
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo __('Add Product'); ?></h1>
                </div>
			</div>
			<div class="col-sm-5">
				 <?php echo $this->Form->create('Product', array('type' => 'file', 'id' => 'addpro')); ?>
				<div class="page_content">
					<div class="restaurants index"> 
						<?php 
                                                echo $this->Form->input('category_id', ['options' => $Category, 'label' => 'Category:', 'class' => 'form-control','id' => "parentcat", 'empty' => 'Choose category','required']);?> 
                                               
                                                <div class="input select"><label for="dishcatname">Sub Category:</label>   
                                                    <select name="data[Product][sub_cat_id]" class="form-control" id="subcat">
                                                   
                                                    </select>
                                                </div>
                                                 <?php 
                                              //  echo $this->Form->input('sub_cat_id', ['options' => $Category, 'label' => 'Category:', 'class' => 'form-control','id' => "dishcatname", 'empty' => 'Choose category']); 
                                                 echo $this->Form->input('attribute_id', ['options' => $attributes, 'label' => 'Attribute:','multiple'=>"multiple", 'class' => 'form-control','id' => "attributename", 'empty' => 'Choose attribute']);
                                                
						echo $this->Form->input('name',array('required' => true));
                                               echo $this->Form->input('description', array('class' => 'form-control'));
                			       echo $this->Form->input('image', array('type' => 'file', 'class' => 'form-control', 'label' => 'Image:'));?>
                                            <div class="input file">
                                               <label for="ProductGalleryImg">Gallery:</label> 
                                               <input type="file" name="data[Product][gallery_img][]" class="form-control" multiple="multiple" id="ProductGalleryImg">
                                           </div>  
                                            <?php   
                 
						echo $this->Form->input('price', array('class' => 'form-control','required'));
                                               echo $this->Form->input('min_price', array('class' => 'form-control','label' => 'Minimum Price','required'));
                                                echo $this->Form->input('weight', array('class' => 'form-control'));  
                                                echo $this->Form->input('view_isshow', array('type' => 'checkbox','label' => 'Customer Viewing'));  
                                               
                                               ?>
					</div>
				</div>
				<?php echo $this->Form->submit(__('Submit',true), array('class'=>'btn btn-primary'));  ?>
                                <?php echo $this->Form->end(); ?>
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