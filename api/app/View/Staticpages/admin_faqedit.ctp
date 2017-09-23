<style type="text/css">
    div.form-group select{
        width: 100% !important;
    }
    a.btn{
    border: none;
    border-radius: 0px;
    background-color: #CC0000;
    }
</style>
<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Edit Faq</h1>
                </div>
            </div>
                <div class="page_content">
                    <p>
            <?php $x=$this->Session->flash(); ?>
                    <?php if($x){ ?>
                    <div class="alert success">
                        <span class="icon"></span>
                    <strong>Success!</strong><?php echo $x; ?>
                    </div>
                    <?php } ?>
        </p>
                    <div class="col-sm-5">
                    <?php echo $this->Form->create('Staticpage',array('id'=>'tab','type'=>'file')); ?> 
                        <div class="restaurants index">
                        <div class="form-group"> 
                        <input type="hidden" class="form-control" value="faq" name="data[Staticpage][position]">
                                         
                    </div>
                    <div class="form-group">
                        <?php echo $this->Form->input('title',array('class'=>'form-control'));?>
                    </div>
					
					 <div class="form-group">
                        <?php echo $this->Form->input('title_ar',array('class'=>'form-control'));?>
                    </div>
                    <!--<div class="form-group">
                        <?php echo $this->Form->input('image',array('class'=>'form-control','type'=>'file'));?>      
                    </div-->
                    
              
                    <div class="form-group">
                        <?php echo $this->Form->input('description',array('class'=>'form-control','type'=>'textarea'));?>
                    </div>
					<div class="form-group">
                        <?php echo $this->Form->input('description_ar',array('class'=>'form-control','type'=>'textarea'));?>
                    </div>
                    <div class="form-group">
                      <label>Status</label><br>
                      <?php echo $this->Form->select('status',array('1'=>'Active','0'=>'Deactive'),
                       array('label'=>"",'class'=>'form-control','data-placeholder'=>'Choose a Name','empty'=>false)); ?>
                    </div>
                    <input type="hidden" class="form-control" name="data[Staticpage][created]" value="<?php echo date('Y-m-d H:i:s'); ?>">
                   

                <div class="btn-toolbar list-toolbar">
                    <button class="btn btn-primary" name="submit"><i class="fa fa-save"></i> Update</button>
                    <a href="<?php echo $this->Html->url(array('controller' => 'Staticpages', 'action' => 'admin_faqindex')); ?>" data-toggle="modal" class="btn btn-danger">Cancel</a>
                </div>
                        </div><!-- End Here -->
                        <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.1.6/tinymce.min.js"></script>
    <script type="text/javascript">
    tinymce.init({
             selector: "textarea",
             plugins : "media"
    });
    </script>