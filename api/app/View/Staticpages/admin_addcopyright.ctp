<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i>Add Copyright</h1>
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
                    <div class="restaurants index">
                                        <?php echo $this->Form->create('Staticpage',array('id'=>'tab','type'=>'file')); ?>   
                    <div class="form-group">
                     
                      <input type="hidden" class="form-control" name="data[Staticpage][position]" value="copyright"> 
                    </div>
                    <div class="form-group">  
                        <label>Title</label>
                        <input type="text" name="data[Staticpage][title]" class="form-control span12">                        
                    </div>
           
        
                    <div class="form-group">
                        <label>Description</label>
                        <textarea rows="2" name="data[Staticpage][description]" class="form-control" id="edi" ></textarea>
                    </div>
		
					
                    <input type="hidden" name="data[Staticpage][created]" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>">
                    <input type="hidden" name="data[Staticpage][status]" class="form-control" value="1">

                <div class="btn-toolbar list-toolbar">
                    <button class="btn btn-primary" name="submit"><i class="fa fa-save"></i> Save</button>
                </div>
                    </form>
                    </div><!-- End Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.1.6/tinymce.min.js"></script>
    <script type="text/javascript">
    tinymce.init({
             selector: "#edi,#edi1",
             plugins : "media"

    });
    </script>