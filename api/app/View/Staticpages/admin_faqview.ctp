<?php echo $this->set('title_for_layout', $staticpage['Staticpage']['title']);
 ?>
<section class="admin_main-sec">
    <div class="sec_inner">
        <div class="row">
            <div class="col-md-12">
                <div class="page-headeing">
                    <h1 class="page-title"><i class="fa fa-bars" aria-hidden="true"></i><?php echo $staticpage['Staticpage']['title'];?></h1>
                </div>
                <div class="page_content">
                    <div class="restaurants index">
                    <div style="padding-left: 0px;" class="col-sm-3"> <img src="<?php echo $this->webroot."files/staticpage/".$staticpage['Staticpage']['image'];?>"  class="img-responsive" alt=""> </div>
                    <div class="col-sm-9" style="padding-right: 0px;">
            <h2><?php echo $staticpage['Staticpage']['title'];?></h2>
           <?php  echo $staticpage['Staticpage']['description'];?>         
            
          </div>
                    </div><!-- End Here -->
                </div>
            </div>
        </div>
    </div>
</section>